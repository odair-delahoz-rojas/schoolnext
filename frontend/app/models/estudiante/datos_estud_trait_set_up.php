<?php

trait DatosEstudTraitSetUp {
  
  use TraitUuid, TraitValidar, TraitForms;
  use DatosEstudTraitProps;

  private function setUp() {

    self::$_fields_show = [
      'all' => [
        'id', 'uuid', 'estudiante_id', 'pais_nac', 'depto_nac', 'ciudad_nac', 'religion', 
        'madre', 'madre_id', 'madre_dir', 'madre_tel_1', 'madre_tel_2', 'madre_email', 'madre_ocupa', 'madre_lugar_tra', 'madre_tiempo_ser', 
        'padre', 'padre_id', 'padre_dir', 'padre_tel_1', 'padre_tel_2', 'padre_email', 'padre_ocupa', 'padre_lugar_tra', 'padre_tiempo_ser', 
        'tipo_acudi', 'parentesco', 'acudiente', 'acudi_id', 'acudi_dir', 'acudi_tel_1', 'acudi_tel_2', 'acudi_email', 'acudi_ocupa', 'acudi_lugar_tra', 
        'ante_instit', 'ante_instit_dir', 'ante_grado', 'ante_fecha_ret', 'ante_instit_tel', 
        'grupo_sang', 'salud_eps', 'salud_antec_med_fam', 'salud_alergico', 'salud_cirugias', 'salud_enfermedades', 
        'salud_tratamientos', 'salud_trastornos_alim', 'salud_medicam_prohibi', 'salud_aliment_prohibi', 'salud_comentarios', 
        'deudor', 'codeudor', 'codeudor_cc', 'resp_pago_ante_dian', 'observacion', 
        'created_at', 'created_by', 'updated_at', 'updated_by', 
      ],

      'index'  => [
        'id', 'uuid', 'estudiante_id', 
        'madre', 'madre_id', 'madre_tel_1', 'madre_email',
        'padre', 'padre_id', 'padre_tel_1', 'padre_email',
        'created_at', 'updated_at', 
      ],

      'create' => [
        'estudiante_id', 'pais_nac', 'depto_nac', 'ciudad_nac', 'religion', 
        'madre', 'madre_id', 'madre_dir', 'madre_tel_1', 'madre_tel_2', 'madre_email', 'madre_ocupa', 'madre_lugar_tra', 'madre_tiempo_ser', 
        'padre', 'padre_id', 'padre_dir', 'padre_tel_1', 'padre_tel_2', 'padre_email', 'padre_ocupa', 'padre_lugar_tra', 'padre_tiempo_ser', 
        'tipo_acudi', 'parentesco', 'acudiente', 'acudi_id', 'acudi_dir', 'acudi_tel_1', 'acudi_email', 'acudi_ocupa', 'acudi_lugar_tra', 
        'ante_instit', 'ante_instit_dir', 'ante_grado', 'ante_fecha_ret', 'ante_instit_tel', 
        'grupo_sang', 'salud_eps', 'salud_antec_med_fam', 'salud_alergico', 'salud_cirugias', 'salud_enfermedades', 
        'salud_tratamientos', 'salud_trastornos_alim', 'salud_medicam_prohibi', 'salud_aliment_prohibi', 'salud_comentarios', 
        'deudor', 'codeudor', 'codeudor_cc', 'resp_pago_ante_dian', 'observacion', 
      ],

      'edit'  => [
        'pais_nac', 'depto_nac', 'ciudad_nac', 'religion', 
        'madre', 'madre_id', 'madre_dir', 'madre_tel_1', 'madre_tel_2', 'madre_email', 'madre_ocupa', 'madre_lugar_tra', 'madre_tiempo_ser', 
        'padre', 'padre_id', 'padre_dir', 'padre_tel_1', 'padre_tel_2', 'padre_email', 'padre_ocupa', 'padre_lugar_tra', 'padre_tiempo_ser', 
        'tipo_acudi', 'parentesco', 'acudiente', 'acudi_id', 'acudi_dir', 'acudi_tel_1', 'acudi_email', 'acudi_ocupa', 'acudi_lugar_tra', 
        'ante_instit', 'ante_instit_dir', 'ante_grado', 'ante_fecha_ret', 'ante_instit_tel', 
        'grupo_sang', 'salud_eps', 'salud_antec_med_fam', 'salud_alergico', 'salud_cirugias', 'salud_enfermedades', 
        'salud_tratamientos', 'salud_trastornos_alim', 'salud_medicam_prohibi', 'salud_aliment_prohibi', 'salud_comentarios', 
        'deudor', 'codeudor', 'codeudor_cc', 'resp_pago_ante_dian', 'observacion', 
      ],

      'edituuid'  => [ 'pais_nac', 'depto_nac', 'ciudad_nac', 'religion', 
        'madre', 'madre_id', 'madre_dir', 'madre_tel_1', 'madre_tel_2', 'madre_email', 'madre_ocupa', 'madre_lugar_tra', 'madre_tiempo_ser', 
        'padre', 'padre_id', 'padre_dir', 'padre_tel_1', 'padre_tel_2', 'padre_email', 'padre_ocupa', 'padre_lugar_tra', 'padre_tiempo_ser', 
        'tipo_acudi', 'parentesco', 'acudiente', 'acudi_id', 'acudi_dir', 'acudi_tel_1', 'acudi_email', 'acudi_ocupa', 'acudi_lugar_tra', 
        'ante_instit', 'ante_instit_dir', 'ante_grado', 'ante_fecha_ret', 'ante_instit_tel', 
        'grupo_sang', 'salud_eps', 'salud_antec_med_fam', 'salud_alergico', 'salud_cirugias', 'salud_enfermedades', 
        'salud_tratamientos', 'salud_trastornos_alim', 'salud_medicam_prohibi', 'salud_aliment_prohibi', 'salud_comentarios', 
        'deudor', 'codeudor', 'codeudor_cc', 'resp_pago_ante_dian', 'observacion', 
      ],

    ];
  
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
      'resp_pago_ante_dian' => 'required',

      'madre' => ' size="45"',
      'madre_email' => ' size="45"',
      'padre' => ' size="45"',
      'padre_email' => ' size="45"',
    ];
  
