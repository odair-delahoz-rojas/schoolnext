<?php

trait EstudianteAdjuntosDosTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, 
  EstudianteAdjuntosDosTraitCorrecciones;
  

  private function setUp() 
  {

    self::$_fields_show = [
      'all'     => ['id', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'    => ['id', 'estudiante_id', 'nombre_archivo1', 'nombre_archivo2', 'nombre_archivo3'],
      'create'  => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3'],
      'edit'    => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3']
    ];
  
    self::$_attribs = [
      'estudiante_id'   => 'required',
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'nombre_archivo1'  => 'Este archivo es obligatorio',
      'nombre_archivo2'  => 'Este archivo es obligatorio'
    ];
  
    self::$_labels = [
      'nombre_archivo1'  => 'Contrato de Matr&iacute;cula',
      'nombre_archivo2'  => 'Libro de Matr&iacute;cula',
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