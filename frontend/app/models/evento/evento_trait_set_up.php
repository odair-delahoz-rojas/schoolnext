<?php

trait EventoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  
  public function __toString(): string 
  { 
    return "$this->id - $this->nombre"; 
  }
  

  private function setUp(): void 
  {

    self::$_fields_show = [
      'all'      => ['id', 'uuid', 'nombre', 'fecha_desde', 'fecha_hasta', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'    => ['is_active', 'nombre', 'fecha_desde', 'fecha_hasta'],
      'create'   => ['nombre', 'fecha_desde', 'fecha_hasta'],
      'edit'     => ['nombre', 'fecha_desde', 'fecha_hasta', 'is_active'],
      'editUuid' => ['nombre', 'fecha_desde', 'fecha_hasta', 'is_active'],
    ];
  
    self::$_attribs = [
      'nombre'       => 'required',
      'fecha_desde'  => 'required',

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
      'fecha_desde'=> 'Desde', 
      'fecha_hasta'=> 'Hasta',

      'id'              => 'ID',
      'uuid'            => 'UUID',
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
    
    self::$_rules_validators = [
    ];

  }



}