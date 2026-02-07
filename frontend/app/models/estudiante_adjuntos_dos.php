<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "estudiante/estudiante_adjuntos_dos_trait_set_up.php";
include "estudiante/estudiante_adjuntos_dos_trait_correcciones.php";

 #[AllowDynamicProperties]
class EstudianteAdjuntosDos extends LiteRecord {

  use EstudianteAdjuntosDosTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.estud_adjuntos_dos');
    self::$pk = 'id';
    $this->setUp();
  }


}