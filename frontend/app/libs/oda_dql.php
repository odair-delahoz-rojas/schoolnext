<?php

enum TipoDql: int {
  case Select = 1;
  case Update = 2;
  case Insert = 3;
  case Delete = 4;
}


class OdaDql {
  private string $_select      = '';
  private string $_sets        = '';
  private string $_from_source = ''; //ej: web_salones
  private string $_where       = '';
  private string $_order_by    = '';
  private string $_group_by    = '';
  private array  $_joins       = [];
  private array  $_params      = [];
  private int $_limit = 0;
  private string $_inserts_cols     = '';
  private string $_inserts_vals     = '';

  public function __construct(
    private string $_from, 
    private TipoDql $_tipo_dql = TipoDql::Select
  ) {
    $this->_from_source = $_from::getSource() ?? $_from;
  }

  
  public function __toString(): string { 
    return $this->render(); 
  }
  

  public function render(): string {
    return match($this->_tipo_dql) {
      TipoDql::Select => 'SELECT '
        . ((empty($this->_select) or ('*'==$this->_select)) ? 't.*' : $this->_select)
        . PHP_EOL." FROM {$this->_from_source} AS t"
        . PHP_EOL.implode(" ", $this->_joins)
        . (empty($this->_where)    ? '' : PHP_EOL." WHERE {$this->_where} ")
        . (empty($this->_group_by) ? '' : PHP_EOL." GROUP BY {$this->_group_by}")
        . (empty($this->_order_by) ? '' : PHP_EOL." ORDER BY {$this->_order_by}")
        . (empty($this->_limit)    ? '' : PHP_EOL." LIMIT {$this->_limit}"),
      TipoDql::Update => "UPDATE {$this->_from_source} AS t"
        . (empty($this->_sets) ? PHP_EOL.'-ERROR NO SET-' : PHP_EOL." SET {$this->_sets}")
        . (empty($this->_where) ? '' : PHP_EOL." WHERE {$this->_where}"),
      TipoDql::Insert => "INSERT INTO {$this->_from_source} "
        . (empty($this->_inserts_cols) ? PHP_EOL.'-ERROR NO SET-' : PHP_EOL." ({$this->_inserts_cols}) VALUES ({$this->_inserts_vals}) "),
    };
  }  
  

  /**
   * @deprecated use render()
   * @return string
   */
  public function renderlog(): string {
    return match($this->_tipo_dql) {
      TipoDql::Select => ' SELECT '
        . ((empty($this->_select) or ('*'==$this->_select)) ? PHP_EOL.'t.*' : PHP_EOL.$this->_select)
        . PHP_EOL." FROM $this->_from_source AS t "
        . (empty($this->_joins)    ? '' : PHP_EOL.implode(" ", $this->_joins))
        . (empty($this->_where)    ? '' : PHP_EOL." WHERE $this->_where ")
        . (empty($this->_group_by) ? '' : PHP_EOL." GROUP BY $this->_group_by")
        . (empty($this->_order_by) ? '' : PHP_EOL." ORDER BY $this->_order_by")
        . (empty($this->_limit)    ? '' : PHP_EOL." LIMIT $this->_limit"),
      TipoDql::Update => "UPDATE $this->_from_source AS t".PHP_EOL
        . (empty($this->_sets) ? '-ERROR NO SET-' : " SET $this->_sets").PHP_EOL
        . (empty($this->_where) ? '' : " WHERE $this->_where"),
      TipoDql::Insert => "INSERT INTO $this->_from_source "
        . (empty($this->_inserts_cols) ? '-ERROR NO SET-' : " ($this->_inserts_cols) VALUES ($this->_inserts_vals) "),
    };
  }


  public function execute(bool $write_log = false): array {
    try {
      $result = (new $this->_from)->all($this->render(), $this->_params);
      if ($write_log) { 
        OdaLog::debug( 
          msg: PHP_EOL.$this->render()
              .PHP_EOL.'Params: ' .$this->getParams() 
              .PHP_EOL.'Registros Afectados: '.Count($result)
        );
      }
      return $result;
    }
    
    catch (\Throwable $th) {
      OdaLog::debug(
        msg: PHP_EOL.'Sentencia SQL <- CON ERRORES ->'
            .PHP_EOL.$this->render()
            .PHP_EOL.'Params: ' .$this->getParams()
            .PHP_EOL.$th->getMessage()
      );
      return [];
    }
  }

  
  public function executeFirst(bool $write_log = false)  {
    if ($write_log) {
      OdaLog::debug(
        msg: $this->render()
            .PHP_EOL.'Params: ' .$this->getParams()
      );
    }

    return (new $this->_from)->first($this->render(), $this->_params);
  }


  public function getLastInsertId() {
    return (new $this->_from)->first("SELECT MAX(id) as last_id FROM {$this->_from_source}");
  }


