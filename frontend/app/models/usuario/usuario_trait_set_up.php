<?php

trait UsuarioTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar,
      UsuarioTraitProps, UsuarioTraitSetters;  

  private function setUp() 
  {
    self::$_fields_show['all']      = ['id', 'uuid', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'photo', 'profesion', 'direccion', 'documento', 'email', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'observacion', 'is_carga_acad_ok', 'is_partner', 'usuario_instit', 'clave_instit', 'theme', 'algorithm', 'salt', 'password', 'is_super_admin', 'last_login', 'forgot_password_code', 'is_active', 'created_at', 'updated_at'];
    self::$_fields_show['index']    = ['is_active', 'id', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email'];
    self::$_fields_show['create']   = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm' ];
    self::$_fields_show['edit']     = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm', 'uuid' ];
    self::$_fields_show['editUuid'] = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm', 'uuid' ];
  
    self::$_attribs = [
      'id'  => 'required',
    ];
  
    self::$_defaults = [
      'is_active' => 1,
      'sexo' => 'F', 
      'theme' => 'dark', 
      'algorithm' => 'sha1',
      'fecha_ing' => '2024-02-01',
      'roll' => 'padres',
      'cargo' => '',
    ];
  
    self::$_helps = [
      'fecha_nac' => 'dd/mm/aaaa - Ejemplo: 26/07/1976',
      'documento' => 'Advertencia!! sin puntos, sin comas.',
      'is_active' => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'username'  => 'Nombre de Usuario:',
      'roll'  => 'Roles de Usuario:',

      'nombres' => 'Nombre(s):',
      'apellido1' => 'Primer Apellido:',
      'apellido2' => 'Segundo Apellido:',
      'fecha_nac' => 'Fecha Nacimiento:',
      'fecha_ing' => 'Fecha Ingreso', 
      'fecha_ret' => 'Fecha Retiro',
      
      'direccion' => 'Dirección:',
      'cargo' => 'Cargo:',
      'documento' => 'Nro. Documento:',
      'telefono1' => 'Teléfono Principal:',
      'telefono2' => 'Teléfono Secundario:',
      'sexo'  => 'Sexo:',
      
      'profesion' => 'Profesión:',
      'is_carga_acad_ok'  => 'Carga Académicas:',

      'usuario_instit' => 'Usuario App Externa', 
      'clave_instit' => 'Clave App Externa', 
      'theme' => 'Tema Frontend',
      
      'is_active' => 'Está Activo? ',
      'created_at'  => 'Creado el',
      'created_by'  => 'Creado por',
      'updated_at'  => 'Actualizado el',
      'updated_by'  => 'Actualizado por',
    ];
  
  }



}