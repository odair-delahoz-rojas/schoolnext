<?php

trait SalAsigProfTraitProps {

  public function __toString(): string 
  { 
    return "{$this->salon_id}-{$this->asignatura_id}-{$this->user_id}" ; 
  }



}