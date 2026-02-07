<?php

enum TipoAcudiente: string {
  Use EnumsFunciones;
  case MADRE  = 'Madre';
  case PADRE  = 'Padre';
  case OTRO = 'Otro';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::MADRE => 'Madre',
      static::PADRE => 'Padre',
      static::OTRO  => 'Otro',
      default  => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Tipo de Acudiente';
  }//END-caption

} //END-ENUM