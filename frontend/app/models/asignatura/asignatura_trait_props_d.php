<?php

trait AsignaturaTraitPropsD {
  
  protected static string $ruta_imagen = 'upload/asignaturas/';

  public function __toString() 
  { 
    return $this->label;
  }
    
}