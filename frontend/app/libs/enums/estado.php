<?php
/**
 * uso
 *   $estado = Estado::tryFrom((int)$this->is_active) ?? Estado::Inactivo;
 *   $estado->color()
 *   $estado->label_ico()
 *   $estado->label()
 */
enum Estado: int {
  Use EnumsFunciones;

  case Inactivo = 0;
  case Activo   = 1;

  public const Bueno = self::Activo;

  public function label($attr_class=''): string {
    return match($this) {
      static::Inactivo => "<span class=\"$attr_class\">Inactivo</span>",
      static::Activo   => "<span class=\"$attr_class\">Activo</span>",
      default          => throw new InvalidArgumentException(message: "Erroneo"),
    };
  }//END-label
  
  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::Inactivo => 'fa-face-frown',
        static::Activo   => 'fa-face-smile',
        default          => 'fa-face-frown',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  }//END-ico
  
  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico

  public function color(): string {
    return match($this) {
        static::Inactivo => 'crimson',
        static::Activo   => 'seagreen',
        default          => 'crimson',
    };
  }//END-color

  public static function caption(): string {
    return 'Estado del registro';
  }//END-caption

} //END-ENUM