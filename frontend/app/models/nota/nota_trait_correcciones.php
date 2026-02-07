<?php

trait NotaTraitCorrecciones {

  public static function generarCalif_BySalonAsignatura(int $salon_id, int $asignatura_id) {
    try {
      $Salon = (new Salon())::get($salon_id);
      $DQL = new OdaDql(__CLASS__);
      $DQL->setFrom('sweb_estudiantes');
      $Estudiantes = $DQL->where('t.is_active=1 AND t.salon_id=?')
      ->setParams([$salon_id])
      ->execute();
      
      if ($Estudiantes) {
        $periodo_actual = self::$_periodo_actual;
        $annio_actual = self::$_annio_actual;
        $ahora = new DateTime('now', new DateTimeZone('America/Bogota'));

        foreach ($Estudiantes as $key => $Estud) {
          //OdaLog::debug("$Estud->nombres $Estud->apellido1 :: $Estud->id<br>");
          $DQL = new OdaDql(__CLASS__);
          $DQL->setFrom('sweb_notas');
          $DQL->insert([
            //'uuid' => $Estud->xxh3Hash(),
            'annio' => $annio_actual,
            'periodo_id' => $periodo_actual,
            'grado_id' => $Salon->grado_id,
            'salon_id' => $salon_id,
            'asignatura_id' => $asignatura_id,
            'estudiante_id' => $Estud->id,
            'created_at' => $ahora->format('Y-m-d H:i:s'),
            'updated_at' => $ahora->format('Y-m-d H:i:s'),
            'created_by' => 1,
            'updated_by' => 1,
            ]
          );
          $DQL->execute();

          if (4 == $periodo_actual ) {
            $DQL->insert([
              //'uuid' => $Estud->xxh3Hash(),
              'annio' => $annio_actual,
              'periodo_id' => 5,
              'grado_id' => $Salon->grado_id,
              'salon_id' => $salon_id,
              'asignatura_id' => $asignatura_id,
              'estudiante_id' => $Estud->id,
              'created_at' => $ahora->format('Y-m-d H:i:s'),
              'updated_at' => $ahora->format('Y-m-d H:i:s'),
              'created_by' => 1,
              'updated_by' => 1,
              ]
            );
            $DQL->execute();
          }


        }
      } else {
        OdaFlash::info('No hay registros');
      }
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-generarCalif_BySalonAsignatura
  

} //END-Trait