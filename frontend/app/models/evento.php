<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "evento/evento_trait_set_up.php";


#[AllowDynamicProperties]
class Evento extends LiteRecord {

  use EventoTraitSetUp;

  public function __construct() 
  {
    parent::__construct(); 
    self::$table = Config::get('tablas.evento');
    self::$pk = 'id';
    self::$_order_by_defa = 't.fecha_desde';
    $this->setUp();
  }
  

  public function getEventosDashboard() 
  {
    $desde = (new DateTime())->sub(new DateInterval('P1W'))->format('Y-m-d');
    $hasta = (new DateTime())->add(new DateInterval('P3W'))->format('Y-m-d');

    $DQL = new OdaDql(__CLASS__);

    $DQL->select('t.*')
        ->where('(fecha_desde BETWEEN ? AND ?) OR (fecha_hasta BETWEEN ? AND ?)')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$desde, $hasta, $desde, $hasta]);

    return $DQL->execute();
  }



}