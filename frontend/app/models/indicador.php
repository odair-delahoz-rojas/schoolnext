<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "indicador/indicador_trait_props.php";
include "indicador/indicador_trait_set_up.php";

#[AllowDynamicProperties]
class Indicador extends LiteRecord {

  use IndicadorTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.indicadores');
    self::$pk = 'id';
    self::$_order_by_defa = 't.annio, t.periodo_id, t.grado_id, t.asignatura_id, t.codigo';
    $this->setUp();
  }

  //const IS_visible  = [0 => 'No visible', 1 => 'Visible' ];
  //const VALORATIVOS  = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];
  //public static $valorativos = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];


  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*, CONCAT('Periodo ', p.periodo) as periodo_nombre, g.nombre AS grado_nombre, a.nombre AS asignatura_nombre")
        ->leftJoin('periodo', 'p')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$_order_by_defa);
    if (!is_null($order_by))
    {
      $DQL->orderBy($order_by);
    }
    if (!is_null($estado))
    { 
      $DQL->where('t.is_active=?')
          ->setParams([$estado]);
    }
    return $DQL->execute();
  }

  
  public function getByPeriodoGrado (
    int $periodo_id, 
    int $grado_id,
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.periodo_id=? AND t.grado_id=?')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$periodo_id, $grado_id]);
    return $DQL->execute();
  }

  
  public function getByAnnioPeriodoGrado(
    int $annio, 
    int $periodo_id, 
    int $grado_id
  ): array|string 
  {
    $tbl_indica = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom($tbl_indica);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.periodo_id=? AND t.grado_id=?')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$periodo_id, $grado_id]);
    return $DQL->execute();
  }


  public function getByPeriodoGradoAsignatura(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  }

  public function getByGradoAsignatura(
    int $grado_id, 
    int $asignatura_id
  ) {
    try
    {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$grado_id, $asignatura_id]);      
      return $DQL->execute();
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getListIndicadores(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id
  ) 
  {
    try
    {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy('t.periodo_id, t.grado_id, t.asignatura_id, t.codigo')
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);      
      return $DQL->execute();
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getListIndicadoresVisibles(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id
  ) 
  {
    try
    {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.is_active=1 AND t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);
      return $DQL->execute();
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getIndicadoresCalificar(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id
  ) 
  {
    try
    {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.codigo, t.valorativo, t.concepto')
          //->where('t.is_active=1 AND t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);
      return $DQL->execute();      
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function getMinMaxByPeriodoGradoAsignatura(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id
  ) 
  {
    try
    {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.valorativo, MIN(t.codigo) AS min, MAX(t.codigo) AS max')
          ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->groupBy('t.valorativo')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);  
          
      $MinMaxIndicad = $DQL->execute();      
      $arrResult = [
        'regs_min' => 0, 
        'regs_max' => 0,
        'min_fortaleza' => 0, 
        'max_fortaleza' => 0,
        'min_debilidad' => 0, 
        'max_debilidad' => 0,
        'min_recomendacion' => 0, 
        'max_recomendacion' => 0,
        'ancho_lim' => 0,
      ];
      if (isset($MinMaxIndicad)) // verifico que hay registros
      {
        $min_max_todos = [];
        foreach ($MinMaxIndicad as $key => $Indic)
        {
          $min_max_todos[] = (int)$Indic->min;
          $min_max_todos[] = (int)$Indic->max;
          if (str_starts_with(strtoupper($Indic->valorativo), 'F'))
          {
            $arrResult['min_fortaleza'] = (int)$Indic->min;  
            $arrResult['max_fortaleza'] = (int)$Indic->max;
          }
          if (str_starts_with(strtoupper($Indic->valorativo), 'D'))
          {
            $arrResult['min_debilidad'] = (int)$Indic->min;  
            $arrResult['max_debilidad'] = (int)$Indic->max;
          }
          if (str_starts_with(strtoupper($Indic->valorativo), 'R'))
          {
            $arrResult['min_recomendacion'] = (int)$Indic->min; 
            $arrResult['max_recomendacion'] = (int)$Indic->max;
          }
        }
        $arrResult['regs_min'] = min($min_max_todos);
        $arrResult['regs_max'] = max($min_max_todos);
        $arrResult['ancho_lim'] = strlen((string)$arrResult['regs_max']);
      }
      return $arrResult;
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }



}