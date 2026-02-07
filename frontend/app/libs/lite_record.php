<?php
//app/libs/lite_record.php

/**
 * Record 
 * Para los que prefieren SQL con las ventajas de ORM
 *
 * Clase padre para añadir tus métodos
 *
 * @category Kumbia
 * @package ActiveRecord
 * @subpackage LiteRecord
 */

require_once "enums.php";
use Kumbia\ActiveRecord\LiteRecord as ORM;

class LiteRecord extends ORM
{ 
  protected static $_max_periodos = 0;
  protected static $_periodo_actual = 0;
  protected static $_annio_actual = 0;
  protected static $_user_id = 0;
  protected static $_username = '';
  protected static $_tam_uuid_max  = 36;
  protected static $_tam_uuid_defa = 24;
  protected static $_order_by_defa = 't.id';
  protected static $_class_name = __CLASS__;
  
  const LIM_PAGO_PERIODOS = [ 1=>3, 2=>6, 3=>8, 4=>11, 5=>11 ]; /// esto se eliminará
  const IS_ACTIVE     = [0 =>'Inactivo', 1=>'Activo']; /// esto se eliminará
  const ICO_IS_ACTIVE = [0=>'face-frown', 1=>'face-smile']; /// esto se eliminará

  public function __construct() 
  {
    self::$_user_id = Session::get('id') ?? 0;
    self::$_username = Session::get('username') ?? 'Anonimo';
    
    self::$_max_periodos = Session::get('max_periodos') ?? 4;
    self::$_periodo_actual = Session::get('periodo') ?? 1;
    self::$_annio_actual = Session::get('annio') ?? date('Y');
  }
  
  
  
  public function __toString(): string 
  {
    if (property_exists($this, 'nombre')) 
    { 
      return "{$this->nombre} [{$this->id}]";
    }
    return (string)$this->id;
  }

  
  public function _beforeCreate() { // ANTES de Crear el Registro
    $ahora = date('Y-m-d H:i:s', time());
    if (property_exists($this, 'is_active'))
    { 
      $this->is_active = 1; 
    }
    if (property_exists($this, 'uuid') and method_exists($this, 'setHash') )
    {
      $this->setHash();
    }
    if (property_exists($this, 'created_by')) 
    {
      $this->created_by = self::$_user_id; 
    }
    if (property_exists($this, 'created_at')) 
    {
      $this->created_at = $ahora; 
    }
    if (property_exists($this, 'updated_by'))
    {
      $this->updated_by = self::$_user_id;
    }
    if (property_exists($this, 'updated_at')) 
    {
      $this->updated_at = $ahora;
    }
  }
  

  public function _beforeUpdate() { // ANTES de actualizar el registro
    $ahora = date('Y-m-d H:i:s', time());
    if (property_exists($this, "is_active"))
    {
      if (is_null($this->is_active))
      {
        $this->is_active = 0; 
      }
    }
    if (property_exists($this, 'uuid') and method_exists($this, 'setHash') )
    {
      if (is_null($this->uuid) or (strlen($this->uuid)==0))
      { 
        $this->setHash(); 
      }
    }
    if (property_exists($this, 'updated_by'))
    {
      $this->updated_by = self::$_user_id;
    }
    if (property_exists($this, 'updated_at'))
    {
      $this->updated_at = $ahora;
    }
  }


  //public function _afterUpdate(): void { }
  //public function _afterCreate(): void { }
  /**
   * Summary of getList
   * @deprecated usa _getLlist()
   * @param int|bool $estado
   * @param string $select
   * @param string|bool $order_by
   * @return array|string
   */
  public function getList(
    int|bool $estado=null, 
    string $select='t.*', 
    string|bool $order_by=null)
  {
    $DQL = new OdaDql(self::$_class_name);
    $DQL->select($select)->orderBy(self::$_order_by_defa);

    if ($order_by !== null) $DQL->orderBy( $order_by);
    if ($estado   !== null) $DQL->where( 't.is_active=?')->setParams([$estado]);
    
    return $DQL->execute();
  }


