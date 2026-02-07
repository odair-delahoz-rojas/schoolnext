<?php

trait SalonTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  use SalonTraitCallBacks, SalonTraitLinks, SalonTraitProps;

  private function setUp(): void {
      self::$_fields_show['all'] = ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'id', 'uuid', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at'];
      self::$_fields_show['index'] = ['is_active', 'nombre', 'grado_nombre', 'director_id', 'codirector_id', 'tot_estudiantes', 'print_state'];
      self::$_fields_show['create'] = ['nombre', 'grado_id', 'director_id', 'codirector_id', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'is_active' ];
      self::$_fields_show['edit'] = ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'print_state', 'is_active' ];
      self::$_fields_show['editUuid'] = ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'print_state', 'is_active' ];
      self::$_fields_show['excel'] =  [
        'nombre' => [ 'caption'=>'Salón', 'data_type'=>'string' ], 
        'grado_nombre' => [ 'caption'=>'Grado', 'data_type'=>'string' ], 
        'director_nombre' => [ 'caption'=>'Director', 'data_type'=>'string' ], 
        'codirector_nombre' => [ 'caption'=>'Codirector', 'data_type'=>'string' ], 
        'tot_estudiantes' => [ 'caption'=>'Estudiantes', 'data_type'=>'integer' ], 
      ];
  
      $widgets = [ 
        'grado_id' => 'number',
      ];
      self::$_widgets = array_merge(self::$_widgets, $widgets);
      
      $attribs = [
        'nombre' => 'required', 
        'grado_id' => 'required',
      ];
      self::$_attribs = array_merge(self::$_attribs, $attribs);
    
      $defaults = [
        'tot_estudiantes' => 0, 
        'position' => 1,
        'print_state1' => 'En Calificación',
        'print_state2' => 'En Calificación',
        'print_state3' => 'En Calificación',
        'print_state4' => 'En Calificación',
        'print_state5' => 'En Calificación',
        'print_state' => 'En Calificación',
        'is_ready_print' => 0,
      ];
      self::$_defaults = array_merge(self::$_defaults, $defaults);


      $helps = [
      'nombre'            => 'Máximo 50 caracteres',
      'grado_id'          => 'Elija Grado al que pertenece',
      'director_id'       => 'Director de Grupo',
      'codirector_id'     => 'Codirector de Grupo',
      'position'          => 'Orden en el que se muestra en los listados.',
      'tot_estudiantes'   => 'Valor calculado',
      'print_state1'      => 'Estado de la impresión para el Periodo 1',
      'print_state2'      => 'Estado de la impresión para el Periodo 2',
      'print_state3'      => 'Estado de la impresión para el Periodo 3',
      'print_state4'      => 'Estado de la impresión para el Periodo 4',
      'print_state5'      => 'Estado de la impresión para el Periodo 5',
      'is_ready_print'    => 'Deprecated - No tiene uso',
      'print_state'       => 'Deprecated - No tiene uso',
      ];
      self::$_helps = array_merge(self::$_helps, $helps);
    
      $labels = [
        'nombre'            => 'Salón',
        'grado_id'          => 'Grado',
        'grado_nombre'      => 'Grado',
        'director_id'       => 'Director',
        'director_nombre'   => 'Director',
        'codirector_id'     => 'Codirector',
        'codirector_nombre' => 'Codirector',
        'position'          => 'Orden',
        'tot_estudiantes'   => 'Total Estudiantes',
        'print_state1'      => 'Estado Impresión P1',
        'print_state2'      => 'Estado Impresión P2',
        'print_state3'      => 'Estado Impresión P3',
        'print_state4'      => 'Estado Impresión P4',
        'print_state5'      => 'Estado Impresión P5',
        'is_ready_print'    => '¿Está listo para imprimir?',
        'print_state'       => 'Estado De Impresión',
      ];
      self::$_labels = array_merge(self::$_labels, $labels);
    
      $placeholders = [
        'nombre'  => 'nombre del salon',
      ];
      self::$_placeholders = array_merge(self::$_placeholders, $placeholders); 
    
      $rules = [
        // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
        // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
        'grado_id'  => [
          'required' => [ 'error' => 'es requerido.' ],
          'int' => [ 'error' => 'debe contener solo números enteros.' ],
        ],
      ];
      self::$_rules_validators = array_merge(self::$_rules_validators, $rules);
  }


}