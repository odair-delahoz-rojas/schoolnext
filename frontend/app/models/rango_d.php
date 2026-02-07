<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "rango/rango_trait_set_up_d.php";

class RangoD extends LiteRecord 
{
  public int $rowid; // int(11) AUTO_INCREMENT
  public string $ref; // varchar(128)
  public ?string $label; // varchar(255)
  public ?int $orden; // int(11)
  public ?int $limite_inferior; // int(11)
  public ?int $limite_superior; // int(11)
  public ?string $color_rango; // varchar(128)
  public ?string $fondo_rango; // varchar(128)
  private string $date_creation; //	datetime;
  private string $tms; //	timestamp; current_timestamp()
  private int $fk_user_creat;  // int(11); //
  private ?int $fk_user_modif;  // int(11);
  private ?string $last_main_doc; // varchar(255)
  private ?string $import_key; // varchar(14)
  private ?string $model_pdf; // varchar(255)
  private int $status; // int(11)
  
  use RangoTraitSetUpD;

  private $invalidMessages = [
    0 => '',
    1 => 'Rango no válido: Inferior a Cero',
    2 => 'Rango no válido: Superior a ',
  ];

  public function __construct() 
  {
    parent::__construct();
    self::$pk = 'rowid';
    self::$table = Config::get('tablas.rangos_d');
    $this->setUp();
  }

  public function getLimiteInferior(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT limite_inferior FROM " .self::$table ." WHERE label = :label", [":label" => $rango->label()]);
    return $este_rango->limite_inferior;
  }

  public function getLimiteSuperior(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT limite_superior FROM " .self::$table ." WHERE label = :label", [":label" => $rango->label()]);
    return $este_rango->limite_superior;
  }

  public function getColor(Rangos $rango = Rangos::Bajo)
  {
    $este_rango = self::first("SELECT color_rango FROM " .self::$table ." WHERE label = :label", [":label" => $rango->label()]);
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

    $este_rango = self::first("SELECT label FROM " .self::$table ." WHERE :lim_inf >= limite_inferior AND :lim_sup < (limite_superior+0.999)", [":lim_inf" => $valor, ":lim_sup" => $valor]);
    return $este_rango->label;
  }

  public function showTablaRangos(): string
  {
    $Rangos = $this->all();
    $tabla = new OdaTable();
    $tabla->setCaption("<font size=\"3\"><b>TABLA DE RANGOS</b></font>");
    foreach ($Rangos as $key => $itemRango) {
      $tabla->addRow(["<font size=\"3\">{$itemRango->limite_inferior}-{$itemRango->limite_superior}</font>", strtoupper("<font size=\"3\">{$itemRango->label}</font>")]);
    }
    return $tabla;
  }

}
