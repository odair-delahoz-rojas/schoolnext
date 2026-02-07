<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "estudiante/datos_estud_trait_props.php";
include "estudiante/datos_estud_trait_set_up.php";


#[AllowDynamicProperties]
class DatosEstud extends LiteRecord {
    use DatosEstudTraitSetUp;
    
    public function __construct() 
    {
      parent::__construct();
      self::$table = Config::get('tablas.datosestud');
      self::$pk = 'id';
      $this->setUp();  
    }
    
    
  }
 