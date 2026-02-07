<?php

trait GradoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;
  
  public function _beforeCreate(): void {
    parent::_beforeCreate();
    $this->abrev = strtoupper(trim($this->abrev));
    $this->matricula_palabras = $this->valor_letras($this->valor_matricula);
    $this->pension_palabras = $this->valor_letras($this->valor_pension);
  }
 
  
  public function _beforeUpdate(): void {
    parent::_beforeUpdate();
    $this->abrev = strtoupper(trim($this->abrev));
    $this->matricula_palabras = $this->valor_letras($this->valor_matricula);
    $this->pension_palabras = $this->valor_letras($this->valor_pension);
  }
 
  private function setUp() {

    self::$_fields_show = [
      'all'      => ['nombre', 'salon_default', 'proximo_salon', 'proximo_grado', 'seccion_id', 'orden', 'abrev', 
                     'valor_matricula', 'matricula_palabras', 'valor_pension', 'pension_palabras', 
                     'id', 'uuid', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'],
      'index'    => ['is_active', 'nombre', 'abrev', 'seccion_id', 'valor_matricula', 'valor_pension'],
      'create'   => ['nombre', 'salon_default', 'proximo_salon', 'proximo_grado', 'seccion_id', 'orden', 'abrev', 'valor_matricula', 'valor_pension'],
      'edit'     => ['nombre', 'salon_default', 'proximo_salon', 'proximo_grado', 'seccion_id', 'orden', 'abrev', 'valor_matricula', 'valor_pension'],
      'editUuid' => ['nombre', 'salon_default', 'proximo_salon', 'proximo_grado', 'seccion_id', 'orden', 'abrev', 'valor_matricula', 'valor_pension'],
      'excel'    => ['is_active', 'nombre', 'abrev', 'seccion_id', 'valor_matricula', 'valor_pension'],
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
  
  }



}