<?php

class UsuariosController extends ScaffoldController
{
  
  
  public function setPassword(int $id) 
  {
    try
    {
      $usuario = (new Usuario())::get($id);
      $usuario->setPassword();  
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return Redirect::to("admin/$this->controller_name/index");
  }
  
  
  public function retirar(int $id_retirar) 
  {
    try
    {
      $usuario = (new Usuario())::get($id_retirar);
      $usuario->setRetirar();
      return Redirect::to("admin/$this->controller_name/index");
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }




}