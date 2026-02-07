<?php

trait IndicadorTraitSetUp {
/* 
  public int $id; 
  public string $uuid; 
  public string $annio; 
  public int $periodo_id; 
  public int $grado_id; 
  public string $grado_nombre; 
  public int $asignatura_id; 
  public string $asignatura_nombre; 
  public string $codigo; 
  public string $concepto; 
  public string $valorativo; 
  public int $is_visible; 
  public int $is_active; 
  public string $created_at; 
  public string $updated_at; 
  public string $created_by; 
  public string $updated_by; */

  use TraitUuid, TraitForms, TraitValidar,
    IndicadorTraitProps;


  private function setUp() {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['is_active', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'valorativo'],
      'create'    => ['codigo', 'concepto', 'valorativo'],
      'edit'      => ['concepto', 'is_visible', 'is_active'],
      'editUuid'  => ['concepto', 'is_visible', 'is_active'],
      'filtrar'   => ['id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'concepto', 'valorativo', 'is_active'],
    ];
  
    self::$_attribs = [
      'id'          => 'required',
      'uuid'        => 'required',
      'codigo'      => 'required',
      'concepto'    => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
      'is_visible'      => 1,
    ];
  
    self::$_helps = [
      'codigo'       => 'Min: 100 - Max: 399 [Excepto Inglés]',
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'annio'           => 'Año',
      'periodo_id'      => 'Periodo',
      'grado_id'        => 'Grado',
      'asignatura_id'   => 'Asignatura',
      'codigo'          => 'Código',
      'concepto'        => 'Concepto',
      'valorativo'      => 'Valorativo',
      'is_visible'      => 'Visible en Calificar?',

      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'codigo'     => 'Fort:100-199 - Debil:200-299 - Recom:300-399',
    ];

  }



}