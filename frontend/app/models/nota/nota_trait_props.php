<?php
/**
 * Summary of NotaTraitProps
 */
trait NotaTraitProps {
  
  private static $arrExcepProm = array(30,35,36,37,38,39,40);

  public function __toString() 
  {
    return $this->id.'-'.$this->annio.'-'.$this->periodo_id.'-'.$this->salon_id.'-'.$this->asignatura_id.'-'.$this->estudiante_id.'-'.$this->definitiva;
  }  

  public function getFoto(bool $show_cod=true) 
  { 
    return Estudiante::getFotoEstud(id: $this->estudiante_id, show_cod: $show_cod, sexo:''); 
  }
  
  public static function imgTablaRango(): string 
  { 
    return OdaTags::img(src: "upload/asignaturas/rangos.png", attrs: "style=\"width:100%;max-width:214px\""); 
  }

  
  public function verNota(): string 
  {
    $color = (new Rango)->getColorNota($this->nota_final);
    $rango = (new Rango)->getRangoNota($this->nota_final);
    $nota_limite = (new Rango)->getLimiteInferior(Rangos::Basico);
    $plan_apoyo = ($this->definitiva < $nota_limite) ? 'Definitiva: '.$this->definitiva.' => Plan de Apoyo: '.$this->plan_apoyo : '' ;
    
    return "<span class=\"w3-tag w3-round $color\">
              $this->nota_final $rango
            </span> $plan_apoyo ";
  }


  

  public function fieldForm(string $field_name, string $attr='', string|bool $type=null): string 
  {
    $attribs = ($attr) ? $attr : $this->getAttrib(field: $field_name) ;
    return Form::input(
      type:  ((!is_null($type)) ? $type : $this->getWidget($field_name)),
      field: 'notas.'.$field_name.'_'.$this->id, 
      attrs: $attribs . $this->getPlaceholder($field_name),
      value: $this->$field_name,
    );
  }


}