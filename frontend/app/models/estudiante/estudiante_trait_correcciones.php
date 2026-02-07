<?php
trait EstudianteTraitCorrecciones {

  public static function setPromoverANuevoAnnio($annio=2025) 
  {
    try {

      $arrNoPromover = [
      ];
      
      $result = '';
      for ($i=11; $i>=1; $i--) { 
        $result .= "$annio $i - ";
      }

      for ($i=15; $i>=12; $i--) { 
        $result .= "$annio $i - ";
      }

      return $result;

    } catch (\Throwable $th) {
      throw $th;
    }
  }



}