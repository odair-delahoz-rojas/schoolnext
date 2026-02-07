<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/asignaturas/all
  */
class AsignaturasController extends RestController
{

  /**
   * Obtiene todos los registros de asignaturas
   * @link ../api/asignaturas/all
   */
  public function get_all() 
  {
    $this->data = (new Asignatura)->getListActivos();
  }


  
}