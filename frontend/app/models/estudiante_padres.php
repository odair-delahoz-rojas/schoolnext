<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "estudiante/estudiante_padres_trait_set_up.php";


#[AllowDynamicProperties]
class EstudiantePadres extends LiteRecord 
{
  
  use EstudiantePadresTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get(var: 'tablas.usuarios_estudiantes');
    self::$pk = 'id';
    $this->setUp();
  }

  
  public function getPadres(int $estudiante_id): array 
  {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select( 't.dm_user_id as id')
        ->where( 't.estudiante_id=?')->setParams(params: [$estudiante_id]);
    return $DQL->execute();
  }
  
  
  public function getHijos(int $padre_id): array 
  {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select('t.estudiante_id as id')
        ->where('t.dm_user_id=?')->setParams(params: [$padre_id]);
    return $DQL->execute();
  }
  

  public function vincularPadresHijos(int $estudiante_id)
  {
    try {
      $RegEstud = (new Estudiante)::get($estudiante_id);
      if ($RegEstud) 
      {
        // Existe Estudiante
        OdaLog::debug('Existe Estudiante id: '.$RegEstud->id);
        $source  =  Config::get('tablas.datosestud');
        $sql = "SELECT * FROM $source WHERE estudiante_id = ?";
        $RegEstudDetalle = static::query($sql, [$estudiante_id])->fetch();
        
        // Existe usuario madre ???
        $source  =  Config::get('tablas.usuario');
        $sql = "SELECT * FROM $source WHERE documento = ?";
        $regUserMadre = static::query($sql, [$RegEstudDetalle->madre_id])->fetch();
        if ($regUserMadre->id)
        {
          OdaLog::debug('La madre ya existe usuario id: '.$regUserMadre->id);
          // Usuario de la madre ya estaba creado
          // está viculado Madre-Estudiante ???
          $source  =  Config::get('tablas.usuarios_estudiantes');
          $sql = "SELECT * FROM $source WHERE dm_user_id = ? AND estudiante_id=?";
          $regMadreEstud = static::query($sql, [$regUserMadre->id, $RegEstud->id])->fetch();
          if (!$regMadreEstud->id) 
          { // crear vinculo
            OdaLog::debug('Vinculando Madre id: '.$regUserMadre->id.' con Estudiante id: '.$RegEstud->id);
            $MadreEstud = new EstudiantePadres();
            $MadreEstud->create(
              [
                'dm_user_id' => $regUserMadre->id, 
                'estudiante_id' => $RegEstud->id,
                'relacion' => 'Madre',
                'created_at'=>'',
                'updated_at'=>'',
                ]
              );
          }
        }
        else 
        {
          // se debe crear usuario madre
          OdaLog::debug('Se va a crear usuario madre documento: '.$RegEstudDetalle->madre_id);
          $Usuario = new Usuario();
          $Usuario->create([
            'uuid' => ($Usuario->xxh3Hash()),
            'username'=>$RegEstudDetalle->madre_id, 
            'roll'=>'padres', 
            'nombres'=>$RegEstudDetalle->madre, 
            'apellido1'=>'', 
            'apellido2'=>'', 
            'direccion'=>$RegEstudDetalle->madre_dir, 
            'documento'=>$RegEstudDetalle->madre_id, 
            'email'=> ($RegEstudDetalle->madre_email ?? $RegEstudDetalle->madre_tel_1.'@mimail.com'), 
            'telefono1'=>$RegEstudDetalle->madre_tel_1, 
            'telefono2'=>$RegEstudDetalle->madre_tel_2, 
            'cargo'=>$RegEstudDetalle->madre_ocupa, 
            'sexo'=>'F',
            'theme'=>'dark',
            'algorithm'=>'sha1',
            'created_at'=>'',
            'updated_at'=>'',
            'is_active'=>1,
          ]);
          $Usuario->setPassword();
          OdaLog::debug('Usuario madre creado id: '.$Usuario->id);

          OdaLog::debug('Crear relación Estudiante-Madre id: '.$Usuario->id);
          $RelMadreEstud = new EstudiantePadres();
          $RelMadreEstud->create(
            [
              'dm_user_id' => $Usuario->id, 
              'estudiante_id' => $RegEstud->id,
              'relacion' => 'Madre',
              'created_at'=>'',
              'updated_at'=>'',
              ]
            );
          OdaLog::debug('Relación Estudiante-Madre creada id: '.$RelMadreEstud->id);
        }


        // Existe usuario padre ???
        $source  =  Config::get('tablas.usuario');
        $sql = "SELECT * FROM $source WHERE documento = ?";
        $regUserPadre = static::query($sql, [$RegEstudDetalle->padre_id])->fetch();
        if ($regUserPadre->id) 
        {
          OdaLog::debug('El padre ya existe usuario id: '.$regUserPadre->id);
          // está viculado Madre-Estudiante ???
          $source  =  Config::get('tablas.usuarios_estudiantes');
          $sql = "SELECT * FROM $source WHERE dm_user_id = ? AND estudiante_id=?";
          $regPadreEstud = static::query($sql, [$regUserPadre->id, $RegEstud->id])->fetch();
          if (!$regPadreEstud->id) 
          { // crear vinculo
            OdaLog::debug('Vinculando Padre id: '.$regUserPadre->id.' con Estudiante id: '.$RegEstud->id);
            $PadreEstud = new EstudiantePadres();
            $PadreEstud->create(
              [
                'dm_user_id' => $regUserPadre->id, 
                'estudiante_id' => $RegEstud->id,
                'relacion' => 'Padre',
                'created_at'=>'',
                'updated_at'=>'',
                ]
              );
            }
        }
        else 
        {
          // se debe crear usuario PADRE
          OdaLog::debug('Se va a crear usuario padre documento: '.$RegEstudDetalle->padre_id);
          $Usuario = new Usuario();
          $Usuario->create([
            'uuid' => ($Usuario->xxh3Hash()),
            'username'=>$RegEstudDetalle->padre_id, 
            'roll'=>'padres', 
            'nombres'=>$RegEstudDetalle->padre, 
            'apellido1'=>'', 
            'apellido2'=>'', 
            'direccion'=>$RegEstudDetalle->padre_dir, 
            'documento'=>$RegEstudDetalle->padre_id,
            'email'=> ($RegEstudDetalle->padre_email ?? $RegEstudDetalle->padre_tel_1.'@mimail.com'),
            'telefono1'=>$RegEstudDetalle->padre_tel_1, 
            'telefono2'=>$RegEstudDetalle->padre_tel_2, 
            'cargo'=>$RegEstudDetalle->padre_ocupa, 
            'sexo'=>'M',
            'theme'=>'dark',
            'algorithm'=>'sha1',
            'created_at'=>'',
            'updated_at'=>'',
            'is_active'=>1,
          ]);
          $Usuario->setPassword();
          OdaLog::debug('Usuario padre creado id: '.$Usuario->id);

          OdaLog::debug('Se va a crear relación Estudiante-Padre id: '.$Usuario->id);
          $RelPadreEstud = new EstudiantePadres();
          $RelPadreEstud->create(
            [
              'dm_user_id' => $Usuario->id, 
              'estudiante_id' => $RegEstud->id,
              'relacion' => 'Padre',
              'created_at'=>'',
              'updated_at'=>'',
              ]
            );
          OdaLog::debug('Relación Estudiante-Padre creada id: '.$RelPadreEstud->id);
        }
      }
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

  }


  
}