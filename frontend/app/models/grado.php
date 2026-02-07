<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "grado/grado_trait_props.php";
include "grado/grado_trait_set_up.php";

#[AllowDynamicProperties]
class Grado extends LiteRecord {

  use GradoTraitSetUp, GradoTraitProps;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.grados');
    self::$pk = 'id';
    self::$_order_by_defa = 't.orden';
    $this->setUp();
  }


  public function getListSeccion($estado=null): array 
  {
    $DQL = "SELECT g.*, s.nombre AS seccion
            FROM ".self::$table." AS g
            LEFT JOIN ".Config::get('tablas.secciones')." AS s ON g.seccion_id=s.id";    
    if (!is_null($estado))
    {
      $DQL .= " WHERE (g.is_active=?) ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY g.orden";    
    return $this::all($DQL);
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
    $DQL->select('t.*, t.nombre AS grado_nombre, s.nombre AS seccion_nombre, s.nombre AS seccion')
        ->leftJoin('seccion', 's')
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

  

  public static function getGradosArray()
  { 
    $arrResult = [];
    foreach ((new Grado())->getList(1) as $grado)
    { 
      $arrResult[$grado->id] = $grado->nombre; 
    }
    return $arrResult;
  }

  public static function getGradosAbrevArray()
  { 
    $arrResult = [];
    foreach ((new Grado())->getList(1) as $grado)
    { 
      $arrResult[$grado->id] = $grado->abreviatura; 
    }
    return $arrResult;
  }

  public static function getSelectGrados(
    string $id, 
    string $name, 
    int $grado_selected_id=0
  ): string 
  { 
    $listaGrados = (new Grado())->getList(1);

    $opts = '';
    $secc_ant = 0;
    foreach ($listaGrados as $key => $grado) {
      if ($grado->seccion_id <> $secc_ant) {
        $opts .= ((0==$key) ? "<optgroup label=\"$grado->seccion\">" : "</optgroup><optgroup label=\"$grado->seccion\">");
      }

      $grado_sel = ($grado->id == $grado_selected_id) ? 'selected' : '' ;
      $opts .= "<option value=\"$grado->id\" $grado_sel>$grado->nombre</option>";
      $secc_ant = $grado->seccion_id;
    }

    return "<select id=\"$id\" name=\"$name\"  class=\"w3-input w3-border\">$opts</select>";
  }

}