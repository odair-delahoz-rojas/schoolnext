<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "periodo/periodo_trait_props_d.php";
include "periodo/periodo_trait_set_up_d.php";

//#[AllowDynamicProperties]
class PeriodoD extends LiteRecord
{
  use PeriodoTraitSetUpD;

  public int $rowid; // int(11) NOT NULL,
  public string $ref; // varchar(128)
  public ?string $label; // varchar(255) DEFAULT NULL,
  public int $status; // int(11) NOT NULL,

  private ?string $import_key; // varchar(14) DEFAULT NULL,
  private ?string $model_pdf; // varchar(255) DEFAULT NULL,
  private ?string $last_main_doc; // varchar(255) DEFAULT NULL,
  private string $date_creation; // datetime NOT NULL,
  private string $tms; // timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  private int $fk_user_creat; // int(11) NOT NULL,
  private ?int $fk_user_modif; // int(11) DEFAULT NULL

  public ?string $fecha_inicio; // date DEFAULT NULL,
  public ?string $fecha_fin; // date DEFAULT NULL,
  public ?string $f_ini_logro; // date DEFAULT NULL,
  public ?string $f_fin_logro; // date DEFAULT NULL,
  public ?string $f_ini_seguimientos; // date DEFAULT NULL,
  public ?string $f_fin_seguimientos; // date DEFAULT NULL,
  public ?string $f_ini_preinformes; // date DEFAULT NULL,
  public ?string $f_fin_preinformes; // date DEFAULT NULL,
  public ?string $f_ini_planes_apoyo; // date DEFAULT NULL,
  public ?string $f_fin_planes_apoyo; // date DEFAULT NULL,
  public ?string $f_ini_notas; // date DEFAULT NULL,
  public ?string $f_fin_notas; // date DEFAULT NULL,
  public ?string $f_open_day; // date DEFAULT NULL,

  public int $mes_req_boletin; // int(11) DEFAULT 2,
  public int $orden; // int(11) NOT NULL DEFAULT 0,

  public ?string $seguimientos_abrir; // date DEFAULT NULL,
  public ?string $seguimientos_cerrar; // date DEFAULT NULL,
  public ?string $preinformes_abrir; // date DEFAULT NULL,
  public ?string $preinformes_cerrar; // date DEFAULT NULL,
  public ?string $boletines_abrir; // date DEFAULT NULL,
  public ?string $boletines_cerrar; // date DEFAULT NULL,
  public ?string $planes_apoyo_abrir; // date DEFAULT NULL,
  public ?string $planes_apoyo_cerrar; // date DEFAULT NULL,


  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.periodos_d');
    self::$pk = 'rowid';
    $this->setUp();
  }
  

  public function getD(int $rowid): mixed  {
    $sql = "SELECT * FROM ".static::getSource().' WHERE '.static::$pk.' = ?';
    return static::query($sql, [$rowid])->fetch();
  }

  
  public static function getPeriodoActual(): int {
    $result = 1;
    $timezone = new DateTimeZone("America/Bogota");
    $fechaHoy = new DateTime("now", $timezone);
    $PeriodosTodos = (new PeriodoD())->all();
    foreach ($PeriodosTodos as $key => $EstePeriodo) {
      $fechaInicio = new DateTime($EstePeriodo->fecha_inicio, $timezone);
      $fechaFin = new DateTime($EstePeriodo->fecha_fin, $timezone);
      if ($fechaHoy >= $fechaInicio && $fechaHoy <= $fechaFin) {
        $result = $EstePeriodo->rowid;
        break;
      }
    }
    return $result;
  }


  public static function getNumPeriodos() {
    return 5;
  }

}