<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "registros/registro_desemp_acad_trait_props.php";
include "registros/registro_desemp_acad_trait_set_up.php";

#[AllowDynamicProperties]
class RegistroDesempAcad extends LiteRecord {

  use RegistroDesempAcadTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_academ');
    self::$pk = 'id';
    self::$_order_by_defa = 't.estudiante_id, t.fecha DESC';
    $this->setUp();
  }

  
  public function getByAnnioEstudiante(
    int $annio, 
    int $estudiante_id
  ) {
    try 
    {
      $sufijo = ($annio!=self::$_annio_actual) ? '_'.$annio : '' ;

      $DQL = new OdaDql('RegistroDesempAcad');
      $DQL->setFrom(self::$table.$sufijo);

      $DQL->select('t.periodo_id, t.fortalezas, t.dificultades, t.compromisos, t.fecha, t.acudiente, t.foto_acudiente, t.director, t.foto_director')
          ->concat(['u.apellido1', 'u.apellido2', 'u.nombres'], 'creador_nombre')
          ->leftJoin('usuario', 'u', 't.created_by = u.id')
          ->where('t.estudiante_id=?')
          ->orderBy('t.periodo_id, t.fecha DESC');
      $DQL->setParams([$estudiante_id]);
      return $DQL->execute();
    
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }

  
  public function getByAnnioSalon(int $annio, int $salon_id) 
  {
    $sufijo = ($annio!=self::$_annio_actual) ? "_{$annio}" : '' ;

    $DQL = new OdaDql('RegistroDesempAcad');
    $DQL->setFrom(self::$table.$sufijo);
    
    $DQL->select('t.*')
        ->addSelect('s.nombre as salon_nombre')
        ->concat(['e.apellido1', 'e.apellido2', 'e.nombres'], 'estudiante_nombre')
        ->concat(['u.apellido1', 'u.apellido2', 'u.nombres'], 'creador_nombre')
        ->leftJoin('salon', 's')
        ->leftJoin('estudiante', 'e')
        ->leftJoin('usuario', 'u', 't.created_by = u.id')
        ->where('t.salon_id = ?')
        ->orderBy('t.annio, t.grado_id, e.apellido1, e.apellido2, e.nombres, t.fecha DESC');
    $DQL->setParams([$salon_id]);
    return $DQL->execute();
  }


  public function getRegistrosProfesor(int $user_id) 
  {
    $DQL = new OdaDql('RegistroDesempAcad');
    $DQL->select('t.*, s.nombre as salon_nombre')
        ->concat(['e.nombres','e.apellido1','e.apellido2'],  'estudiante_nombre')
        ->concat(['u.nombres','u.apellido1','u.apellido2'],  'usuario_nombre')
        ->leftJoin('estudiante', 'e')
        ->leftJoin('salon', 's')
        ->leftJoin('usuario', 'u', 't.created_by=u.id');
    if ($user_id<>1) {
      $DQL->where("t.created_by = ?");
      $DQL->setParams([$user_id]);
    }
    $DQL->orderBy('t.fecha DESC');
    return $DQL->execute();
  }
  

  public function getRegistrosDirector(int $user_id) 
  {
    $Grupos = (new Usuario)->misGrupos();
    $RegSalones = [];
    foreach ($Grupos as $salon) {
      $RegSalones[] = "'$salon->id'";
    }
    $salones = implode(",", $RegSalones);

    $DQL = new OdaDql('RegistroDesempAcad');
    $DQL->setFrom(Config::get('tablas.estud_reg_academ'));
    $DQL->select('t.*, s.nombre as salon_nombre')
        ->concat(['e.nombres','e.apellido1','e.apellido2'],  'estudiante_nombre')
        ->concat(['u.nombres','u.apellido1','u.apellido2'],  'usuario_nombre')
        ->leftJoin('estudiante', 'e')
        ->leftJoin('salon', 's')
        ->leftJoin('usuario', 'u', 't.created_by=u.id');
    if ($user_id<>1) {
      $DQL->where("t.salon_id in(".$salones.")");
    }
    $DQL->orderBy('t.fecha DESC');
    
    return $DQL->execute();
  }
  

  public function saveWithPhoto($data) 
  {
    $this->begin();
    if ($this->update($data)) {
      if ($this->updatePhoto($this->id)) {
        $this->commit();
        return true;
      }
    }
    $this->rollback();
    return false;
  }

  
  public function createWithPhoto($data) {
    $this->begin();
    if ($this->create($data)) {
      if ($this->updatePhoto($this->lastInsertId())) {
        $this->commit();
        return true;
      }
    }
    $this->rollback();
    return false;
  }

  public function updatePhoto($id) 
  {
    if ($foto_acudiente = $this->uploadPhoto('foto_acudiente')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
      $this->foto_acudiente = $foto_acudiente;
      Session::set('foto_acudiente',$foto_acudiente);
    }

    if ($foto_director = $this->uploadPhoto('foto_director')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
        $this->foto_director = $foto_director;
        Session::set('foto_director',$foto_director);
    }

    $reg = (new RegistroDesempAcad)::get($id);
    $reg->save([
      'foto_acudiente' => $foto_acudiente,
      'foto_director'  => $foto_director,
    ]);
    return true;
  }
  

  public function uploadPhoto($imageField)  
  {
    $file = Upload::factory($imageField, 'file');
    $file->setExtensions(array('jpg', 'png', 'gif', 'jpeg'));
    if ($file->isUploaded()) {
      return $file->saveRandom('estud_reg_des_aca_com');
    }
    return false;
  }  

  
  public function cambiarSalonEstudiante(int $nuevo_salon_id, int $nuevo_grado_id, int $estudiante_id) 
  {
    $this::query("UPDATE ".self::$table." SET salon_id=$nuevo_salon_id, grado_id=$nuevo_grado_id WHERE estudiante_id=$estudiante_id")->rowCount() > 0;
  }



}