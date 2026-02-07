<?php
trait SeguimientosTraitProps {

  private static $asi_valido = 2;
  
  public function fieldForm(
    string $field_name, 
    string $attr='', 
    string|bool $type=null, 
    bool $label=false
  ): string {

    $label   = ($label) ? $this->getLabel($field_name).'<br>':'';
    $attribs = ($attr) ? $attr : $this->getAttrib($field_name);

    if ('textarea'==$this->getWidget($field_name)) {
      return $label.Form::textarea(
          field: 'seguimientos.'.$field_name.'_'.$this->id, 
          attrs: $attribs . $this->getPlaceholder($field_name),
          value: $this->$field_name,
        );
    }

    if ('asi_desempeno'==$field_name) {
      return $label.Form::select(
          field: 'seguimientos.'.$field_name.'_'.$this->id, 
          data: ['Bajo'=>'Bajo', 'Básico'=>'Básico'],
          value: $this->$field_name,
        );
    }
      
    return $label.Form::input(
        type:  ((!is_null($type)) ? $type : $this->getWidget($field_name)),
        field: 'seguimientos.'.$field_name.'_'.$this->id, 
        attrs: $attribs . $this->getPlaceholder($field_name),
        value: $this->$field_name,
    );

  }


}