<?php

trait TraitForms {
  
  protected static $_fields_show = [
    'all'      => ['id', 'uuid', 'is_active', 'nombre', 'created_by', 'created_at', 'updated_by', 'updated_at'], 
    'index'    => ['id', 'uuid', 'is_active', 'nombre', 'created_by', 'created_at', 'updated_by', 'updated_at'], 
    'create'   => [1=>['is_active'], 2=>[]], 
    'edit'     => [1=>['is_active'], 2=>[]], 
    'editUuid' => [1=>['is_active'], 2=>[]],
    'excel'    => [
      'id'     => [ 'caption'=>'ID', 'data_type'=>'integer' ], 
      'nombre' => [ 'caption'=>'Nombre', 'data_type'=>'string' ], 
    ],
  ];

  protected static $_attribs  = [
    'nombre' => 'required',
  ];
  protected static $_widgets  = [
    'nombre' => 'text',
    'uuid' => 'text',
  ];
  protected static $_defaults = [
    'is_active' => 1, 
  ];
  protected static $_helps = [
    'is_active' => 'Está activo el registro?',
  ];
  protected static $_labels = [
    'nombre' => 'Nombre',
    'is_active' => 'Está Activo',
    'created_at' => 'Creado el',
    'created_by' => 'Creado por',
    'updated_at' => 'Actualizado el',
    'updated_by' => 'Actualizado por',
  ];
  protected static $_placeholders = [
  ];
  protected static $_rules_validators = [
  ];
  
  /* 
  'numeric', 
  'int', 
  'maxlength', 
  'length', 
  'range', 
  'select', 
  'email', 
  'url', 
  'ip', 
  'required', 
  'alphanum', 
  'alpha', 
  'date', 
  'pattern', 
  'decimal', 
  'equal',
  
  'nombre' => [
    'required' => [ 'error' => 'es requerido.' ],
    'alphanum' => [ 'error' => 'debe contener solo números y letras.' ],
  ],
  'orden'  => [
    'int'      => [ 'error' => 'debe contener solo numeros enteros.' ],
  ],
  'campo_on_off'  => [
    'pattern'  => ['regexp' => '[0-1]', 'error'  => 'debe contener solo: 0 y 1'],
    'int'      => [ 'error' => 'debe contener solo numeros enteros.' ],
  ],
  'NombreCompleto' => [
    'required' => ['error' => 'Indique su nombre.'],
    'alpha'    => ['error' => 'Nombre incompleto o incorrecto.']
  ],
  'Email' => [
    'required' => ['error' => 'Indique su email.'],
    'email'    => ['error' => 'Email incorrecto.']
  ],
  'Movil' => [
    'required' => ['error' => 'Indique su teléfono / móvil.'],
    'length'   => ['min' => '9',
    'max' => '17',
                              'error' => 'Teléfono / móvil incorrecto'],
      'pattern'  => ['regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 
                              'error'  => 'Teléfono incorrecto. Formato ejemplo. +34 862929929']
    ],
    'Asunto' => [
      'required' => ['error' => 'Indique un asunto.'],
    ],
    'Mensaje' => [
      'required' => ['error' => 'Indique un mensaje.'],
      'length'   => ['min' => 100,
                              'error' => 'Si es posible, concrete más en su mensaje.'],
    ] */

  public static function getDefault($field)     { 
    return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); 
  }


  public static function getLabel($field)       { 
    return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); 
  }


  public static function getPlaceholder($field) { 
    return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); 
  }


  public static function getHelp($field)        { 
    return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); 
  }


  public static function getAttrib($field)      { 
    return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); 
  }


  public static function getWidget($field)      { 
    return ((array_key_exists($field, self::$_widgets)) ? self::$_widgets[$field]: 'text'); 
  }


  public static function getValidators($field)  { 
    return ((array_key_exists($field, self::$_rules_validators)) ? self::$_rules_validators[$field]: ''); 
  }

  
  public static function getFieldsShow(string $show='index', bool $show_labels = false, $prefix=''): array 
  {
    $srrShow = [];
    foreach (self::$_fields_show[$show] as $name => $field) {
      $srrShow[] = (($show_labels) ? self::getLabel($field) : $prefix.$field);
    }
    return  $srrShow;
  }
  

  public static function getFieldsHidden(string $show='index'): array 
  {
    return array_diff(self::$_fields_show['all'], self::$_fields_show[$show]);
  }



}