  /**
   * Método base para obtener listas.
   * @param array $options Opciones para filtrar la consulta
   * - 'select'   : Campos a seleccionar (por defecto 't.*')
   * - 'where'    : Condición(es) para el filtro (string o array)
   * - 'params'   : Parámetros para la consulta (array)
   * - 'order_by' : Ordenamiento de los resultados (string)
   * - 'leftJoins': Uniones LEFT JOIN adicionales (array) Cada uno [tabla, alias, condición]
   * - 'write_log': Indica si se debe escribir el log de la consulta (boolean)
   * @return array|string Resultado de la consulta
   */
  public function _getList(array $options = [])
  {
    $defaults = [
      'select' => 't.*',
      'where' => null,
      'params' => [],
      'order_by' => self::$_order_by_defa,
      'leftJoins' => [],
      'write_log' => false,
    ];
    $options = [...$defaults, ...$options];

    $DQL = new OdaDql(self::$_class_name);

    $DQL->select($options['select'])
        ->orderBy($options['order_by']);

    if ($options['leftJoins'] !== []) {
      foreach ($options['leftJoins'] as $join) {
        // Cada join debe ser un array con [tabla, alias, condición]
        if (is_array($join) && count($join) >= 2) {
          $DQL->leftJoin($join[0], $join[1], $join[2]??null);
        }
      }
    }

    if ($options['where'] !== null) {
      $filtro_where = '';
      if (is_array($options['where'])) {
        $a_keys_where = array_keys($options['where']);
        $a_values_where = array_values($options['where']);
        foreach ($a_keys_where as $key => $condicion) {
          $prefijo = (str_starts_with($condicion, 't.')) ? '' : 't.';
          $filtro .= (0 == $key) ? "{$prefijo}{$condicion}=? " : ", {$prefijo}{$condicion}=?";
        }
        $DQL->where($filtro_where)->setParams($a_values_where);
      }
      else {
        $DQL->andWhere($options['where']);
        if(!empty($options['params'])) $DQL->setParams($options['params']);
      }
    }
    
    return $DQL->execute($options['write_log']);
  }
/*
  public function getListActivos(
    string|bool $select = null, 
    string|bool $order_by = null): mixed
  {
    return $this->_getList([
      'where' => 't.is_active=?',
      'params' => [1],
      'select' => $select ?? 't.*',
      'order_by' => $order_by ?? self::$_order_by_defa,
      'write_log' => true,
    ]);
  }


  public function getListInactivos(
    string|bool $select = null, 
    string|bool $order_by = null): array|string 
 {
    return $this->_getList([
      'where' => 't.is_active=?',
      'params' => [0],
      'select' => $select ?? 't.*',
      'order_by' => $order_by ?? self::$_order_by_defa,
      'write_log' => true,
    ]);
  }
*/

  public function getListActivos(
    string $select='*', 
    string|bool $order_by=null): array|string {
    return $this->getList(1,  $select, $order_by);
  }


  public function getListInactivos(
    string $select='*', 
    string|bool $order_by=null): array|string {
    return $this->getList(0,  $select, $order_by);
  }


  public function is_active_f(
    bool $show_ico=false, 
    string $attr="w3-small"): string 
  {
    $estado = self::IS_ACTIVE[(int)$this->is_active] ?? 'Inactivo';
    $ico    = '';
    if ($show_ico) {
      $ico = match((int)$this->is_active) {
        0   => '<span class="w3-text-red">'._Icons::solid(self::ICO_IS_ACTIVE[0], $attr).'</span> ',
        1 => '<span class="w3-text-green">'  ._Icons::solid(self::ICO_IS_ACTIVE[1], $attr).'</span> '
      };
    }
    return $ico.$estado;
  }


  public function is_active_enum(
    bool $show_ico=false, 
    string $attr="w3-small"): string 
  {
    $estado = Estado::tryFrom((int)$this->is_active) ?? Estado::Inactivo;
    return '<span class="'.$attr.' w3-text-'.$estado->color().'">'. (($show_ico) ? $estado->label_ico() : $estado->label()).'</span>';
  }
  
  
  public function nombre_mes_enum(int $mes): string
  {
    $nombre_mes = Mes::tryFrom(value: $mes) ?? Mes::Enero; // definir otra opción que no sea enero ya que puede generra inconsistencia
    return $nombre_mes->label();
  }


  public function setActivar(): bool
  {
    if (property_exists($this, "is_active"))
    {
      $this->is_active = 1;
      $this->save();
      return true;
    }
    return false;
  }
  
  public function setDesactivar(): bool 
  {
    if (property_exists($this, "is_active"))
    {
      $this->is_active = 0;
      $this->save();
      return true;
    }
    return false;
  }
  
  public static function valor_moneda(int $val_num): string
  {
    return '$'.number_format($val_num);
  }
  
  
  public function valor_letras(int $val_num): string
  {
    return strtolower(OdaUtils::getNumeroALetras($val_num));
  }
  
}