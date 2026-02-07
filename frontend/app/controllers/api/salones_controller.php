<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class SalonesController extends RestController
{

  public function get_all() 
  {
    $this->data = (new Salon)->getListActivos();
  }


  public function get_by_coordinador(int $user_id) 
  {
    $this->data = (new Salon)->getByCoordinador($user_id); // corregir
  }


  public function get_by_director(int $user_id) 
  {
    $this->data = (new Salon)->getByDirector($user_id); // corregir
  }



}