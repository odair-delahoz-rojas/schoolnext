<?php

trait SalAsigProfTraitSetUp {
  
  use SalAsigProfTraitProps, SalAsigProfTraitLinks;


  private function setUp() 
  {

    self::$_fields_show = [
      'all'     => ['id', 'salon_id', 'asignatura_id', 'user_id', 'pend_cal_p1', 'pend_cal_p2', 'pend_cal_p3', 'pend_cal_p4', 'pend_cal_p5'],
      'index'   => ['id', 'salon_id', 'asignatura_id', 'user_id'],
      'create'  => ['salon_id', 'asignatura_id', 'user_id', 'pend_cal_p1', 'pend_cal_p2', 'pend_cal_p3', 'pend_cal_p4', 'pend_cal_p5'],
      'edit'    => ['salon_id', 'asignatura_id', 'user_id', 'pend_cal_p1', 'pend_cal_p2', 'pend_cal_p3', 'pend_cal_p4', 'pend_cal_p5'],
    ];
  
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
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