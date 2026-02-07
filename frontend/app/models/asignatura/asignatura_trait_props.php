<?php

trait AsignaturaTraitProps {
  
  protected static string $ruta_imagen = 'upload/asignaturas/';

  public function __toString() 
  { 
    return $this->nombre; 
  }
  

  public static function imgNombreAsignatura($id): string 
  {
    return OdaTags::img(
      self::$ruta_imagen .$id .'.png', 
      'imagen',
      "style=\"width:100%;max-width:214px\"",
      '');
  }


  
}