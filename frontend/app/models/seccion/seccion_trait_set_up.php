<?php

trait SeccionTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  use SeccionTraitProps;
    
  private function setUp() {

    self::$_fields_show = [
      'all'     => ['id', 'uuid', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'   => ['is_active', 'nombre', 'updated_at'],
      'create'  => ['id', 'uuid', ],
      'edit'    => ['id', 'uuid',  'is_active']
    ];
    
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
    ];
    
    self::$_defaults = [
      'is_active'       => 1,
    ];
    
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
    
    self::$_labels = [
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];

  }



}