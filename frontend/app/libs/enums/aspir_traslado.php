<?php
/**
 * uso
 *   $estado = Estado::tryFrom((int)$this->is_active) ?? Estado::Inactivo;
 *   $estado->color()
 *   $estado->label_ico()
 *   $estado->label()
 */
enum AspirTraslado: int {
  Use EnumsFunciones;

  case No = 0;
  case Si   = 1;

  public function label($attr_class=''): string {
    return match($this) {
      static::No => "<span class=\"$attr_class\">No Trasladado</span>",
      static::Si => "<span class=\"$attr_class\">Trasladado</span>",
      default          => throw new InvalidArgumentException(message: "Erroneo"),
    };
  }//END-label
  
  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::No => 'fa-face-frown',
        static::Si => 'fa-face-smile',
        default    => 'fa-face-frown',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  }//END-ico
  
  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico

  public function color(): string {
    return match($this) {
        static::No => 'dodgerblue',
        static::Si => 'seagreen',
        default    => 'dodgerblue',
    };
  }//END-color

  public static function caption(): string {
    return 'Trasladado a Estudiantes';
  }//END-caption

} //END-ENUM