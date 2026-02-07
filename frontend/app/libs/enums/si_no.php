<?php
/**
 * uso
 *   $si_no = SiNo::tryFrom((int)$this->is_active) ?? SiNo::No;
 *   $si_no->color()
 *   $si_no->label_ico()
 *   $si_no->label()
 */
enum SiNo: int {
  Use EnumsFunciones;

  case No = 0;
  case Si = 1;


  public function label($attr_class=''): string 
  {
    return match($this) {
      static::No => "<span class=\"$attr_class\">No</span>",
      static::Si => "<span class=\"$attr_class\">Si</span>",
      default          => throw new InvalidArgumentException(message: "Erroneo"),
    };
  }
  

  public function ico(bool $with_color=true, $attr_class=''): string 
  {
    $ico = match($this) {
        static::No => 'fa-face-frown',
        static::Si => 'fa-face-smile',
        default    => 'fa-face-frown',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  }
  

  public function label_ico(bool $with_color=true, $attr_class=''): string 
  {
    return $this->ico($with_color, $attr_class)
          .$this->label($attr_class);
  }


  public function color(): string {
    return match($this) {
        static::No => 'crimson',
        static::Si => 'seagreen',
        default    => 'crimson',
    };
  }//END-color

  public static function caption(): string {
    return 'Evaluación: Si o No ?';
  }//END-caption

} //END-ENUM