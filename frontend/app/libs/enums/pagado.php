<?php

enum Pagado: int {
  Use EnumsFunciones;

  case No = 0;
  case Si = 1;

  //public const Bueno = self::Si;

  public function label($attr_class=''): string {    
    return match($this) {
      static::No => "<span class=\"$attr_class\">No Pagado</span>",
      static::Si => "<span class=\"$attr_class\">Pagado</span>",
      default    => throw new InvalidArgumentException(message: "Erroneo"),
    };
  } //END-label
  
  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::No => 'fa-sack-dollar',
        static::Si => 'fa-sack-dollar',
        default    => 'fa-question',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  } //END-ico
  
  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico

  public function color(): string {
    return match($this) {
        static::No => 'crimson',
        static::Si => 'seagreen',
        default    => 'crimson',
    };
  }//END-color

  public static function caption(): string {
    return 'Estado del pago';
  }//END-caption

} //END-ENUM