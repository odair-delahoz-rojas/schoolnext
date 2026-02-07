<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "psicologia/psico_remision_trait_props.php";
include "psicologia/psico_remision_trait_set_up.php";

#[AllowDynamicProperties]
class PsicoRemision extends LiteRecord 
{
  use PsicoRemisionTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.psico_remision');
    self::$pk = 'id';
    self::$_order_by_defa = 't.fecha, t.estado, t.estudiante_id, t.remite_id';
    $this->setUp();
  }



}