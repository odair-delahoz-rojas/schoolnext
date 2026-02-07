<?php

trait GradoAsignaturaTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
   
  private function setUp() {
    // 'cod_moodle', eliminar de la tabla
    self::$_fields_show = [
      'all'      => [ 'asignatura_id', 'created_at', 'created_by', 'grado_id', 'intensidad', 'orden', 'updated_at', 'updated_by' ],
      'index'    => [ 'asignatura_id', 'grado_id', 'intensidad', 'updated_at', 'updated_by' ],
      'create'   => [ 'asignatura_id', 'grado_id', 'intensidad', 'orden' ],
      'edit'     => [ 'asignatura_id', 'grado_id', 'intensidad', 'orden' ],
      'editUuid' => [ 'asignatura_id', 'grado_id', 'intensidad', 'orden' ],
    ];
  
    self::$_widgets = [
      'asignatura_id' => 'select', 
      // 'created_at' => , 
      // 'created_by' => , 
      'grado_id' => 'select', 
      'intensidad' => 'number', 
      'orden' => 'number', 
      // 'updated_at' => , 
      // 'updated_by' =>, 
    ];

    self::$_attribs = [
      'asignatura_id' => ' required="required" ',
      'grado_id'      => ' required="required" ' ,
    ];
  
    self::$_defaults = [
      'asignatura_id' => 0, 
      // 'created_at' => , 
      // 'created_by' => , 
      'grado_id' => 0, 
      'intensidad' => 1, 
      'orden' => 0, 
      // 'updated_at' => , 
      // 'updated_by' =>, 
    ];
  
    self::$_helps = [
      // 'asignatura_id' => , 
      // 'created_at' => , 
      // 'created_by' => , 
      // 'grado_id' => , 
      'intensidad' => 'Intensidad Horaria', 
      // 'orden' => , 
      // 'updated_at' => , 
      // 'updated_by' =>, 
    ];
  
    self::$_labels = [
      'asignatura_id' => 'Asignatura', 
      // 'created_at' => , 
      // 'created_by' => , 
      'grado_id' => 'Grado', 
      'intensidad' => 'I.H.', 
      // 'orden' => , 
      // 'updated_at' => , 
      // 'updated_by' =>, 
    ];
  
    self::$_placeholders = [
      // 'asignatura_id' => , 
      // 'created_at' => , 
      // 'created_by' => , 
      // 'grado_id' => , 
      // 'intensidad' => '', 
      // 'orden' => , 
      // 'updated_at' => , 
      // 'updated_by' =>, 
    ];
  
  }


  
}