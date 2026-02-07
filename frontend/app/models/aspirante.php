<?php
/**
 * Modelo  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
include "aspirante/aspirante_trait_props.php";
include "aspirante/aspirante_trait_set_up.php";

#[AllowDynamicProperties]
class Aspirante extends LiteRecord {
  use AspiranteTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.aspirante');
    self::$pk = 'id';
    self::$_order_by_defa = 't.is_active DESC,t.fecha_insc DESC, t.estatus,t.grado_aspira,t.apellido1,t.apellido2,t.nombres';
    $this->setUp();
  }
  

  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = (new OdaDql(__CLASS__))
        ->select($select)
        ->concat(['apellido1, " ", apellido2, " ", nombres'], 'aspirante_nombre')
        ->addSelect('t.grado_aspira, g.nombre as aspirante_grado')
        ->leftJoin('grado', 'g', 't.grado_aspira = g.id')
        ->orderBy(self::$_order_by_defa);
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }

    return $DQL->execute();
  }
  
  
  public static function trasladar(int $id) 
  {
    $Aspirante = (new Aspirante)::get($id);
    $table_apsico = Config::get('tablas.aspirantes_psico');
    $AspirantePsico = (new AspirantePsico)::first("SELECT * FROM $table_apsico WHERE aspirante_id = ?", [$id]);
     
    if ($Aspirante && $AspirantePsico)
    {
      $Grado = (new Grado)::get($Aspirante->grado_aspira);       
      $tabla_estud = Config::get('tablas.estudiante');
      $Estud = (new Estudiante())::first("SELECT * FROM {$tabla_estud} WHERE documento=?", [$Aspirante->documento]);
       
      //================================================================
      // 1) Crear Estudiante
      $tipo_doc = ('RC'==$Aspirante->tipo_dcto) ? 'Registro Civil': 'Tarjeta de Identidad';
      $annio_actual = (int)Session::get('annio');
      $annio_matriculas = $annio_actual + 1;
      $data = [ 
        'uuid' => $AspirantePsico->xxh3Hash(),
        'nombres' => $Aspirante->nombres, 
        'apellido1' => $Aspirante->apellido1, 
        'apellido2' => $Aspirante->apellido2,  
        'documento' => $Aspirante->documento, 
        'tipo_dcto' => $tipo_doc, 
        'fecha_nac' => $Aspirante->fecha_nac, 
        'direccion' => $Aspirante->direccion, 
        'barrio'    => $Aspirante->barrio, 
        'telefono1' => $Aspirante->telefono1, 
        'telefono2' => $Aspirante->telefono2, 
        'is_debe_preicfes' => 0, 
        'is_debe_almuerzos' => 0, 
        'is_deudor' => 0, 
        'is_habilitar_mat' => 1, 
        'annio_pagado' => $annio_actual, 
        'mes_pagado' => 11, 
        'annio_promovido' => $annio_matriculas,

        'grado_promovido' => $Aspirante->grado_aspira, 
        'grado_mat' => $Aspirante->grado_aspira, 
        'salon_id' => $Grado->salon_default, 
        'numero_mat' => '', 
        'contabilidad_id' => 0, 
        'sexo' => $Aspirante->sexo, 
        'retiro' => '', 
        'email_instit' => '', 
        'clave_instit' => '',         
        'is_active' => 1, 
        'created_at' => date('Y-m-d H:i:s', time()), 
        'updated_at' => date('Y-m-d H:i:s', time()), 
        'created_by' => Session::get('id'), 
        'updated_by' => Session::get('id'), 
      ];

      $estudiante_id = 0;
      if (!$Estud) { 
        $DQL = new OdaDql('Estudiante');
        $DQL->setFrom('sweb_estudiantes');
        $DQL->insert($data)
            ->execute();
        $LastInsertId = $DQL->getLastInsertId();
        $estudiante_id = $LastInsertId->last_id;
      } else {
        $estudiante_id = $Estud->id;
        $data['id'] = $estudiante_id;
        $DQL = new OdaDql('Estudiante');
        $DQL->setFrom('sweb_estudiantes');
        $DQL->update($data)
            ->execute();
      }

      // 2) Crear DatosEstud
      $data = [ 
        'estudiante_id' => $estudiante_id, 
        'pais_nac' => $Aspirante->pais_nac, 
        'depto_nac' => $Aspirante->depto_nac, 
        'ciudad_nac' => $Aspirante->ciudad_nac, 
        'madre' => $Aspirante->madre, 
        'madre_id' => $Aspirante->madre_id, 
        'madre_tel_1' => $Aspirante->madre_tel_per, 
        'madre_tel_2' => $Aspirante->madre_tel_ofi, 
        'madre_email' => $Aspirante->madre_email, 
        'madre_ocupa' => $Aspirante->madre_cargo, 
        'madre_lugar_tra' => $Aspirante->madre_empresa, 
        'padre' => $Aspirante->Padre, 
        'padre_id' => $Aspirante->padre_id, 
        'padre_tel_1' => $Aspirante->padre_tel_per, 
        'padre_tel_2' => $Aspirante->padre_tel_ofi, 
        'padre_email' => $Aspirante->padre_email, 
        'padre_ocupa' => $Aspirante->padre_cargo, 
        'padre_lugar_tra' => $Aspirante->padre_empresa, 
        'created_at' => date('Y-m-d H:i:s', time()), 
        'updated_at' => date('Y-m-d H:i:s', time()), 
        'created_by' => Session::get('id'), 
        'updated_by' => Session::get('id'), 
      ];
      $DQL = new OdaDql('DatosEstud');
      $DQL->setFrom('sweb_datosestud');
      $DQL->insert($data)
          ->execute();


      // 3) Crear sweb_estudiante_adjuntos
      $data = [ 
        'estudiante_id' => $estudiante_id, 
        'created_at' => date('Y-m-d H:i:s', time()), 
        'updated_at' => date('Y-m-d H:i:s', time()), 
        'created_by' => Session::get('id'), 
        'updated_by' => Session::get('id'), 
      ];
      $DQL = new OdaDql('EstudianteAdjuntos');
      $DQL->setFrom('sweb_estudiante_adjuntos');
      $DQL->insert($data)
          ->execute();

      // 5) Crear Usuario Madre
      /*
       $data = [
        'uuid' => $Aspirante->xxh3Hash(), 
        'username' => $Aspirante->madre_id, 
        'roll' => 'padres', 
        'nombres' => $Aspirante->madre, 
        'apellido1' => '', 
        'apellido2' => '', 
        'documento' => $Aspirante->madre_id, 
        'email' => $Aspirante->madre_email, 
        'telefono1' => $Aspirante->madre_tel_per, 
        'telefono2' => $Aspirante->madre_tel_ofi, 
        'algorithm' => 'sha1', 
        'salt' => '', 
        'password' => '', 
        'is_super_admin' => 0, 
        //'last_login' => '', 
        //'forgot_password_code' => '', 
        'is_active' => 1, 
        'created_at' => date('Y-m-d H:i:s', time()), 
        'updated_at' => date('Y-m-d H:i:s', time()), 
      ];
      */

      // $DQL = new OdaDql('Usuario');
      // $DQL->setFrom('dm_user');
      // $DQL->insert([$data])->execute(true);
      
      // 6) Crear Usuario Padre      
      // 7) Crear Registro Usuario-Estudiante

      // 8) Actualizar estatus Aspirante
      $DQL = new OdaDql('Aspirante');
      $DQL->setFrom(Config::get('tablas.aspirantes'));
      $DQL->update(['estatus' => AspirEstatus::Trasladado->name])
          ->where('id=?')->setParams([$Aspirante->id]);
      $DQL->execute();
      
    }
    else 
    {
      OdaFlash::warning('Algo falló');
    }

  }



}