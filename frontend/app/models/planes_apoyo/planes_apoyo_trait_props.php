<?php
/**
 * Summary of PlanesApoyoTraitProps
 */
trait PlanesApoyoTraitProps {

  public function fieldForm(
    string $field_name, 
    string $attr='', 
    string|bool $type=null
  ): string {

    $attribs = ($attr) ? $attr : $this->getAttrib(field: $field_name);

    if (($this->definitiva>0) & ($this->definitiva<60)) {
      if ('textarea'==$this->getWidget($field_name)) {
        return $this->getLabel($field_name).'<br> '.Form::textarea(
          field: 'planes_apoyo.'.$field_name.'_'.$this->id, 
          attrs: $attribs . $this->getPlaceholder($field_name),
          value: $this->$field_name,
        );
      } else {
        return Form::input(
          type:  ((!is_null($type)) ? $type : $this->getWidget($field_name)),
          field: 'planes_apoyo.'.$field_name.'_'.$this->id, 
          attrs: $attribs . $this->getPlaceholder($field_name),
          value: $this->$field_name,
        );
      }    
    }

    $campo_valor = '<span '. (('hidden'==$type) ? 'class="w3-hide"' : '') .'">'.(string)$this->$field_name.'</span>';

    return $campo_valor; 
  }


}