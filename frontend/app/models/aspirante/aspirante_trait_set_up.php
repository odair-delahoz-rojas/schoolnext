<?php
/**
 * 
 */
trait AspiranteTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, AspiranteTraitProps;

  private function setUp() {
    $date = date("Y-m-d");
    self::$_fields_show = [
      'all'      => [ '1_annios', '1_ciudad', '1_colegio', '1_grados', '1_motivo_ret', '1_telefono', '2_annios', '2_ciudad', '2_colegio', '2_grados', '2_motivo_ret', '2_telefono', 
                      '3_annios', '3_ciudad', '3_colegio', '3_grados', '3_motivo_ret', '3_telefono', 'ante_fecha_ret', 'ante_grado', 'ante_instit', 'ante_instit_dir', 'ante_instit_tel', 
                      'apellido1', 'apellido2', 'barrio', 'ciudad_nac', 'created_at', 'created_by', 'ctrl_llamadas', 'depto_nac', 'direccion', 'documento', 'entrevista', 'estatus', 
                      'extra', 'fecha_entrev', 'fecha_eval', 'fecha_insc', 'fecha_nac', 'grado_aspira', 'id', 'is_active', 'is_fecha_entrev', 'is_fecha_eval', 'is_habeas_data', 
                      'is_pago', 'is_trasladado', 'madre', 'madre_cargo', 'madre_edad', 'madre_email', 'madre_empresa', 'madre_id', 'madre_prof', 'madre_tel_ofi', 'madre_tel_per', 
                      'nombres', 'observaciones', 'padre', 'padre_cargo', 'padre_edad', 'padre_email', 'padre_empresa', 'padre_id', 'padre_prof', 'padre_tel_ofi', 'padre_tel_per', 
                      'pais_nac', 'razones_cambio', 'recomendac', 'result_caste', 'result_ingle', 'result_matem', 'result_plect', 'result_pmate', 'result_scien', 'result_socia', 
                      'sexo', 'telefono1', 'telefono2', 'tiempoinstit', 'tipo_dcto', 'uuid', 'updated_at', 'updated_by' ],

      'index'    => [ 'id', 'is_active', 'grado_aspira', 'estatus', 'is_pago', 'fecha_insc', 'documento', 'nombres', 'apellido1', 'apellido2', 'telefono1', 'ctrl_llamadas', 'fecha_entrev', 'fecha_eval'],

      'create'   => ['1_annios', '1_ciudad', '1_colegio', '1_grados', '1_motivo_ret', '1_telefono', '2_annios', '2_ciudad', '2_colegio', '2_grados', '2_motivo_ret', '2_telefono', 
                     '3_annios', '3_ciudad', '3_colegio', '3_grados', '3_motivo_ret', '3_telefono', 'ante_fecha_ret', 'ante_grado', 'ante_instit', 'ante_instit_dir', 'ante_instit_tel', 
                     'apellido1', 'apellido2', 'barrio', 'ciudad_nac', 'depto_nac', 'direccion', 'documento', 'estatus', 'fecha_insc', 'fecha_nac', 'grado_aspira', 'is_habeas_data', 
                     'madre', 'madre_cargo', 'madre_edad', 'madre_email', 'madre_empresa', 'madre_id', 'madre_prof', 'madre_tel_ofi', 'madre_tel_per', 'nombres', 'padre', 'padre_cargo', 
                     'padre_edad', 'padre_email', 'padre_empresa', 'padre_id', 'padre_prof', 'padre_tel_ofi', 'padre_tel_per', 'pais_nac', 'razones_cambio', 'sexo', 'telefono1', 'telefono2', 
                     'tiempoinstit', 'tipo_dcto'],

      'edit'     => [ '1_annios', '1_ciudad', '1_colegio', '1_grados', '1_motivo_ret', '1_telefono', '2_annios', '2_ciudad', '2_colegio', '2_grados', '2_motivo_ret', '2_telefono', 
                      '3_annios', '3_ciudad', '3_colegio', '3_grados', '3_motivo_ret', '3_telefono', 'ante_fecha_ret', 'ante_grado', 'ante_instit', 'ante_instit_dir', 'ante_instit_tel', 
                      'apellido1', 'apellido2', 'barrio', 'ciudad_nac', 'ctrl_llamadas', 'depto_nac', 'direccion', 'documento', 'entrevista', 'estatus', 
                      'extra', 'fecha_entrev', 'fecha_eval', 'fecha_insc', 'fecha_nac', 'grado_aspira', 'id', 'is_active', 'is_fecha_entrev', 'is_fecha_eval', 'is_habeas_data', 
                      'is_pago', 'is_trasladado', 'madre', 'madre_cargo', 'madre_edad', 'madre_email', 'madre_empresa', 'madre_id', 'madre_prof', 'madre_tel_ofi', 'madre_tel_per', 
                      'nombres', 'observaciones', 'padre', 'padre_cargo', 'padre_edad', 'padre_email', 'padre_empresa', 'padre_id', 'padre_prof', 'padre_tel_ofi', 'padre_tel_per', 
                      'pais_nac', 'razones_cambio', 'recomendac', 'result_caste', 'result_ingle', 'result_matem', 'result_plect', 'result_pmate', 'result_scien', 'result_socia', 
                      'sexo', 'telefono1', 'telefono2', 'tiempoinstit', 'tipo_dcto', 'updated_at', 'updated_by' ],

      'editUuid'     => [ '1_annios', '1_ciudad', '1_colegio', '1_grados', '1_motivo_ret', '1_telefono', '2_annios', '2_ciudad', '2_colegio', '2_grados', '2_motivo_ret', '2_telefono', 
                      '3_annios', '3_ciudad', '3_colegio', '3_grados', '3_motivo_ret', '3_telefono', 'ante_fecha_ret', 'ante_grado', 'ante_instit', 'ante_instit_dir', 'ante_instit_tel', 
                      'apellido1', 'apellido2', 'barrio', 'ciudad_nac', 'ctrl_llamadas', 'depto_nac', 'direccion', 'documento', 'entrevista', 'estatus', 
                      'extra', 'fecha_entrev', 'fecha_eval', 'fecha_insc', 'fecha_nac', 'grado_aspira', 'id', 'is_active', 'is_fecha_entrev', 'is_fecha_eval', 'is_habeas_data', 
                      'is_pago', 'is_trasladado', 'madre', 'madre_cargo', 'madre_edad', 'madre_email', 'madre_empresa', 'madre_id', 'madre_prof', 'madre_tel_ofi', 'madre_tel_per', 
                      'nombres', 'observaciones', 'padre', 'padre_cargo', 'padre_edad', 'padre_email', 'padre_empresa', 'padre_id', 'padre_prof', 'padre_tel_ofi', 'padre_tel_per', 
                      'pais_nac', 'razones_cambio', 'recomendac', 'result_caste', 'result_ingle', 'result_matem', 'result_plect', 'result_pmate', 'result_scien', 'result_socia', 
                      'sexo', 'telefono1', 'telefono2', 'tiempoinstit', 'tipo_dcto', 'updated_at', 'updated_by' ],
    ];
  
    self::$_attribs = [
      'uuid'           => ' required ',      
      'apellido1'      => ' required maxlength="30" ',
      'apellido2'      => ' maxlength="30" ',
      'ciudad_nac'     => ' maxlength="50" ',
      'documento'      => ' maxlength="10"  maxsize="12" required ',
      'fecha_insc'     => ' required ',
      'id'             => ' required ',
      'is_habeas_data' => ' required ',
      'nombres'        => ' required maxlength="50" ', 
    ];
    
    self::$_defaults = [
      'ctrl_llamadas'  => 0,
      'ciudad_nac'     => 'Valledupar',
      'depto_nac'      => 'Cesar',
      'pais_nac'       => 'Colombia',
      'fecha_insc'     => $date,
      'fecha_nac'      => $date,
      'is_active'      => 1,
      'is_habeas_data' => 1,
      'is_pago'        => 0,
      'is_trasladado'  => 0,
      'madre_edad'     => '18',
      'padre_edad'     => '18',
      'sexo'           => 'Masculino',
      'tipo_dcto'      => 'TI',
      'created_at'     => $date,
      'created_by'     => 0,
    ];
    
    self::$_widgets = [
    '1_annios'     =>  'text',
    '1_ciudad'     =>  'text',
    '1_colegio'    =>  'text',
    '1_grados'     =>  'text',
    '1_motivo_ret' =>  'text',
    '1_telefono'   =>  'text',
    
    '2_annios'     =>  'text',
    '2_ciudad'     =>  'text',
    '2_colegio'    =>  'text',
    '2_grados'     =>  'text',
    '2_motivo_ret' =>  'text',
    '2_telefono'   =>  'text',
    
    '3_annios'     =>  'text',
    '3_ciudad'     =>  'text',
    '3_colegio'    =>  'text',
    '3_grados'     =>  'text',
    '3_motivo_ret' =>  'text',
    '3_telefono'   =>  'text',

    'ante_fecha_ret' =>  'date',
    'ante_grado' =>  'text',
    'ante_instit' =>  'text',
    'ante_instit_dir' =>  'text',
    'ante_instit_tel' =>  'text',

    'apellido1' =>  'text',
    'apellido2' =>  'text',
    
    'barrio' =>  'text',
    'ciudad_nac' =>  'text',
    'created_at' =>  'datetime',
    'created_by' =>  'text',
    'ctrl_llamadas' =>  'check',
    'depto_nac' =>  'text',
    'direccion' =>  'text',
    'documento' =>  'text',
    'entrevista' =>  'textarea',
    'estatus' =>  'select',
    'fecha_entrev' =>  'datetime-local',
    'fecha_eval' =>  'datetime-local',
    'fecha_insc' =>  'date',
    'fecha_nac' =>  'date',
    'grado_aspira' =>  'select',
    'id' =>  'text',    
    'is_active' =>  'check',

    'is_fecha_entrev' =>  'check',
    'is_fecha_eval' =>  'check',

    'is_habeas_data' =>  'check',
    'is_pago' =>  'check',
    'is_trasladado' =>  'check',
    
    'madre' =>  'text',
    'madre_cargo' =>  'text',
    'madre_edad' =>  'number',
    'madre_email' =>  'email',
    'madre_empresa' =>  'text',
    'madre_id' =>  'text',
    'madre_prof' =>  'text',
    'madre_tel_ofi' =>  'text',
    'madre_tel_per' =>  'text',
    
    'nombres' =>  'text',
    'observaciones' =>  'textarea',
    
    'padre' =>  'text',
    'padre_cargo' =>  'text',
    'padre_edad' =>  'number',
    'padre_email' =>  'email',
    'padre_empresa' =>  'text',
    'padre_id' =>  'text',
    'padre_prof' =>  'text',
    'padre_tel_ofi' =>  'text',
    'padre_tel_per' =>  'text',
    
    'pais_nac' =>  'text',
    'razones_cambio' =>  'textarea',
    'recomendac' =>  'textarea',
    'result_caste' =>  'select',
    'result_ingle' =>  'select',
    'result_matem' =>  'select',
    'result_plect' =>  'select',
    'result_pmate' =>  'select',
    'result_scien' =>  'select',
    'result_socia' =>  'select',
    'sexo' =>  'check',
    'telefono1' =>  'text',
    'telefono2' =>  'text',
    'tiempoinstit' =>  'text',
    'tipo_dcto' =>  'select',

    'updated_at' =>  'datetime',
    'updated_by' =>  'text',

    ];

    self::$_helps = [
      '1_colegio' =>  'Nombre Colegio',
      '1_grados' =>  'Grado que cursó',
      '2_colegio' =>  'Nombre Colegio',
      '2_grados' =>  'Grado que cursó',
      '3_colegio' =>  'Nombre Colegio',
      '3_grados' =>  'Grado que cursó',
      'barrio' =>  'Residencia actual',
      'ciudad_nac' =>  'donde nació',
      'depto_nac' =>  'donde nació',
      'direccion' =>  'Residencia actual',
      'documento' =>  'sin puntos, sin comas, sin letras',
      'pais_nac' =>  'donde nació',
    ];
  
    self::$_labels = [
      '1_annios' =>  'Años',
      '1_ciudad' =>  'Ciudad',
      '1_colegio' =>  'Colegio',
      '1_grados' =>  'Grados',
      '1_motivo_ret' =>  'Motivo retiro',
      '1_telefono' =>  'Teléfono',

      '2_annios' =>  'Años',
      '2_ciudad' =>  'Ciudad',
      '2_colegio' =>  'Colegio',
      '2_grados' =>  'Grados',
      '2_motivo_ret' =>  'Motivo retiro',
      '2_telefono' =>  'Teléfono',

      '3_annios' =>  'Años',
      '3_ciudad' =>  'Ciudad',
      '3_colegio' =>  'Colegio',
      '3_grados' =>  'Grados',
      '3_motivo_ret' =>  'Motivo retiro',
      '3_telefono' =>  'Teléfono',

      'ante_fecha_ret' =>  'F. Retiro',
      'ante_grado' =>  'Grado Retiro',
      'ante_instit' =>  'Nombre Institución',
      'ante_instit_dir' =>  'Dirección',
      'ante_instit_tel' =>  'Teléfonos',

      'apellido1' =>  'Primer apellido',
      'apellido2' =>  'Segundo Apellido',
      'barrio' =>  'Barrio',
      'ciudad_nac' =>  'Ciudad',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'ctrl_llamadas' =>  'Control de Llamadas',
      'depto_nac' =>  'Depto (Estado)',
      'direccion' =>  'Dirección',
      'documento' =>  '# Identificación',
      'entrevista' =>  'Entrevista',
      'estatus' =>  'Estado del Proceso',
      'fecha_entrev' =>  'F. Entrevista',
      'fecha_eval' =>  'F. Evaluación',
      'fecha_insc' =>  'F. Inscripción',
      'fecha_nac' =>  'F. Nacimiento',
      'grado_aspira' =>  'Grado al que Aspira',

      'is_active' =>  'Activo?',

      'is_fecha_eval'   => 'Asistió a <br>Evaluación ?',
      'is_fecha_entrev' => 'Asistió a <br>Entrevista ?',

      'is_habeas_data' =>  'Acepta?',
      'is_pago' =>  'Ya pagó?',
      'is_trasladado' =>  'Trasladado?',

      'madre' =>  'Nombre completo',
      'madre_cargo' =>  'Cargo',
      'madre_edad' =>  'Edad',
      'madre_email' =>  'Email',
      'madre_empresa' =>  'Empresa donde Labora',
      'madre_id' =>  'Identificación',
      'madre_prof' =>  'Profesión',
      'madre_tel_ofi' =>  'Tel. Oficina',
      'madre_tel_per' =>  'Tel. personal',

      'nombres' =>  'Nombres',
      'observaciones' =>  'Observaciones',

      'rel_pad_mad' => 'Relación entre Padre y Madre ',
      'vive_con'=>'Personas con las que vive',

      'padre' =>  'Nombre completo',
      'padre_cargo' =>  'Cargo',
      'padre_edad' =>  'Edad',
      'padre_email' =>  'Email',
      'padre_empresa' =>  'Empresa donde Labora',
      'padre_id' =>  'Identificación',
      'padre_prof' =>  'Profesión',
      'padre_tel_ofi' =>  'Tel. Oficina ',
      'padre_tel_per' =>  'Tel. Personal',

      'pais_nac' =>  'País',
      'razones_cambio' =>  'Razones de cambio de Colegio',
      'recomendac' =>  'Recomendaciones',
      
      'result_caste' =>  'Resultados Castellano',
      'result_ingle' =>  'Resultados Inglés',
      'result_matem' =>  'Resultados Matemáticas',
      'result_plect' =>  'Resultados Prelectoescritura',
      'result_pmate' =>  'Resultados Prematemáticas',
      'result_scien' =>  'Resultados Biología',
      'result_socia' =>  'Resultados Sociales',

      'sexo' =>  'Sexo',
      'telefono1' =>  'Teléfono principal',
      'telefono2' =>  'Teléfono adicional',
      'tiempoinstit' =>  'Tiempo en la institución',
      'tipo_dcto' =>  'Tipo Documento',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = 
    [ 
      'nombres'        => ' Obligatorio ', 
      'apellido1'      => ' Obligatorio ',
      'documento'      => ' Obligatorio ',
    ];

     
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }



}