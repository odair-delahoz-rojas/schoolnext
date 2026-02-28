<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

#[AllowDynamicProperties]
class DoliConst extends LiteRecord
{
  private int $rowid;
  private string $name;
  private string $entity;
  private string $value;
  private string $type;
  private string $visible;
  private string $note;
  private $tms;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.doli_const');
    self::$pk = 'rowid';
  }

  public function getValue(string $const_name) 
  {
    //$sql = "SELECT * FROM ".static::getSource()." WHERE name=?";
    //$Const = (new DoliConst())::first($sql, [$const_name]);

    $DQL = new OdaDql('DoliConst');
    $DQL->setFrom(Config::get('tablas.doli_const'));
    $DQL->select('value')
        ->where('t.name =?')
        ->setParams([$const_name]);
    $Const = $DQL->execute(true);

    return $Const->value ?? '';
  }

  
}