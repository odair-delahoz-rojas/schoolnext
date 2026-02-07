<?php
trait UsuarioTraitSetters {


  public function setPassword(string $seed=null): bool
  {
    try 
    {
      $salt = md5(rand(100000, 999999).$this->username);
      if ( is_null($seed) )
      {
        $seed = (trim(strtolower($this->documento)) == trim(strtolower($this->username))) ? $this->documento: substr($this->documento, -4);
      }
      return $this->update(
        [
          'salt' => $salt,
          'password' => hash('sha1', $salt.$seed),
        ]
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return false;
    }
  }



  public function setPasswordDolibarr(string $seed=null): bool
  {
    try 
    {
      $salt = md5(rand(100000, 999999).$this->username);
      if ( is_null($seed) )
      {
        $seed = (trim(strtolower($this->documento)) == trim(strtolower($this->username))) ? $this->documento: substr($this->documento, -4);
      }
      return $this->update(
        [
          'salt' => $salt,
          'password' => hash('sha1', $salt.$seed),
        ]
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return false;
    }
  }


  public function setRetirar(): bool 
  {    
    return $this->update(
      [
        'fecha_ret' => date('Y-m-d', time()),
        'is_carga_acad_ok' => 0,
        'is_active' => 0,
      ]
    );
  }


  
  
}