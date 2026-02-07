<?php

enum EstadoAdjuntos: string {
  Use EnumsFunciones;
  case ENREVISION  = 'En Revisión';
  case RECHAZADO = 'Rechazado';
  case APROBADO  = 'Aprobado';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::ENREVISION  => 'En Revisión',
      static::RECHAZADO => 'Rechazado',
      static::APROBADO  => 'Aprobado',
      default  => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Estado de Archivo Adjunto';
  }//END-caption

} //END-ENUM