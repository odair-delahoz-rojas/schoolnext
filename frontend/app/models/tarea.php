<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "tarea/tarea_trait_props.php";
include "tarea/tarea_trait_set_up.php";

#[AllowDynamicProperties]
class Tarea extends LiteRecord {

  use TareaTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.tareas');
    self::$pk = 'id';
    self::$_order_by_defa = 't.estado, t.prioridad, t.avance, t.nombre';
    $this->setUp();
  }



}