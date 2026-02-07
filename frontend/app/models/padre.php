<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "padre/padre_trait_estudiantes.php";
include "padre/padre_trait_set_up.php";


#[AllowDynamicProperties]
class Padre extends LiteRecord {

  use PadreTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$pk = 'id';
    self::$_order_by_defa = 't.username';
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

    $DQL = new OdaDql(__CLASS__);

    $DQL->select($select)
        ->where('t.username=t.documento')
        ->orderBy(self::$_order_by_defa);

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }

    if (!is_null($estado)) { 
      $DQL->AndWhere('t.is_active=?')
          ->setParams([$estado]);
    }

    return $DQL->execute();
  }


  
}