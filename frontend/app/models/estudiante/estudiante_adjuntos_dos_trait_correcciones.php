<?php

trait EstudianteAdjuntosDosTraitCorrecciones {

  public static function getCorregirRegistrosHuerfanos() {
    // corrige los registros huerfanos de estudiante_adjuntos
    try {

      $sql_adjuntos = "SELECT e.id AS estudiante_id, e.nombres, e.apellido1, e.apellido2, e.salon_id, e.is_active FROM sweb_estudiantes AS e 
              WHERE e.is_Active = 1 AND e.id NOT IN (SELECT adj.estudiante_id FROM sweb_estudiante_adjuntos_dos AS adj)";
      $cnt_rows = 0;
      
      $estud_adjuntos = EstudianteAdjuntosDos::all($sql_adjuntos);
      if (count($estud_adjuntos)>0) {
        foreach ($estud_adjuntos as $key => $estud_adj) {
          $Objeto = new EstudianteAdjuntosDos();
          $Objeto->create([
              'estudiante_id' => $estud_adj->estudiante_id,
              'estado_archivo1'    => 'En Revisión',
              'estado_archivo2'    => 'En Revisión',
              'estado_archivo3'    => 'En Revisión',
              'estado_archivo4'    => 'En Revisión',
              'estado_archivo5'    => 'En Revisión',
              'estado_archivo6'    => 'En Revisión',
              'created_by'    => 1,
              'updated_by'    => 1,
          ]); //Devuelve True o False
        }
        
        $cnt_rows = $key+1;
        (new OdaFlash)::valid("Se insertaron: $cnt_rows registros en tabla Adjuntos #2.");

      } else {
        (new OdaFlash)::info("Tabla Adjuntos #2, no tiene registros huerfanos por corregir.");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }



}