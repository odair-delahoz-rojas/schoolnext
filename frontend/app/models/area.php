<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "area/area_trait_set_up.php";

#[AllowDynamicProperties]
class Area extends LiteRecord
{
  use AreaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$pk = 'id';
    self::$table = Config::get('tablas.areas');
    $this->setUp();
  }

  public function getLista(string $fields = '*') 
  {
    $sql = "SELECT $fields FROM ".static::getSource();
    return static::query($sql);
  }

  
}