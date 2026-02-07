<?php

enum AspirResults: string {
  Use EnumsFunciones;

  case Nulo   = '';
  case Alto   = 'Alto';
  case Basico = 'B&aacute;sico';
  case Bajo   = 'Bajo';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Nulo   => '',
      static::Alto   => (($abrev)?'AL':'Alto'),
      static::Basico => (($abrev)?'BA':'B&aacute;sico'),
      static::Bajo   => (($abrev)?'BJ':'Bajo'),
      default        => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Resultado del Examen';
  }//END-caption

} //END-ENUM