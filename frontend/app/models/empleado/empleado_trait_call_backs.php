<?php

trait EmpleadoTraitCallBacks {

  public function _beforeCreate(): void 
  {
    parent::_beforeCreate();
    $this->algortithm = 'sha1';

    $salt = md5(rand(100000, 999999).$this->username);
    $this->salt = $salt;
     
    $pass = substr($this->documento, -4);
    $password_salt = hash($this->algortithm, $this->salt.$pass);
    $this->password = $password_salt;
  }
 

}