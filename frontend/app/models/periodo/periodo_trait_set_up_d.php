<?php

trait PeriodoTraitSetUpD {
  
  use TraitUuid, TraitForms, TraitValidar,
  PeriodoTraitPropsD;
  
  private function setUp(): void {
    
    self::$_fields_show = [
      'all'     => [],
      'index'   => [],
      'create'  => [],
      'edit'    => [],
    ];
    
    self::$_attribs = [];

    self::$_defaults = [];

    self::$_helps = [];

    self::$_labels = [
      'rowid' => 'ID',
      'ref' => 'Referencia',
      'label' => 'Etiqueta',
      'status' => 'Estado',

      'import_key' => 'Lllave de importación',
      'model_pdf' => 'Modelo PDF',
      'last_main_doc' => '',
      'date_creation' => 'Fecha de Creación',
      'tms' => '',
      'fk_user_creat' => '',
      'fk_user_modif' => '',

      'fecha_inicio' => '',
      'fecha_fin' => '',
      'f_ini_logro' => '',
      'f_fin_logro' => '',
      'f_ini_seguimientos' => '',
      'f_fin_seguimientos' => '',
      'f_ini_preinformes' => '',
      'f_fin_preinformes' => '',
      'f_ini_planes_apoyo' => '',
      'f_fin_planes_apoyo' => '',
      'f_ini_notas' => '',
      'f_fin_notas' => '',
      'f_open_day' => '',

      'mes_req_boletin' => '',
      'orden' => '',

      'seguimientos_abrir' => '',
      'seguimientos_cerrar' => '',
      'preinformes_abrir' => '',
      'preinformes_cerrar' => '',
      'boletines_abrir' => '',
      'boletines_cerrar' => '',
      'planes_apoyo_abrir' => '',
      'planes_apoyo_cerrar' => '',

    ];
  
    self::$_placeholders = [];

  }



}