<?php

enum Sexo: string {
  Use EnumsFunciones;

  case Masculino = 'Masculino';
  case Femenino  = 'Femenino';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Masculino => (($abrev)?'M':'Masculino'),
      static::Femenino  => (($abrev)?'F':'Femenino'),
      default           => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label
  
  public function ico(): string {
    $ico = match($this) {
        static::Masculino => 'fa-mars',
        static::Femenino  => 'fa-venus',
        default           => 'fa-question',
    };
    return "<i class=\"fa-solid $ico w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(bool $abrev = false): string {
    return $this->ico().$this->label($abrev);
  }//END-label_ico

  public function color(): string {
    return match($this) {
        static::Masculino => 'dodgerblue', // dodgerblue Hex Code:	#1E90FF
        static::Femenino  => 'seagreen', // seagreen hex code #2E8B57
        default           => 'coral', // coral hex code is #FF7F50
    };
  }//END-color

  public static function caption(): string {
    return 'Sexo';
  }//END-caption
  
} //END-ENUM