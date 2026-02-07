<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 *
*/

include "periodo/periodo_trait_set_up.php";

#[AllowDynamicProperties]
class Periodo extends LiteRecord {

  use PeriodoTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.periodos');
    self::$pk = 'id';
    $this->setUp();
  }
  
  public function getPeriodoActual($periodo=null) 
  {
    $pk = (!is_null($periodo)) ? $periodo : self::$_periodo_actual;
    return $this->get($pk);
  }


}