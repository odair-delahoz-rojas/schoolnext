<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 *  
 */

include "empleado/empleado_trait_call_backs.php";
include "empleado/empleado_trait_props.php";
include "empleado/empleado_trait_set_up.php";


#[AllowDynamicProperties]
class Empleado extends Usuario {

  use EmpleadoTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$pk = 'id';
    self::$_order_by_defa = 't.is_active DESC, t.apellido1, t.apellido2, t.nombres';
    $this->setUp();
  }

  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = new OdaDql('Usuario');

    $DQL->select("t.*")
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'usuario_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre')
      ->where('t.username<>t.documento')
      ->orderBy(self::$_order_by_defa);

    if (!is_null($estado)) { 
      $DQL->andWhere("t.is_active=$estado"); 
    }

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }

    return $DQL->execute(true);
  }
  


}