<?php

trait EmpleadoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, 
  EmpleadoTraitProps, EmpleadoTraitCallBacks;


  private function setUp() 
  {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'photo', 'profesion', 'direccion', 'documento', 'email', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'observacion', 'is_carga_acad_ok', 'is_partner', 'usuario_instit', 'clave_instit', 'theme', 'algorithm', 'salt', 'password', 'is_super_admin', 'last_login', 'forgot_password_code', 'is_active', 'created_at', 'updated_at'],
      'index'     => ['is_active', 'id', 'nombre', 'username', 'roll', 'documento', 'telefono1', 'usuario_instit', 'clave_instit'],
      'create'    => ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm', 'salt', 'password' ],
      'edit'      => ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active'],
      'editUuid'  => ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active'],
    ];
  
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'fecha_nac'          => 'dd/mm/aaaa - Ejemplo: 26/07/1976',
      'documento'          => 'Advertencia!! sin puntos, sin comas.',
      
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Nombre Empleado',
      'username'        => 'Nombre de Usuario',
      'roll'            => 'Roles',
      'usuario_instit'  => 'Usuario TEAMS',
      'clave_instit'    => 'Clave TEAMS',

      'nombres'    => 'Nombre(s)',
      'apellido1'  => 'Primer Apellido',
      'apellido2'  => 'Segundo Apellido',
      'fecha_nac'  => 'Fecha Nacimiento',
      
      'direccion'  => 'Dirección',
      'cargo'      => 'Cargo',
      'documento'  => 'Documento',
      'telefono1'  => 'Teléfono Principal',
      'telefono2'  => 'Teléfono Secundario',
      'sexo'       => 'Sexo',
      
      'profesion'         => 'Profesión',
      'is_carga_acad_ok'  => 'Carga Académicas',
      
      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];

      
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);

    
  }



}