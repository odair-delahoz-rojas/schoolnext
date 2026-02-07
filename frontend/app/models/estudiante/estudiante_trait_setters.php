<?php
trait EstudianteTraitSetters {
 
  
  public function setRetirar(string $motivo, int $user_id): bool 
  {
    try {
      return $this->update(
        [
          'id' => $this->id,
          'is_active' => 0,
          'retiro' => $motivo,
          'annio_promovido' => 0,
          'grado_promovido' => $this->grado_mat,
          'numero_mat' => '',
          'fecha_ret' => (new DateTime())->format('Y-m-d'),
        ]
      );
    } 
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return false;
    }
  }
  

  public function setCambiarSalon(
    int $estudiante_id, 
    int $nuevo_salon_id, 
    bool $cambiar_en_notas=true
  ): bool 
  {
    try {
      $RegSalonNew = (new Salon)::get($nuevo_salon_id);
      if ($RegSalonNew) {
          $RegEstud = (new Estudiante)::get($estudiante_id);
          $RegEstud->salon_id  = $RegSalonNew->id;
          $RegEstud->grado_mat = $RegSalonNew->grado_id;
          $RegEstud->save();
          if ($cambiar_en_notas) {
            (new Nota)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
            (new RegistrosGen)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
            (new RegistroDesempAcad)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
          }
          return true; // para acá
      }
      
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
    return false;
  }
  
  
  public function setActualizarPago(): bool 
  {
    return $this->update(
      [
        'mes_pagado' => self::LIM_PAGO_PERIODOS[self::$_periodo_actual],
        'annio_pagado' => self::$_annio_actual,
        //'is_debe_preicfes' => 0,
        //'is_debe_almuerzos' => 0,
      ]
    );
  }
  

  public function setMesPago(int $mes): bool 
  {
    return $this->update(
      [
        'mes_pagado' => $mes, 
        'annio_pagado' => self::$_annio_actual,
      ]
    );
  }
 



}