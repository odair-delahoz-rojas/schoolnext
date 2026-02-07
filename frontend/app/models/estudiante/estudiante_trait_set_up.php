<?php

trait EstudianteTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar,
      EstudianteTraitProps, EstudianteTraitSetters, EstudianteTraitLinks, EstudianteTraitDatosPadres, 
      EstudianteTraitMatriculas, EstudianteTraitCorrecciones, EstudianteTraitCallBacks;
  
  
  private function setUp() 
  {

    self::$_fields_show = [
      'all' => ['id', 'uuid', 'is_active', 'nombres', 'apellido1', 'apellido2',  'documento', 'tipo_dcto', 
            'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 
            'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 
            'is_habilitar_mat', 'grado_promovido', 'annio_promovido',
            'salon_id', 'grado_mat', 'numero_mat', 'contabilidad_id', 
            'sexo', 'retiro', 'fecha_ret', 'email_instit', 'clave_instit', 'annio_pagado', 
            'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4',
            'created_at', 'updated_at', 'created_by', 'updated_by', 
          ],
      'index'    => ['is_active', 'id', 'estudiante_nombre', 'salon_id', 'grado_id', 'documento', 'email_instit', 'clave_instit'],
      'create'   => ['nombres', 'apellido1', 'apellido2', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'grado_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1',  'email', 'tipo_dcto', 'sexo', 'retiro', 'fecha_ret', 'email_instit', 'clave_instit', 'annio_pagado', ],
      'edit'     => ['nombres', 'apellido1', 'apellido2', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'grado_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'email', 'tipo_dcto', 'sexo', 'retiro', 'fecha_ret', 'email_instit', 'clave_instit', 'annio_pagado', ],
      'editUuid' => ['nombres', 'apellido1', 'apellido2', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'grado_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'email', 'tipo_dcto', 'sexo', 'retiro', 'fecha_ret', 'email_instit', 'clave_instit', 'annio_pagado', ],
    ];
    
    self::$_attribs = [
      'id'        => 'required',
      'uuid'      => 'required',
      'nombres'   => 'required',
      'apellido1' => 'required',
      'direccion' => ' size="45"',
      'email' => ' size="45"',
      'numero_mat' => 'readonly',
    ];
  
    self::$_defaults = [
      'mes_pagado' => 2,
      'is_active'  => 1,
      'retiro'     => '', 
    ];
  
    self::$_helps = [
      'fecha_nac'    => 'aaaa/mm/dd, ej 2014/10/31',
      'fecha_ret'    => 'dd/mm/aaaa, ej 30/07/2014',
      'is_debe_preicfes'  => 'Debe PREICFES?',
      'is_debe_almuerzos' => 'Debe ALMUERZOS?',
      'is_habilitar_mat'  => 'Desactivada, si están pendientes recuperaciones.',
      'mes_pagado'        => 'Hasta que mes de pensión está pago',
      'documento'    => 'Sin puntos ni comas',
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    $labels = [
      'id' => 'id',
      'nombres'    => 'Nombres',
      'apellido1'  => 'Primer Apellido',
      'apellido2'  => 'Segundo Apellido',
      'estudiante_nombre' => 'Estudiante',

      'tipo_dcto'  => 'Tipo Documento',
      'documento'  => 'Num. Doc ID',
      'fecha_nac'  => 'Fecha Nac.',
      'sexo'       => 'Sexo',

      'direccion' => 'Direccion',
      'barrio'    => 'Barrio',
      'telefono1' => 'Teléfono', 
      'email'     => 'Email', 

      'salon_id'   => 'Salón',
      'grado_mat'  => 'Grado',
      'grado_id'   => 'Grado',
      
      'is_habilitar_mat'  => 'Matr&iacute;cula Habilitada?',
      'numero_mat' => 'Número de Matricula',
      'annio_promovido' => 'Año Promovido',
      'grado_promovido' => 'Grado Promovido',
      
      'is_debe_preicfes'  => '¿Debe PREICFES?',
      'is_debe_almuerzos' => '¿Debe ALMUERZOS?',
      'annio_pagado'      => 'Año de pagos pensión',
      'mes_pagado'        => 'Pagó pensión hasta',
      
      'email_instit'      => 'Usuario App Externa',
      'clave_instit'      => 'Clave App Externa',
      
      'contabilidad_id' => 'Código Contabilidad',
      
      'retiro'     => 'Motivo Retiro',
      'fecha_ret'  => 'Fecha Ingreso/Retiro',
    ];
    self::$_labels = array_merge(self::$_labels, $labels);

    self::$_placeholders = [
    ];

    self::$_widgets = [
      'nombres' => 'text',
      'fecha_ret' => 'date',
    ];

      
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }


}