<?php

trait AsignaturaTraitSetUpD {
  
  use TraitUuid, TraitForms, TraitValidar, AsignaturaTraitProps;
  
  private function setUp() {
    // 'calc_prom' ??? se debe eliminar
    self::$_fields_show = [
      'all'       => ['id', 'nombre', 'abrev', 'orden', 'area_id', 'calc_prom', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'     => ['is_active', 'nombre', 'abrev', 'orden', 'area_id'],
      'create'    => ['nombre', 'abrev', 'orden', 'area_id'],
      'edit'      => ['nombre', 'abrev', 'orden', 'area_id', 'is_active'],
      'editUuid'  => ['nombre', 'abrev', 'orden', 'area_id', 'is_active'],
    ];
    
    self::$_widgets = [
      'is_active'   => 'select',
      'orden'       => 'number',
    ];

    self::$_attribs = [
      'nombre'      => 'required',
      'abrev'       => 'required',
      'area_id'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'   => 1,
      'orden'       => 0,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si est&aacute; activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Asignatura', 
      'abrev'           => 'Abreviatura', 
      'orden'           => 'Orden de Listado', 
      'area_id'         => '&Aacute;rea',
      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
    
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }
  
 
  
}