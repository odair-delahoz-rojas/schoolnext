<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "registros/registros_gen_trait_links.php";
include "registros/registros_gen_trait_props.php";
include "registros/registros_gen_trait_set_up.php";

#[AllowDynamicProperties]
class RegistrosGen extends LiteRecord {

  use RegistrosGenTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_obs_gen');
    self::$pk = 'id';
    $this->setUp();
    self::$_order_by_defa = 't.annio, t.grado_id, t.estudiante_id, t.fecha DESC, ';
  }  

  
  public function getByAnnioEstudiante(
    int $annio, 
    int $estudiante_id
  ) {
    try 
    {
      $sufijo = ($annio != self::$_annio_actual) ? '_'.$annio : '' ;
  
      $RegGen = new RegistrosGen();
      $DQL = new OdaDql(__CLASS__);
      $DQL->setFrom(self::$table.$sufijo);
      
      $DQL->select('t.id, t.tipo_reg, t.periodo_id, t.grado_id, t.salon_id, t.fecha, 
                  t.asunto, t.acudiente, t.foto_acudiente, t.director, t.foto_director')
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



  public function getRegistrosProfesor(int $user_id) 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, s.nombre as salon_nombre')
        ->concat(['e.nombres','e.apellido1','e.apellido2'],  'estudiante_nombre')
        ->concat(['u.nombres','u.apellido1','u.apellido2'],  'usuario_nombre')
        ->leftJoin('estudiante', 'e')
        ->leftJoin('salon', 's')
        ->leftJoin('usuario', 'u', 't.created_by=u.id');
    if ($user_id<>1) {
      $DQL->where("t.created_by=?");
      $DQL->setParams([$user_id]);
    }
    $DQL->orderBy('t.fecha DESC');
    return $DQL->execute();
  }
  
  
  public function saveWithPhoto($data) 
  {
    try {
      $this->begin();
      if ($this->update($data)) {
        if ($this->updatePhoto($this->id)) {
          $this->commit();
          return true;
        }
      }
      $this->rollback();
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  
  public function createWithPhoto($data) 
  {
    try {
      $this->begin();
      if ($this->create($data)) {
        if ($this->updatePhoto($this->lastInsertId())) {
          $this->commit();
          return true;
        }
      }
      $this->rollback();
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  public function updatePhoto($id) 
  {
    // if ($foto_acudiente = $this->uploadPhoto('foto_acudiente')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
    //   $this->foto_acudiente = $foto_acudiente;
    //   Session::set('foto_acudiente',$foto_acudiente);
    // }
    try {
      if ($foto_director = $this->uploadPhoto('foto_director')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
        $this->foto_director = $foto_director;
        Session::set('foto_director',$foto_director);
      }
      $reg = (new RegistrosGen)::get($id);
      $reg->save([
        //'foto_acudiente' => $foto_acudiente,
        'foto_director'  => $foto_director,
      ]);
      return true;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    
  }
  

  public function uploadPhoto($imageField)  
  {
    try {
      $file = Upload::factory($imageField, 'file');
      $file->setExtensions(array('jpg', 'png', 'gif', 'jpeg'));
      if ($file->isUploaded()) {
        return $file->saveRandom('estud_reg_observ_gen');
      }
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  
  public function getByAnnioSalon(
    int $annio, 
    int $salon_id
  ) {
    try {
      $sufijo = ($annio != self::$_annio_actual) ? '_'.$annio : '' ;
  
      $RegGen = new RegistrosGen();
      $DQL = new OdaDql(__CLASS__);
      $DQL->setFrom(self::$table.$sufijo);
      
      $DQL->select('t.*')
          ->addSelect('s.nombre as salon_nombre')
          ->concat(['e.apellido1', 'e.apellido2', 'e.nombres'], 'estudiante_nombre')
          ->concat(['u.apellido1', 'u.apellido2', 'u.nombres'], 'creador_nombre')
          ->leftJoin('salon', 's')
          ->leftJoin('estudiante', 'e')
          ->leftJoin('usuario', 'u', 't.created_by = u.id')
          ->where('t.salon_id=?')
          ->orderBy('t.annio, t.grado_id, e.apellido1, e.apellido2, e.nombres, t.fecha DESC');
      $DQL->setParams([$salon_id]);
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
    

  public function cambiarSalonEstudiante(
    int $nuevo_salon_id, 
    int $nuevo_grado_id, 
    int $estudiante_id
  ) {
    // cambiar por instrucciones DQL
    $this::query(
      "UPDATE ".self::$table
      ." SET salon_id=$nuevo_salon_id, grado_id=$nuevo_grado_id 
         WHERE estudiante_id=$estudiante_id"
      )->rowCount() > 0;
  }



}