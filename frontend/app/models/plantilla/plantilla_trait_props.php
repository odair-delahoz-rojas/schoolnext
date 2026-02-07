<?php
trait PlantillaTraitProps
{
  public function __toString(): string 
  { 
    return (string)$this->nombre; 
  }


}