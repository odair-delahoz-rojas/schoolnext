<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "estudiante/estudiante_adjuntos_trait_correcciones.php";
include "estudiante/estudiante_adjuntos_trait_props.php";
include "estudiante/estudiante_adjuntos_trait_set_up.php";


#[AllowDynamicProperties]
class EstudianteAdjuntos extends LiteRecord 
{

  use EstudianteAdjuntosTraitSetUp;

  public function __construct() 
  {
    parent::__construct();

    self::$table = Config::get('tablas.estud_adjuntos');
    self::$pk = 'id';
    
    $this->setUp();
  }
  


}