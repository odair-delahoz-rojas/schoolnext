<?php

enum AspirEstatus: string {
  Use EnumsFunciones;

  case Estudio    = 'En Estudio';
  case Admitido   = 'Admitido';
  case Rechazado  = 'Rechazado';
  case Abandono   = 'Abandonó';
  case Trasladado = 'Trasladado';

  public function label(bool $abrev = false): string 
  {
    return match($this) {
      static::Estudio     => (($abrev) ? 'ES' : 'En Estudio'),
      static::Admitido    => (($abrev) ? 'AD' : 'Admitido'),
      static::Rechazado   => (($abrev) ? 'RE' : 'Rechazado'),
      static::Abandono    => (($abrev) ? 'AB' : 'Abandonó'),
      static::Trasladado  => (($abrev) ? 'TR' : 'Trasladado'),
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function ico(bool $with_color=true, $attr_class=''): string 
  {
    $ico = match($this) {
        static::Estudio     => 'fa-user-clock',
        static::Admitido    => 'fa-user-check',
        static::Rechazado   => 'fa-user-minus',
        static::Abandono    => 'fa-user-minus',
        static::Trasladado  => 'fa-user-graduate',
        default => 'fa-question',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  }
  
  public function color(): string 
  {
    return match($this) {
        static::Estudio => 'dodgerblue',
        static::Admitido => 'seagreen',
        static::Rechazado => 'crimson',
        static::Abandono => 'crimson',
        static::Trasladado => 'yellow',
        default => 'dodgerblue',
    };
  }
  
  public function label_ico(bool $with_color=true, $attr_class=''): string 
  {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  }


  public static function caption(): string 
  {
    return 'Estado de la Solicitud';
  }

} //END-ENUM