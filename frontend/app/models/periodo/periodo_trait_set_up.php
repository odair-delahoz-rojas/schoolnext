<?php

trait PeriodoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  
  private function setUp(): void {
    
    self::$_fields_show = [
      'all'     => ['rowid', 'periodo', 'fecha_inicio', 'fecha_fin', 'f_ini_logro', 'f_fin_logro', 'f_ini_notas', 'f_fin_notas', 'f_open_day', 'created_by', 'updated_by', 'created_at', 'updated_at', 'mes_req_boletin'],
      'index'   => ['rowid', 'periodo', 'fecha_inicio', 'fecha_fin', 'f_ini_logro', 'f_fin_logro', 'f_ini_notas', 'f_fin_notas', 'f_open_day'],
      'create'  => ['periodo', 'fecha_inicio', 'fecha_fin', 'f_ini_logro', 'f_fin_logro', 'f_ini_notas', 'f_fin_notas', 'f_open_day', 'mes_req_boletin'],
      'edit'    => ['periodo', 'fecha_inicio', 'fecha_fin', 'f_ini_logro', 'f_fin_logro', 'f_ini_notas', 'f_fin_notas', 'f_open_day', 'mes_req_boletin'],
    ];
    
    self::$_attribs = [
      'periodo'       => 'required', 
      'fecha_inicio'  => 'required', 
      'fecha_fin'     => 'required', 
      'f_ini_logro'   => 'required', 
      'f_fin_logro'   => 'required', 
      'f_ini_notas'   => 'required', 
      'f_fin_notas'   => 'required', 
      'f_open_day'    => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];

  }



}