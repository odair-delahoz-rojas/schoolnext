<?php

enum AspirLlamadas: string {
  Use EnumsFunciones;

  case Pendiente   = 'No notificado';
  case AEntrevista = 'Entrevista';
  case AExamen     = 'Examen';
  case AResultados = 'Resultados';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Pendiente   => (($abrev)?'NON':'No notificado'),
      static::AEntrevista => (($abrev)?'ENT':'Llamado para Entrevista'),
      static::AExamen     => (($abrev)?'EXA':'Llamado para Examen'),
      static::AResultados => (($abrev)?'RES':'Llamado para Resultados'),
      default             => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::Pendiente   => 'fa-phone-slash',
        static::AEntrevista => 'fa-phone-volume',
        static::AExamen     => 'fa-phone-volume',
        static::AResultados => 'fa-phone-volume',
        default             => 'fa-question',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  } //END-ico
  
  public function color(): string {
    return match($this) {
        static::Pendiente   => 'crimson',
        static::AEntrevista => 'coral',
        static::AExamen     => 'dodgerblue',
        static::AResultados => 'seagreen',
        default             => 'crimson',
    };
  }//END-color


  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico


  public static function caption(): string {
    return 'Control de Llamadas';
  }//END-caption

} //END-ENUM