  public function getMax(string $field='id') {
    $Reg = (new $this->_from)->first("SELECT MAX({$field}) as max FROM {$this->_from_source}");

    return $Reg->max ?? '';
  }


  public function select(string $select)  {
    $this->_select = (empty($select) or ('*'==$select)) ? 't.*' : $select;
    $this->_tipo_dql  = TipoDql::Select;

    return $this;
  }


  public function addSelect(string $select)  {
    if (empty($this->_select)) {
      $this->_select = $select;
    } 
    else {
      $this->_select .= ', '.PHP_EOL.$select;
    }
    $this->_tipo_dql  = TipoDql::Select;

    return $this;
  }


  public function update(array $arr_values) {
    $sets = '';
    foreach ($arr_values as $key => $value) {
      $sets .= " t.{$key}='{$value}',";
    }
    $this->_sets = substr($sets, 0, strlen($sets)-1);
    $this->_tipo_dql  = TipoDql::Update;

    return $this;
  }


  public function addUpdate(array $arr_values) {
    $sets = '';
    foreach ($arr_values as $key => $value) {
      $sets .= " t.{$key}='{$value}',";
    }
    
    if (empty($this->_sets)) {
      $this->_sets = substr($sets, 0, strlen($sets)-1); 
    } 
    else { 
      $this->_sets .= ', '.substr($sets, 0, strlen($sets)-1); 
    }

    $this->_tipo_dql  = TipoDql::Update;

    return $this;
  }


  public function insert(array $arr_values) {
    $cols = '';  $vals = '';

    foreach ($arr_values as $key => $value) { 
      $cols .= " {$key},";
      $vals .= " '{$value}',";
    }

    $this->_inserts_cols = substr($cols, 0, strlen($cols)-1);
    $this->_inserts_vals = substr($vals, 0, strlen($vals)-1);
    $this->_tipo_dql  = TipoDql::Insert;

    return $this;
  }


  public function addInsert(array $arr_values) {
    $cols = '';
    $vals = '';

    foreach ($arr_values as $key => $value) { 
      $cols .= " {$key},";
      $vals .= " '{$value}',";
    }

    if (empty($this->_inserts_cols)) {
      $this->_inserts_cols = substr($cols, 0, strlen($cols)-1);
      $this->_inserts_vals = substr($vals, 0, strlen($vals)-1);
    } 
    else { 
      $this->_inserts_cols .= ', '.substr($cols, 0, strlen($cols)-1);
      $this->_inserts_vals .= ', '.substr($vals, 0, strlen($vals)-1);
    }

    $this->_tipo_dql  = TipoDql::Insert;

    return $this;
  }


  public function concat(array $concat=[], string $alias='') {
    $str = '';
    $cnt = count($concat);

    if ($cnt>0) {
      $str = "CONCAT({$concat[0]}, ' '";
      for ($i=1; $i<$cnt-1; $i++) { 
        $str .= ", {$concat[$i]}, ' '"; 
      }
      $str .= ', '.$concat[$cnt-1].") AS $alias";
    }

    if (empty($this->_select)) {
      $this->_select = $str;
    } 
    else {
      $this->_select .= ', '.PHP_EOL.$str;
    }

    $this->_tipo_dql  = TipoDql::Select;

    return $this;
  }
  

  public function leftJoin(string $table_singular, string $alias, $condition = null) {
    $table_singular = OdaUtils::singularize(strtolower(trim($table_singular)));
    $join = PHP_EOL." LEFT JOIN ". Config::get("tablas.{$table_singular}") ." AS {$alias} ";

    if ($condition == null) { 
      $condition = "t.{$table_singular}"."_id={$alias}.id"; 
    }

    $join .= " ON {$condition} ";
    $this->_joins[]=$join;

    return $this;
  }


  public function where(string $where) {
    $this->_where = $where;

    return $this;
  }

  public function andWhere(string $where) {
    $this->_where = $this->_where ? PHP_EOL."({$this->_where}) AND ({$where})" : $where;

    return $this;
  }


  public function orWhere(string $where) {
    $this->_where = $this->_where ? PHP_EOL."({$this->_where}) OR ({$where})" : $where;

    return $this;
  }

  public function orderBy(string $sort){
    $this->_order_by = $sort;

    return $this;
  }


  public function addOrderBy(string $sort) {
    $this->_order_by = $this->_order_by ? PHP_EOL."{$this->_order_by}, {$sort}" : $sort;

    return $this;
  }


  public function groupBy(string $group){
    $this->_group_by = PHP_EOL.$group;

    return $this;
  }


  public function setParams($params=[]) {
    array_push($this->_params, ...$params);

    return $this;
  }

  
  public function getParams() {
    return '['.implode(',', $this->_params).']';
  }


  public function setFrom(string $nombre_tabla): void {
    $this->_from_source = $nombre_tabla;
  }
  
  public function setLimit(int $limite_regs): void {
    $this->_limit = $limite_regs;
  }

  

}