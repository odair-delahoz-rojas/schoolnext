<?php

trait RegistrosGenTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  use RegistrosGenTraitProps, RegistrosGenTraitLinks;

  private function setUp() 
  {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'tipo_reg', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fecha', 'asunto', 'acudiente', 'foto_acudiente', 'director', 'foto_director', 
                    'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['tipo_reg', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fecha', 'asunto'],
      'create'    => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'director'],
      'edit'      => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'director'],
      'editUuid'  => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'director'],
    ];
  
    self::$_attribs = [
      'tipo_reg'        => 'required',
      'estudiante_id'   => 'required',
      'annio'           => 'required',
      'periodo_id'      => 'required',
      'grado_id'        => 'required',
      'salon_id'        => 'required',
      'asunto'          => 'required spellcheck = true',
      'fecha'           => 'required',
      //'acudiente'       => 'required',
      //'director'        => 'required',
      'id'              => 'required',
      'uuid'            => 'required',
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'asunto'=>'L&iacute;mite: 1024 caracteres', 
      'acudiente'=>'Nombre del Acudiente que Asisti&oacute; a la reuni&oacute;n',
      'foto_acudiente'=>'Evidencia Acudiente. Archivo tipo imagen [jpg, png, gif, jpeg]',
      'director'=>'Nombre del Director de grupo o Profesor que organiz&oacute;',
      'foto_director'=>'Evidencia Docente. Archivo tipo imagen [jpg, png, gif, jpeg]',
    ];
  
    self::$_labels = [
      'tipo_reg'=>'Tipo Registro',
      'estudiante_id'=>'Estudiante',
      'annio'=>'A&nacute;o', 
      'periodo_id'=>'Periodo',
      'grado_id'=>'Grado', 
      'salon_id'=>'Sal&oacute;n',
      'fecha'=>'Fecha de Registro', 
      'asunto'=>'Asunto', 
      'acudiente'=>'Acudiente', 
      'foto_acudiente'=>'Evidencia acudiente', 
      'director'=>'Docente', 
      'foto_director'=>'Evidencia docente',
      
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
  }
  


}