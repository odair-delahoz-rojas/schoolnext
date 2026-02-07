<?php

trait EstudiantePadresTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  
  
  private function setUp() 
  {
    self::$_fields_show = [
      'all'     => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'   => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'create'  => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'edit'    => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
    ];
  
    self::$_attribs = [
      'estudiante_id'       => 'required',
    ];
    
    self::$_defaults = [
    ];
  
    self::$_helps = [
    ];
  
    self::$_labels = [
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