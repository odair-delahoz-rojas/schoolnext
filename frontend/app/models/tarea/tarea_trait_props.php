<?php

trait TareaTraitProps {
  
  public function __toString() 
  { 
    return "$this->id $this->nombre"; 
  }


  
}