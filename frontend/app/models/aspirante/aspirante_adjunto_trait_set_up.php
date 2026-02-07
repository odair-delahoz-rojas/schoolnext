<?php

trait AspiranteAdjuntoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;

  /**
   * CONFIGURACIÓN DEL MODELO
   * 'id', 'aspirante_id', 'nombre_archivo', 'titulo', 'created_at', 'updated_at', 'created_by', 'updated_by'
   */
  private function setUp() {

    self::$_fields_show = [
      'all'      => ['id', 'aspirante_id', 'nombre_archivo', 'titulo', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'    => ['id', 'aspirante_id', 'nombre_archivo', 'titulo'],
      'create'   => [],
      'edit'     => [],
      'editUuid' => [],
    ];
  
    self::$_attribs = [
      'nombre'    => 'required="required" maxlength="50"',
      'abrev'     => 'maxlength="10"',
      'id'        => 'required',
      'uuid'      => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'orden'              => 'Orden en el que se muestra en los listados.',
      'nombre'             => 'Máximo 50 caracteres.',
      'abrev'              => 'Máximo 10 caracteres.',
      'seccion_id'         => 'Elija una opción.',
      'salon_default'      => 'Salón por default.',
      'valor_matricula'    => 'Número sin puntos, ni comas, ni tildes.',
      'matricula_palabras' => 'to-do: hidden, hacer en automático',
      'valor_pension'      => 'Número sin puntos, ni comas, ni tildes.',
      'pension_palabras'   => 'to-do: hidden, hacer en automático',
      'proximo_grado'      => 'Próximo grado al promoverse.',
      'proximo_salon'      => 'Próximo salón al promoverse.',
      
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'orden'              => 'Orden',
      'nombre'             => 'Nombre del Grado',
      'abrev'              => 'Abreviatura',
      'seccion_id'         => 'Sección',
      'salon_default'      => 'Salón por defecto',
      'valor_matricula'    => 'Valor Matrícula',
      'matricula_palabras' => 'Valor Matrícula en palabras',
      'valor_pension'      => 'Valor Pensión',
      'pension_palabras'   => 'Valor Pensión en palabras',
      'proximo_grado'      => 'Próximo Grado',
      'proximo_salon'      => 'Próximo Salon',

      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'nombre'             => 'nombre grado',
      'abrev'              => 'abreviatura grado',
      'matricula_palabras' => 'valor matrícula en palabras',
      'pension_palabras'   => 'valor pensión en palabras',
    ];
  
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

  }



}