<?php
/**
 * Modelo
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "grado/grado_asignatura_trait_set_up.php";

#[AllowDynamicProperties]
class GradoAsignatura extends LiteRecord {

  use GradoAsignaturaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.grados_asignat');
    self::$pk = 'id';
    self::$_order_by_defa = 't.orden';
    $this->setUp();
  }


  public function getByGrado(int $grado_id) 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre AS grado_nombre, a.nombre AS asignatura_nombre, a.abrev AS asignatura_abrev')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.grado_id = ?')
        ->setParams([$grado_id])
        ->orderBy(self::$_order_by_defa);        
    return $DQL->execute();
  }

  
}