    self::$_labels = [
      'estudiante_id' => 'Estudiante ID',
      'pais_nac' => 'País de Nac.',
      'depto_nac' => 'Depto de Nac.',
      'ciudad_nac' => 'Ciudad de Nac.',
      'religion' => 'Religión',
                
      'madre' => 'Madre',
      'madre_id' => 'Identificación', 
      'madre_dir' => 'Dirección', 
      'madre_tel_1' => 'Teléfono Personal', 
      'madre_tel_2' => 'Teléfono Trabajo', 
      'madre_email' => 'Email', 
      'madre_ocupa' => 'Ocupación', 
      'madre_lugar_tra' => 'Lugar de Trabajo', 
      'madre_tiempo_ser' => 'Tiempo de Servicio',

      'padre' => 'Padre', 
      'padre_id' => 'Identificación', 
      'padre_dir' => 'Dirección', 
      'padre_tel_1' => 'Teléfono Personal', 
      'padre_tel_2' => 'Teléfono Trabajo', 
      'padre_email' => 'Email', 
      'padre_ocupa' => 'Ocupación', 
      'padre_lugar_tra' => 'Lugar de Trabajo', 
      'padre_tiempo_ser' => 'Tiempo de Servicio', 
      
      'tipo_acudi' => 'Tipo de Acudiente', 
      'parentesco' => 'Prentesco', 
      'acudiente' => 'Acudiente', 
      'acudi_id' => 'Identificación', 
      'acudi_dir' => 'Dirección', 
      'acudi_tel_1' => 'Teléfono Personal', 
      'acudi_tel_2' => 'Teléfono Trabajo', 
      'acudi_email' => 'Email', 
      'acudi_ocupa' => 'Ocupación', 
      'acudi_lugar_tra' => 'Lugar de Trabajo', 
       
      'ante_instit' => 'Institución Anterior', 
      'ante_instit_dir' => 'Dirección', 
      'ante_grado' => 'Grado Cursado', 
      'ante_fecha_ret' => 'Fecha Retiro', 
      'ante_instit_tel' => 'Teléfono Institución', 
      
      'grupo_sang' => 'Grupo Sanguineo', 
      'salud_eps' => 'E.P.S.', 
      'salud_antec_med_fam' => 'Antecedentes Familiares', 
      'salud_alergico' => 'Alergico a ?', 
      'salud_cirugias' => 'Cirugias', 
      'salud_enfermedades' => 'Enfermedades Actuales',
      'salud_tratamientos' => 'Tratamientos', 
      'salud_trastornos_alim' => 'Trastornos Alimenticios', 
      'salud_medicam_prohibi' => 'Medicamentos Prohibidos', 
      'salud_aliment_prohibi' => 'Alimentos Prohibidos',
      'salud_comentarios' => 'Coemtarios Adcionales',
      
      'deudor' => 'Deudor',
      'codeudor' => 'Codeudor',
      'codeudor_cc' => 'ID del Codeudor',
      'resp_pago_ante_dian' => 'Responsable ente la DIAN',
      
      'observacion' => 'Obervaciones Adicionales',
      
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];  

    self::$_widgets = [
      'ante_fecha_ret' => 'date',
    ];

  }



}