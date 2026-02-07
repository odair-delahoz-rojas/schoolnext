<?php

trait RangoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;

  private function setUp() 
  {
    self::$_fields_show = [
      'all'     => ['rowid', 'nombre', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo', 'created_by', 'updated_by', 'created_at', 'updated_at'],
      'index'   => ['rowid', 'nombre', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo', 'orden'],
      'create'  => ['nombre', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo'],
      'edit'    => ['nombre', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo'],
    ];
  
    self::$_attribs = [
      'id'  => 'required',
      'nombre'  => 'required',
      'limite_inferior' => 'required',
      'limite_superior' => 'required',
    ];
  
    self::$_defaults = [
      'limite_inferior'  => 0,
      'limite_superior'  => 0,
      'color_rango' => '',
      'color_texto' => '',
      'color_fondo' => '',
    ];
  
    self::$_helps = [
      'color_rango' => 'nombre del color',
      'color_texto' => 'nombre del color',
      'color_fondo' => 'nombre del color',
    ];
    
    self::$_labels = [
      'nombre' => 'Nombre del Rango',
      'limite_inferior' => 'Límite Inferior',
      'limite_superior' => 'Límite Superior',
      'color_rango' => 'Color del Rango',
      'color_texto' => 'Color de Texto',
      'color_fondo' => 'Color de Fondo',
      'orden' => 'Ordenamiento',

      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];

  }




}