<?php

trait PsicoRemisionTraitSetUp 
{  
  use TraitForms, TraitValidar, TraitSubirAdjuntos;
  
  private function setUp(): void 
  {
    self::$_fields_show = [
      'all' => [
        'id', 'uuid', 'fecha', 'estado', 'estudiante_id', 'remite_id', 'descripcion', 'estrategias', 'respuesta', 'is_active', 'created_at', 'created_by', 'updated_at', 'updated_by',
      ],
      'index'    => [
        'id', 'uuid', 'fecha', 'estado', 'estudiante_id', 'remite_id', 'descripcion', 'estrategias', 'respuesta', 'is_active',
      ],
      'create'   => [
        'fecha', 'estado', 'estudiante_id', 'remite_id', 'descripcion', 'estrategias', 'respuesta', 'is_active',
      ],
      'edit'     => [
        'fecha', 'estado', 'estudiante_id', 'remite_id', 'descripcion', 'estrategias', 'respuesta', 'is_active',
      ],
    ];
    
    self::$_labels = [
      'is_active'       => '¿Está Activo?',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
    
    self::$_widgets = [
    ];

    self::$_attribs = [
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
    ]; 
  
    self::$_placeholders = [
    ];
  }

  

}