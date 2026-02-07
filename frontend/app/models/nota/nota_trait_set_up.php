<?php

trait NotaTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, 
  NotaTraitProps, NotaTraitLinks, NotaTraitCorrecciones;

  private function setUp() {
    //$rango_nota = new Rango();
    //$nota_maxima = $rango_nota->getLimiteSuperior(Rangos::Superior);
    $nota_maxima = (INSTITUTION_KEY=='santarosa') ? 50 : 100;

    self::$_fields_show = [
      'all'     => ['id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
            'asignatura', 'estudiante', 'email_envios', 'asi_num_envios', 'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
            'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20', 
            'i21', 'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28', 'i29', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 
            'asi_desempeno', 'asi_activ_profe', 'asi_activ_estud', 'asi_fecha_entrega', 'asi_link_externo1', 'asi_link_externo2', 'paf_link_externo1', 'paf_link_externo2', 
            'paf_temas', 'paf_acciones', 'paf_activ_estud', 'paf_activ_profe', 'paf_fecha_entrega', 
            'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 'paf_num_envios', 
            'is_asi_validar_ok', 'asi_calificacion', 'is_asi_ok_dirgrupo', 'is_asi_ok_coord',
            'ausencias', 'inthoraria', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'filtrar'   => ['id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'definitiva', 'plan_apoyo', 'nota_final', 'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10'],
      'create'    => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'edit'      => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'editUuid'  => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'calificar' => ['definitiva', 'plan_apoyo', 'nota_final', 'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20'],
    ];
  
    self::$_widgets = [
      'definitiva'    => 'number',
      'plan_apoyo'    => 'number',
      'nota_final'    => 'number',

      'asi_desempeno'    => 'text',
      'asi_calificacion' => 'number',
      'asi_fecha_entrega' => 'date',
      'asi_activ_profe' => 'textarea',
      'asi_activ_estud' => 'textarea',

      'paf_fecha_entrega' => 'date',
      'paf_temas' => 'textarea',
      'paf_acciones' => 'textarea',
      'paf_activ_profe' => 'textarea',
      'paf_activ_estud' => 'textarea',

      'i01'   => 'number', 
      'i02'   => 'number', 
      'i03'   => 'number', 
      'i04'   => 'number', 
      'i05'   => 'number', 
      'i06'   => 'number', 
      'i07'   => 'number', 
      'i08'   => 'number', 
      'i09'   => 'number', 
      'i10'   => 'number', 

      'i11'   => 'number', 
      'i12'   => 'number', 
      'i13'   => 'number', 
      'i14'   => 'number', 
      'i15'   => 'number', 
      'i16'   => 'number', 
      'i17'   => 'number', 
      'i18'   => 'number', 
      'i19'   => 'number', 
      'i20'   => 'number', 
      
      'i21'   => 'number', 
      'i22'   => 'number', 
      'i23'   => 'number', 
      'i24'   => 'number', 
      'i25'   => 'number', 
      'i26'   => 'number', 
      'i27'   => 'number', 
      'i28'   => 'number', 
      'i29'   => 'number', 
      'i30'   => 'number', 
      
      'i31'   => 'number', 
      'i32'   => 'number', 
      'i33'   => 'number', 
      'i34'   => 'number', 
      'i35'   => 'number', 
      'i36'   => 'number', 
      'i37'   => 'number', 
      'i38'   => 'number', 
      'i39'   => 'number', 
      'i40'   => 'number', 
    ];

    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required', 

      'definitiva'   => ' min="0" max="'.$nota_maxima.'" maxlength="3" size="3" ',
      'plan_apoyo'   => ' min="0" max="'.$nota_maxima.'" maxlength="3" size="3" ',
      'nota_final'   => ' min="0" max="'.$nota_maxima.'" maxlength="3" size="3" ',

      'paf_temas' => ' cols=35 rows=4 maxlength="1000" ',
      'paf_acciones' => ' cols=35 rows=4 maxlength="1000" ',
      'paf_activ_profe' => 'cols=35 rows=4 maxlength="1000" ',
      'paf_activ_estud' => 'cols=35 rows=4 maxlength="1000" ',

      //'asi_desempeno'    => 'text',
      'asi_calificacion' => ' min="0" max="'.$nota_maxima.'" maxlength="3" size="3" ',
      //'asi_fecha_entrega' => '',
      'asi_activ_profe' => ' cols=35 rows=4 maxlength="1000" ',
      'asi_activ_estud' => ' cols=35 rows=4 maxlength="1000" ',

      
      'i01'   => ' maxlength="4" size="4" ',
      'i02'   => ' maxlength="4" size="4" ',
      'i03'   => ' maxlength="4" size="4" ',
      'i04'   => ' maxlength="4" size="4" ',
      'i05'   => ' maxlength="4" size="4" ',
      'i06'   => ' maxlength="4" size="4" ',
      'i07'   => ' maxlength="4" size="4" ',
      'i08'   => ' maxlength="4" size="4" ',
      'i09'   => ' maxlength="4" size="4" ',
      'i10'   => ' maxlength="4" size="4" ',

      'i11'   => ' maxlength="4" size="4" ',
      'i12'   => ' maxlength="4" size="4" ',
      'i13'   => ' maxlength="4" size="4" ',
      'i14'   => ' maxlength="4" size="4" ',
      'i15'   => ' maxlength="4" size="4" ',
      'i16'   => ' maxlength="4" size="4" ',
      'i17'   => ' maxlength="4" size="4" ',
      'i18'   => ' maxlength="4" size="4" ',
      'i19'   => ' maxlength="4" size="4" ',
      'i20'   => ' maxlength="4" size="4" ',
      
      'i21'   => ' maxlength="4" size="4" ',
      'i22'   => ' maxlength="4" size="4" ',
      'i23'   => ' maxlength="4" size="4" ',
      'i24'   => ' maxlength="4" size="4" ',
      'i25'   => ' maxlength="4" size="4" ',
      'i26'   => ' maxlength="4" size="4" ',
      'i27'   => ' maxlength="4" size="4" ',
      'i28'   => ' maxlength="4" size="4" ',
      'i29'   => ' maxlength="4" size="4" ',
      'i30'   => ' maxlength="4" size="4" ',
      
      'i31'   => ' maxlength="4" size="4" ',
      'i32'   => ' maxlength="4" size="4" ',
      'i33'   => ' maxlength="4" size="4" ',
      'i34'   => ' maxlength="4" size="4" ',
      'i35'   => ' maxlength="4" size="4" ',
      'i36'   => ' maxlength="4" size="4" ',
      'i37'   => ' maxlength="4" size="4" ',
      'i38'   => ' maxlength="4" size="4" ',
      'i39'   => ' maxlength="4" size="4" ',
      'i40'   => ' maxlength="4" size="4" ',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'       => 'Indica si está activo el registro.',
      'paf_activ_profe' => 'máx. 1024 caracteres.',
      'paf_activ_estud' => 'máx. 1024 caracteres.',
      
      'asi_activ_profe' => 'máx. 1000 caracteres.',
      'asi_activ_estud' => 'máx. 1000 caracteres.',
    ];
    
    self::$_labels = [
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',

      'annio' => 'Año', 
      'periodo_id'=> 'Periodo', 
      'grado_id'=> 'Grado', 
      'salon_id'=> 'Salón', 
      'asignatura_id'=> 'Asignatura', 
      'estudiante_id'=> 'Estudiante', 

      'definitiva'   => 'Definitiva',
      'plan_apoyo'   => 'P. Apoyo',
      'nota_final'   => 'N. Final',

      'paf_fecha_entrega' => 'F Entrega',
      'paf_temas' => 'Temas',
      'paf_acciones' => 'Acciones',
      'paf_activ_profe' => 'Actividades Realizadas por el Profesor',
      'paf_activ_estud' => 'Actividades para el Estudiante',
      
      'asi_desempeno'     => 'Desempeño',
      'asi_calificacion'  => 'Nota',
      'asi_fecha_entrega' => 'Fecha de entrega',
      'asi_activ_profe'   => (INSTITUTION_KEY=='santarosa') ? 'Observaciones' : 'Actividades Realizadas por el Profesor',
      'asi_activ_estud'   => 'Actividades para el Estudiante',
    ];
     

    self::$_placeholders = [
      'paf_activ_profe' => (INSTITUTION_KEY=='santarosa') ? 'Observaciones' : 'Describa las actividades realizadas por el docente para apoyar al estudiante.',
      'paf_activ_estud' => 'Describa la estrategia para la superacion de la dificultad.',
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
        /*
        'NombreCompleto' => [
				  'required' => [ 'error' => 'Indique su nombre.' ],
				  'alpha'    => [ 'error' => 'Nombre incompleto o incorrecto.' ]
			  ],
			  'Email' => [
				  'required' => [ 'error' => 'Indique su email.' ],
				  'email'    => [ 'error' => 'Email incorrecto.' ]
			  ],
			  'Movil' => [
				  'required' => [ 'error' => 'Indique su teléfono / móvil.' ],
				  'length'   => [ 'min' => '9', 'max' => '17', 'error' => 'Teléfono / móvil incorrecto' ],
          'pattern'  => [ 'regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 'error'  => 'Teléfono incorrecto. ejemplo. +34 862929929']
        ], 
        */
    ];

  }
} //END-SetUp