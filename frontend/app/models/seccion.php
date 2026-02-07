<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "seccion/seccion_trait_props.php";
include "seccion/seccion_trait_set_up.php";

#[AllowDynamicProperties]
class Seccion extends LiteRecord {

  use SeccionTraitSetUp;

  public function __construct()
  {
    parent::__construct();
    self::$table = Config::get('tablas.seccion');
    self::$pk = 'id';
    self::$_order_by_defa = 't.nombre';
    $this->setUp();
  }


}