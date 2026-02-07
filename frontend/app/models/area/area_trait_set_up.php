<?php

trait AreaTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;

  public function __toString(): string 
  { 
    return $this->nombre; 
  }

  private function setUp() 
  {
    self::$_fields_show = [
      'all'      => ['id', 'uuid', 'nombre', 'orden', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'    => ['is_active', 'nombre', 'orden', 'updated_at'],
      'create'   => ['nombre', 'orden'],
      'edit'     => ['nombre', 'orden', 'is_active'],
      'editUuid' => ['nombre', 'orden', 'is_active'],
    ];
  
    self::$_attribs = [
      'nombre'       => 'required',
      'orden'        => 'required',
    ];
  
    self::$_defaults = [
      'nombre'          => '',
      'orden'           => 0,
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Area',
      'orden'           => 'Orden',

      'id'              => 'ID',
      'uuid'            => 'UUID',
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'nombre'          => 'nombre del area',
      'orden'           => 'ordenamiento interno',
    ];
  
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }
 
}