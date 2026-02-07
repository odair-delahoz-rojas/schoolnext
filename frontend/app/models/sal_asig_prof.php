<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "carga/sal_asig_prof_trait_links.php";
include "carga/sal_asig_prof_trait_props.php";
include "carga/sal_asig_prof_trait_set_up.php";

#[AllowDynamicProperties]
class SalAsigProf extends LiteRecord {

  use TraitUuid, TraitForms, TraitValidar;
  use SalAsigProfTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.salon_asignat_profe');
    self::$pk = 'id';
    self::$_order_by_defa = 't.user_id, t.salon_id, t.asignatura_id';
    $this->setUp();
  }
  
  
  public function getSalonesAsignaturas(int $user_id) 
  {
    try {
      $DQL = (new OdaDql('SalAsigProf'))
        ->select('t.salon_id, t.asignatura_id');

      if ($user_id<>1)
      {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
      }
      return $DQL->execute();

    } catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = (new OdaDql('SalAsigProf'))
      ->select('t.*')
      ->addSelect('s.nombre as salon_nombre, s.grado_id, s.tot_estudiantes')
      ->addSelect('a.nombre as asignatura_nombre')
      ->addSelect('g.nombre as grado_nombre')
      ->addSelect('u.nombres, u.apellido1, u.apellido2')
      ->concat(['u.nombres','u.apellido1', 'u.apellido2'], 'user_nombre')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      ->leftJoin('asignatura', 'a')
      ->leftJoin('usuario', 'u', 't.user_id=u.id')
      ->where('s.is_active=1')
      ->orderBy('salon_nombre, asignatura_nombre');
    return $DQL->execute();
  }


  public function getSalones_ByProfesor(int $user_id) 
  {
    try {
      $DQL = (new OdaDql('SalAsigProf'));
      $DQL->setFrom(self::$table);
      $DQL->select('DISTINCT t.salon_id');
      if ($user_id<>1) 
      {
        $DQL->where('t.user_id=?')
            ->setParams([$user_id]);
      }      
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  
  public function getCarga(int $user_id) 
  {
    try {
      $DQL = (new OdaDql('SalAsigProf'))
        ->select('t.*')
        ->addSelect('s.nombre as salon_nombre, s.grado_id, s.tot_estudiantes')
        ->addSelect('a.nombre as asignatura_nombre')
        ->addSelect('g.nombre as grado_nombre')
        ->addSelect('u.nombres, u.apellido1, u.apellido2')
        ->concat(['u.nombres','u.apellido1', 'u.apellido2'], 'profesor_nombre')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->leftJoin('asignatura', 'a')
        ->leftJoin('usuario', 'u', 't.user_id=u.id')
        ->where('s.is_active=1')
        ->orderBy('asignatura_nombre, salon_nombre');

      $ArrGestionCarga = INSTITUTION_KEY === 'windsor'
          ? ['admin']
          : ['admin', 'secretaria', 'coordinadores'];

      if (!in_array((string)Session::get('roll'), $ArrGestionCarga) ) 
      {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
      }
      return $DQL->execute();
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getStats(int $user_id) 
  {
    $DQL = (new OdaDql('SalAsigProf'))
      ->addSelect('DISTINCT s.grado_id, t.salon_id, t.asignatura_id, ga.intensidad')
      ->leftJoin('salon', 's', 't.salon_id')
      ->where('s.is_active=1');
    if ($user_id<>1)
    {
      $DQL->andWhere('t.user_id=?');
      $DQL->setParams([$user_id]);
    }
    return $DQL->execute();
  }
  
  
  public function getProfesor(int $salon_id, int $asignatura_id) 
  {    
    $DQL = (new OdaDql('SalAsigProf'));
    $DQL->select('t.*');
  }

 
}