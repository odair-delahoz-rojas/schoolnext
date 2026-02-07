<?php

trait AspiranteTraitProps {


  public function __toString(): string 
  { 
    return "$this->apellido1 $this->apellido2, $this->nombres"; 
  }

  
  public static function is_pago_enum(
    int $pago, 
    bool $with_color=true, 
    string $attr_class='', 
    bool $show_ico=true
  ): string
  { 
    return (($show_ico) ? 
      Pagado::tryFrom($pago)->label_ico($with_color, $attr_class) : 
      Pagado::tryFrom($pago)->label($attr_class)
    );
  }


  public function is_pago_f() 
  {
    return self::is_pago_enum((int)$this->is_pago);
  }


  public static function estatus_enum(
    string $estatus, 
    bool $with_color=true, 
    string $attr_class='', 
    bool $show_ico=true
  ): string 
  { 
    $estatus = AspirEstatus::tryFrom($estatus);
    return $show_ico ? $estatus->label_ico($with_color, $attr_class) : $estatus->label();
  }


  public function estatus_f(): string 
  {
    return self::estatus_enum((string)$this->estatus);
  }

  
  public static function ctrl_llamadas_enum(
    string $ctrl_llamadas, 
    bool $with_color=true, 
    string $attr_class='', 
    bool $show_ico=true
  ): string 
  { 
    return (
      ($show_ico) ? 
      AspirLlamadas::tryFrom($ctrl_llamadas)->label_ico($with_color, $attr_class) : 
      AspirLlamadas::tryFrom($ctrl_llamadas)->label()
    );
  }


  public function ctrl_llamadas_f() 
  {
    return self::ctrl_llamadas_enum((string)$this->ctrl_llamadas);
  }


  public function lnkPageEditAspirantePsicologia(): string 
  {
    return OdaTags::link(
      action: "sicologia/admisiones_edit/$this->id",
      text: "$this",
    );
  }

  
  public function lnkPageEditAspiranteSecretaria(): string 
  {
    return OdaTags::link(
      action: "secretaria/admisiones_edit/$this->id",
      text: "$this",
    );
  }


  public function fecha_entrev_f(): string 
  {
    $timezone = new DateTimeZone("America/Bogota");
    $date = new DateTimeImmutable($this->fecha_entrev, $timezone);
    return ( ($this->fecha_entrev=='0000-00-00 00:00:00') ? '' : $date->format('M-d H:iA'));
  }
  
    
  public function is_fecha_entrev_f(bool $ico = true) // Asistió ?? 
  {
    $asistio_entrevista = SiNo::tryFrom((int)$this->is_fecha_entrev) ?? SiNo::No;
    return $ico ? $asistio_entrevista->label_ico() : $asistio_entrevista->label();
  }

  
  public function fecha_eval_f(): string 
  {
    $timezone = new DateTimeZone("America/Bogota");
    $date = new DateTimeImmutable($this->fecha_eval, $timezone);
    return ( ($this->fecha_eval=='0000-00-00 00:00:00') ? '' : $date->format('M-d H:iA'));
  }
  

  public function is_fecha_eval_f(bool $ico = true)  // Asistió ??
  {
    $asistio_evalualcion = SiNo::tryFrom((int)$this->is_fecha_eval) ?? SiNo::No;
    return $ico ? $asistio_evalualcion->label_ico() : $asistio_evalualcion->label();
  }
  

  public function lnkTrasladar(): string 
  {
    return OdaTags::link(
      action: "admin/aspirantes/trasladar/{$this->id}",
      text: "Admitido",
      attrs: 'style="color:seagreen"',
    );
  }



}