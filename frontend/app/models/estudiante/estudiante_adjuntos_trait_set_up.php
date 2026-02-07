<?php

trait EstudianteAdjuntosTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, TraitSubirAdjuntos, 
      EstudianteAdjuntosTraitProps, EstudianteAdjuntosTraitCorrecciones;
      
  public function _beforeCreate(): void 
  {
    parent::_beforeCreate();

    $this->estado_archivo1 = 'En Revisión';
    $this->estado_archivo2 = 'En Revisión';
    $this->estado_archivo3 = 'En Revisión';
    $this->estado_archivo4 = 'En Revisión';
    $this->estado_archivo5 = 'En Revisión';
    $this->estado_archivo6 = 'En Revisión';
    $this->estado_archivo7 = 'En Revisión';
  }


  private function setUp(): void 
  {

    $this->setRutaDestino('/files/upload/matriculas_adjuntos');

    self::$_fields_show = [
      'all' => [
        'id', 'uuid', 'estudiante_id', 
        'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 
        'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 
        'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 
        'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 
        'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 
        'nombre_archivo6', 'coment_archivo6', 'estado_archivo6', 
        'nombre_archivo7', 'coment_archivo7', 'estado_archivo7', 
        'created_at', 'updated_at', 'created_by', 'updated_by',
      ],
      'index' => [
        'id', 'uuid', 'estudiante_id', 
        'estado_archivo1', 'estado_archivo2', 'estado_archivo3', 
        'estado_archivo4', 'estado_archivo5', 'estado_archivo6', 'estado_archivo7',
      ],
      'create' => [
        'estudiante_id', 'nombre_archivo1', 'nombre_archivo2', 'nombre_archivo3', 
        'nombre_archivo4',  'nombre_archivo5', 'nombre_archivo6', 'nombre_archivo7',
      ],
      'edit' => [
        'nombre_archivo1', 'estado_archivo1', 'coment_archivo1', 
        'nombre_archivo2', 'estado_archivo2', 'coment_archivo2', 
        'nombre_archivo3', 'estado_archivo3', 'coment_archivo3', 
        'nombre_archivo4', 'estado_archivo4', 'coment_archivo4', 
        'nombre_archivo5', 'estado_archivo5', 'coment_archivo5', 
        'nombre_archivo6', 'estado_archivo6', 'coment_archivo6',
        'nombre_archivo7', 'estado_archivo7', 'coment_archivo7',
      ],
    ];
  
    self::$_attribs = [
      'estudiante_id' => 'required',
      'nombre_archivo1' => 'accept="image/*,.pdf"', 'nombre_archivo2' => 'accept="image/*,.pdf"',
      'nombre_archivo3' => 'accept="image/*,.pdf"', 'nombre_archivo4' => 'accept="image/*,.pdf"',
      'nombre_archivo5' => 'accept="image/*,.pdf"', 'nombre_archivo6' => 'accept="image/*,.pdf"',
      'nombre_archivo7' => 'accept="image/*,.pdf"',
    ];
    
    self::$_defaults = [
      'estado_archivo1' => 'En Revisión',
      'estado_archivo2' => 'En Revisión',
      'estado_archivo3' => 'En Revisión',
      'estado_archivo4' => 'En Revisión',
      'estado_archivo5' => 'En Revisión',
      'estado_archivo6' => 'En Revisión',
      'estado_archivo7' => 'En Revisión',
    ];
  
    self::$_helps = [
      'nombre_archivo1' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_1_titulo'),
      'nombre_archivo2' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_2_titulo'),
      'nombre_archivo3' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_3_titulo'),
      'nombre_archivo4' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_4_titulo'),
      'nombre_archivo5' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_5_titulo'),
      'nombre_archivo6' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_6_titulo'),
      'nombre_archivo7' => 'subir acá '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_7_titulo'),
    ];
  
    self::$_labels = [
      'nombre_archivo1' => 'Archivo 1: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_1_titulo'),
      'nombre_archivo2' => 'Archivo 2: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_2_titulo'),
      'nombre_archivo3' => 'Archivo 3: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_3_titulo'),
      'nombre_archivo4' => 'Archivo 4: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_4_titulo'),
      'nombre_archivo5' => 'Archivo 5: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_5_titulo'),
      'nombre_archivo6' => 'Archivo 6: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_6_titulo'),
      'nombre_archivo7' => 'Archivo 7: '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_7_titulo'),

      'coment_archivo1' => 'Comentarios del archivo 1',
      'coment_archivo2' => 'Comentarios del archivo 2',
      'coment_archivo3' => 'Comentarios del archivo 3',
      'coment_archivo4' => 'Comentarios del archivo 4',
      'coment_archivo5' => 'Comentarios del archivo 5',
      'coment_archivo6' => 'Comentarios del archivo 6',
      'coment_archivo7' => 'Comentarios del archivo 7',

      'estado_archivo1' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_1_titulo'),
      'estado_archivo2' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_2_titulo'),
      'estado_archivo3' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_3_titulo'),
      'estado_archivo4' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_4_titulo'),
      'estado_archivo5' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_5_titulo'),
      'estado_archivo6' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_6_titulo'),
      'estado_archivo7' => 'Estado '.Config::get('matriculas.'.INSTITUTION_KEY.'.file_7_titulo'),

      'created_at' => 'Creado el',
      'created_by' => 'Creado por',
      'updated_at' => 'Actualizado el',
      'updated_by' => 'Actualizado por',
    ];
  
      
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }

  
  
}