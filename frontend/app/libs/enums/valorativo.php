<?php

enum Valorativo: String {
  Use EnumsFunciones;

  case Fortaleza = 'F';
  case Debilidad   = 'D';
  case Recomendacion   = 'R';

  //public const Bueno = self::Fortaleza;

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Fortaleza     => (($abrev)?'F':'Fortaleza'),
      static::Debilidad     => (($abrev)?'D':'Debilidad'),
      static::Recomendacion => (($abrev)?'R':'Recomendaci&oacute;n'),
      default               => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  } //END-label
  
  public function ico(): string {
    $ico = match($this) { 
        static::Fortaleza     => 'fa-check-double',
        static::Debilidad     => 'fa-check',
        static::Recomendacion => 'fa-hand',
        default               => 'fa-question',
    };
    return "<i class=\"fa-solid $ico w3-small\"></i>&nbsp;";
  } //END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  } //END-label_ico

  public function color(): string {
    return match($this) {
        static::Fortaleza     => 'pale-green', //seagreen
        static::Debilidad     => 'pale-blue', //dodgerblue
        static::Recomendacion => 'pale-red', //crimson
        default               => 'pale-red',
    };
  }//END-color

  public static function caption(): string {
    return 'Valorativo del indicador';
  }//END-caption

} //END-ENUM