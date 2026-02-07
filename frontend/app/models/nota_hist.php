<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "nota/nota_hist_trait_set_up.php";


#[AllowDynamicProperties]
class NotaHist extends LiteRecord {

  use NotaHistTraitSetUp;

  protected static $tbl_estud = '';
  protected static $tbl_asign = '';
  
  
  public function __construct() 
  {
    parent::__construct();
    self::$tbl_estud = Config::get('tablas.estudiantes');
    self::$tbl_asign = Config::get('tablas.asignaturas');
    self::$table = Config::get('tablas.notas_hist');
    self::$pk = 'id';
    $this->setUp();
  }


  public function verNota(): string 
  {
    $Rango = new Rango();
    $color = $Rango->getColorNota($this->nota_final);
    $rango = $Rango->getRangoNota($this->nota_final);
    
    $rango_bajo = 1 + $Rango::get(2)->limite_inferior;
    $plan_apoyo = (
      ($this->definitiva < $rango_bajo) 
      ? 'Definitiva: '.$this->definitiva.' => Plan de Apoyo: '.$this->plan_apoyo 
      : ''
    );    
    return "<span class=\"w3-tag w3-round $color\">
              $this->nota_final $rango
            </span> $plan_apoyo ";
  }


  public function getfoto(): string 
  { 
    return IMG_UPLOAD_PATH.'/estudiantes/'.$this->id.'.png';
  }


  public function getNotasSalonAsignatura(
    $salon_id, 
    $asignatura_id, 
    $annio=null
  ): array 
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    return (new Nota)->all(
      "SELECT n.*, CONCAT(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM $tbl_notas as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.salon_id=? AND n.asignatura_id=?
      ORDER BY n.annio, n.periodo_id, n.salon_id, e.apellido1, e.apellido2, e.nombres",
      array((int)$salon_id, (int)$asignatura_id)
    );
  }


  public function getBySalonAsignaturaPeriodos(
    $salon_id, 
    $asignatura_id, 
    $periodos=array(), 
    $annio=null
  ): array 
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    $str_p = implode(',', $periodos);
    return (new Nota)->all(
      "SELECT n.*, concat(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM $tbl_notas as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.periodo_id IN($str_p) AND n.salon_id=? AND n.asignatura_id=?
      ORDER BY n.annio, n.periodo_id, n.salon_id, e.apellido1, e.apellido2, e.nombres",
      array((int)$salon_id, (int)$asignatura_id)
    );
  }


  public static function getVistaTotalAnniosPeriodosSalones() 
  { // ojo :: pendiente eliminar
    $registros = static::query("SELECT * FROM vista_total_annios_periodos_salones_historico order by annio desc", [])->fetchAll();    
    $aResult = [];
    foreach ($registros as $reg)
    {
      $aResult[$reg->annio][$reg->periodo_id][$reg->salon_id] = "$reg->salon;$reg->total_registros";
    }
    return $aResult;
  }

  
  public static function getTotalAnniosPeriodosSalones() 
  {
    $sql = "SELECT H.annio, H.periodo_id, H.salon_id, S.nombre AS salon,
        count(0) AS total_registros 
        FROM (sweb_notas_historia H LEFT JOIN sweb_salones S ON ((H.salon_id = S.id))) 
        GROUP BY H.annio,H.periodo_id,H.salon_id 
        ORDER BY H.annio DESC,H.periodo_id, S.position";    
    $aResult = [];
    $registros = static::query($sql)->fetchAll();
    foreach ($registros as $reg)
    {
      $aResult[$reg->annio][$reg->periodo_id][$reg->salon_id] = "$reg->salon;$reg->total_registros";
    }
    return $aResult;
  }



}