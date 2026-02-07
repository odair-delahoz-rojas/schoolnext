<?php
enum Mes: int {
  Use EnumsFunciones;

  case Enero = 1;
  case Febrero = 2;
  case Marzo = 3;
  case Abril = 4;
  case Mayo = 5;
  case Junio = 6;
  case Julio = 7;
  case Agosto = 8;
  case Septiembre = 9;
  case Octubre = 10;
  case Noviembre = 11;
  case Diciembre = 12;
  public static function toArray(): array {
    return array_combine( self::allValues(), self::allNames() );
  }

  public function label(bool $abrev=false): string {
    return match($this) {
      static::Enero      => (($abrev)?'Ene':'Enero'),
      static::Febrero    => (($abrev)?'Feb':'Febrero'),
      static::Marzo      => (($abrev)?'Mar':'Marzo'),
      static::Abril      => (($abrev)?'Abr':'Abril'),
      static::Mayo       => (($abrev)?'May':'Mayo'),
      static::Junio      => (($abrev)?'Jun':'Junio'),
      static::Julio      => (($abrev)?'Jul':'Julio'),
      static::Agosto     => (($abrev)?'Ago':'Agosto'),
      static::Septiembre => (($abrev)?'Sep':'Septiembre'),
      static::Octubre    => (($abrev)?'Oct':'Octubre'),
      static::Noviembre  => (($abrev)?'Nov':'Noviembre'),
      static::Diciembre  => (($abrev)?'Dic':'Diciembre'),
      default            => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(): string {
    return "<i class=\"fa-solid fa-calendar-days w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }

  public static function caption(): string {
    return 'Mes del año';
  }//END-caption


} // END-ENUM