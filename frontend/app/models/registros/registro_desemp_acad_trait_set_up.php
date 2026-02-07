<?php

trait RegistroDesempAcadTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  use RegistroDesempAcadTraitProps;

  private function setUp() 
  {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['created_by', 'estudiante_id', 'fecha', 'annio', 'periodo_id', 'grado_id', 'salon_id' ],
      'create'    => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
      'edit'      => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
      'editUuid'  => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
    ];
  
    self::$_attribs = [
      'estudiante_id'   => 'required',
      'annio'           => 'required',
      'periodo_id'      => 'required',
      'grado_id'        => 'required',
      'salon_id'        => 'required',
      'fortalezas'      => 'required spellcheck = true',
      'dificultades'    => 'required spellcheck = true',
      'compromisos'     => 'required spellcheck = true',
      'fecha'           => 'required',
      'acudiente'       => 'required',
      'director'        => 'required',
      
      'id'       => 'required',
      'uuid'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'   => 1,
    ];
  
    self::$_helps = [
      'foto_acudiente'  => 'Evidencia Acudiente. Archivo tipo imagen [jpg, png, gif, jpeg]',
      'foto_director'   => 'Evidencia Docente. Archivo tipo imagen [jpg, png, gif, jpeg]',
    ];
  
    self::$_labels = [
      'estudiante_id'   => 'Estudiante',
      'annio'           => 'Año',
      'periodo_id'      => 'Periodo',
      'grado_id'        => 'Grado',
      'salon_id'        => 'Salon',
      'fortalezas'      => 'Fortalezas',
      'dificultades'    => 'Dificultades',
      'compromisos'     => 'Compromisos',
      'fecha'           => 'Fecha de Registro',
      'acudiente'       => 'Acudiente',
      'foto_acudiente'  => 'Evidencia Acudiente',
      'director'        => 'Docente',
      'foto_director'   => 'Evidencia Docente',

      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];

  }
  


}