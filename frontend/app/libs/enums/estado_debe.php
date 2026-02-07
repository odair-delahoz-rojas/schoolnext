<?php

enum EstadoDebe: int {
  Use EnumsFunciones;

  case NODEBE = 0;
  case DEBE = 1;

  public function label(): string {
    return match($this) {
      static::NODEBE => "No Debe",
      static::DEBE   => "Debe",
      default          => throw new InvalidArgumentException(message: "Erroneo"),
    };
  }
  
  public function ico(bool $with_color=true, $attr_class=''): string 
  {
    $ico = match($this) {
        static::NODEBE => 'fa-face-frown',
        static::DEBE   => 'fa-face-smile',
        default        => 'fa-face-frown',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  }
    
  public function label_ico(bool $with_color=true, $attr_class=''): string 
  {
    return $this->ico($with_color, $attr_class).$this->label();
  }
  
  public function color(): string 
  {
    return match($this) {
      static::NODEBE  => 'seagreen',
      static::DEBE  => 'crimson',
      default => 'seagreen',
    };
  }

  public static function caption(): string 
  {
    return 'Estado de Deuda';
  }

}