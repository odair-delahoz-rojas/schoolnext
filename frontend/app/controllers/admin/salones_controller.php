<?php
/**
  * Controlador Salones  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class SalonesController extends ScaffoldController
{

  public function setupCalificarSalon(int $salon_id) 
  {
    $Salon = new Salon();
    $result = $Salon->setupCalificarSalon($salon_id);
    OdaFlash::info("Registros Incluidos: $result");
    return Redirect::to("admin/{$this->controller_name}/index");
  }
  

}