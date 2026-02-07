<?php
enum DiaSemana: int {
  Use EnumsFunciones;

  case Domingo = 0;
  case Lunes = 1;
  case Martes = 2;
  case Miercoles = 3;
  case Jueves = 4;
  case Viernes = 5;
  case Sabado = 6;
  
  public function label(bool $abrev = false): string {
    return match($this) {
      static::Domingo   => (($abrev)?'Do':'Domingo'),
      static::Lunes     => (($abrev)?'Lu':'Lunes'),
      static::Martes    => (($abrev)?'Ma':'Martes'),
      static::Miercoles => (($abrev)?'Mi':'Miércoles'),
      static::Jueves    => (($abrev)?'Ju':'Jueves'),
      static::Viernes   => (($abrev)?'Vi':'Viernes'),
      static::Sabado    => (($abrev)?'Sa':'Sábado'),
      default           => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(): string {
    return "<i class=\"fa-solid fa-calendar-day w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }

  public static function caption(): string {
    return 'Dia de la semana';
  }//END-caption

} // END-ENUM