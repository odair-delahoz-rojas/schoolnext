<?php
enum Rangos: string {
  Use EnumsFunciones;
  
  case Bajo       = 'bajo';
  case Basico     = 'basico';
  case Alto       = 'alto';
  case Superior   = 'superior';
  
  public function label(): string
  {
    return match($this)
    {
      static::Bajo        => 'Bajo',
      static::Basico      => 'Básico',
      static::Alto        => 'Alto',
      static::Superior    => 'Superior',
      default             => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public static function caption(): string 
  {
    return 'Rango de la calificación';
  }

}