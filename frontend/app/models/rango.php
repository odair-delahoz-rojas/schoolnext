<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "rango/rango_trait_set_up.php";

#[AllowDynamicProperties]
class Rango extends LiteRecord {

  use RangoTraitSetUp;

  private $invalidMessages = [
    0 => '',
    1 => 'Rango no válido: Inferior a Cero',
    2 => 'Rango no válido: Superior a ',
  ];


  public function __construct() 
  {
    parent::__construct();
    self::$pk = 'id';
    self::$table = Config::get('tablas.rangos');
    $this->setUp();
  }

  #[\Deprecated(message: "use getRangoNota")]
  public static function getRango(int $valor=0): string 
  {
    return (new Rango())->getRangoNota($valor);
  }
  
  #[\Deprecated(message: "use getColorNota")]
  public static function getColorRango(int $valor=0): string 
  {
    return (new Rango())->getColorNota($valor);
  }
  

  public function getLimiteInferior(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT limite_inferior FROM " .self::$table ." WHERE nombre = :label", [":label" => $rango->label()]);
    return $este_rango->limite_inferior;
  }

  public function getLimiteSuperior(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT limite_superior FROM " .self::$table ." WHERE nombre = :label", [":label" => $rango->label()]);
    return $este_rango->limite_superior;
  }

  public function getColor(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT color_rango FROM " .self::$table ." WHERE nombre = :label", [":label" => $rango->label()]);
    return $este_rango->color_rango;
  }


  public function validar(int $valor = 0)
  {
    if ($valor==0)
    {
      return 0;
    }

    if ($valor < 0) 
    {
      return 1;
    }

    $valor_maximo = $this->getLimiteSuperior(Rangos::Superior);
    if($valor > $valor_maximo)
    {
      return 2;
    }

    return 3;
  }

  public function getColorNota(int $valor = 0)
  {
    $validacion = $this->validar($valor);
    if ($validacion < 3)
    {
      return $this->invalidMessages[$validacion];
    }

    $este_rango = self::first("SELECT color_rango FROM " .self::$table ." WHERE limite_inferior <= :lim_inf AND limite_superior > :lim_sup", [":lim_inf" => $valor, ":lim_sup" => $valor]);
    return $este_rango->color_rango;
  }

  public function getRangoNota(int $valor = 0)
  {
    $validacion = $this->validar($valor);
    if ($validacion < 3)
    {
      return $this->invalidMessages[$validacion];
    }

    $este_rango = self::first("SELECT nombre FROM " .self::$table ." WHERE :lim_inf >= limite_inferior AND :lim_sup < (limite_superior+0.999)", [":lim_inf" => $valor, ":lim_sup" => $valor]);
    return $este_rango->nombre;
  }

  public function showTablaRangos(): string
  {
    $Rangos = (new Rango())->all();
    $tabla = new OdaTable();
    $tabla->setCaption('<b>TABLA DE RANGOS</b>');
    foreach ($Rangos as $key => $itemRango) {
      $tabla->addRow(["{$itemRango->limite_inferior}-{$itemRango->limite_superior}", strtoupper($itemRango->nombre)]);
    }
    return $tabla;
  }

}