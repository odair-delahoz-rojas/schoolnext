<?php

trait SeccionTraitProps {
 
  public function __toString(): string 
  { 
    return (string)$this->nombre;
  } 

  public static function segSecPrescolar(): array 
  { 
    return [1]; 
  }

  public static function segSecPrimaria(): array 
  { 
    return [2]; 
  }
  
  public static function segSecBachillerato(): array 
  { 
    return [3, 4]; 
  }



}