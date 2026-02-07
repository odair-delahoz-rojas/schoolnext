<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
include "aspirante/aspirante_adjunto_trait_set_up.php";

#[AllowDynamicProperties]
class AspiranteAdjunto extends LiteRecord {
  use AspiranteAdjuntoTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.aspirantes_adjuntos');
    self::$pk = 'id';
    //self::$_order_by_defa = 'id, aspirante_id';
    $this->setUp();
  }
  


}