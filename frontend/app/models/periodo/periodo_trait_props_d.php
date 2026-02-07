<?php

 trait PeriodoTraitPropsD {
  
  public function __toString(): string 
  {
    return "$this->label [$this->rowid]";
  }


  public static function getNumPeriodos(): int 
  {
    $sql = "SELECT count(*) as cant FROM ".static::getSource();
    $Const = (new DoliConst())::first($sql);
    return (int)$Const->cant;
  }

  public function getD(int $rowid): mixed 
  {
    $sql = "SELECT * FROM ".static::getSource().' WHERE '.static::$pk.' = ?';
    return static::query($sql, [$rowid])->fetch();
  }

  
}