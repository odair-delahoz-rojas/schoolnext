<?php

trait RangoTraitSetUpD {
  
  use TraitUuid, TraitForms, TraitValidar;

  private function setUp() 
  {
    self::$_fields_show = [
      'all'     => ['rowid', 'label', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo', 'created_by', 'updated_by', 'created_at', 'updated_at'],
      'index'   => ['rowid', 'label', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo', 'orden'],
      'create'  => ['label', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo'],
      'edit'    => ['label', 'limite_inferior', 'limite_superior', 'color_rango', 'color_texto', 'color_fondo'],
    ];
  
    self::$_attribs = [
      'rowid'  => 'required',
      'label'  => 'required',
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
      'color_rango' => 'label del color',
      'color_texto' => 'label del color',
      'color_fondo' => 'label del color',
    ];
    
    self::$_labels = [
      'label' => 'label del Rango',
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