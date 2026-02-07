<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "plantilla/plantilla_trait_props.php";
include "plantilla/plantilla_trait_set_up.php";

#[AllowDynamicProperties]
class Plantilla extends LiteRecord 
{
  use PlantillaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.plantillas');
    self::$pk = 'id';
    self::$_order_by_defa = 't.nombre';      
    $this->setUp();
  }



}