<?php

trait UsuarioTraitCallbacks {

  public function _beforeCreate() {
  parent::_beforeCreate();
  $this->theme = 'dark';
  $this->algorithm = 'sha1';
  $this->sexo = 'F';
  $this->theme = 'dark';
  $this->algorithm = 'sha1';
  $this->created_at = '';
  $this->updated_at = '';
  }


 
}