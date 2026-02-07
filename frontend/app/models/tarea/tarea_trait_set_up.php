<?php

trait TareaTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  use TareaTraitProps;

  private function setUp() 
  {

    self::$_fields_show = [
      'all'      => ['id', 'uuid', 'modulo', 'seccion', 'nombre', 'descripcion', 'prioridad', 'fecha_ini', 'fecha_fin', 'estado', 'avance', 'is_active', 'created_at', 'created_by', 'updated_at', 'updated_by'],
      'index'    => ['modulo', 'nombre', 'seccion', 'prioridad', 'fecha_ini', 'fecha_fin', 'avance'],
      'create'   => ['modulo', 'seccion', 'nombre', 'descripcion', 'prioridad', 'fecha_ini', 'fecha_fin', 'estado', 'avance'],
      'edit'     => ['modulo', 'seccion', 'nombre', 'descripcion', 'prioridad', 'fecha_ini', 'fecha_fin', 'estado', 'avance', 'is_active'],
      'editUuid' => ['modulo', 'seccion', 'nombre', 'descripcion', 'prioridad', 'fecha_ini', 'fecha_fin', 'estado', 'avance', 'is_active'],
    ];
  
    self::$_attribs = [
      'modulo'        => 'required',
      'seccion'       => 'required',
      'nombre'        => 'required',
      'descripcion'   => 'required',
      'prioridad'     => 'required',
      'fecha_ini'     => 'required',
      //'fecha_fin'     => '',
      'estado'        => 'required',
      'avance'        => 'step="5" min:"0" max:"100"',
    ];
  
    self::$_defaults = [
      //'modulo'        => '',
      //'seccion'       => '',
      //'nombre'        => '',
      //'descripcion'   => '',
      'prioridad'     => 'Normal',
      //'fecha_ini'     => '',
      //'fecha_fin'     => '',
      'estado'        => 'No iniciada',
      'avance'        => 0,
      'is_active'     => 1,
    ];
  
    self::$_helps = [
      'modulo'        => 'Módulo del Sistema',
      //'seccion'       => '',
      //'nombre'        => '',
      //'descripcion'   => '',
      'prioridad'     => 'Baja, Normal, Alta',
      'fecha_ini'     => 'Fecha de asignación de la Tarea',
      'fecha_fin'     => 'Fecha estimada para finalizar la Tarea',
      'estado'        => 'No iniciada, En progreso, Completada, Descartada',
      'avance'        => 'Porcentaje de Avance (0% -> 100%)',
      'is_active'     => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'modulo'        => 'Módulo',
      'seccion'       => 'Sección',
      'nombre'        => 'Tarea',
      'descripcion'   => 'Descripción tarea',
      'prioridad'     => 'Prioridad',
      'fecha_ini'     => 'Fecha inicio',
      'fecha_fin'     => 'Fecha fin',
      'estado'        => 'Estado',
      'avance'        => 'Avance',

      'id'              => 'ID',
      'uuid'            => 'UUID',
      'is_active'       => 'Está Activo?',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'modulo'         => 'Docentes, Coordinador, Secreatria, etc',
      'seccion'        => 'al calificar, al crear indicador, etc',
      'nombre'          => 'nombre corto de la tarea',
      'descripcion'    => '',
    ];

  }



}