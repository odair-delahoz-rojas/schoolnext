<?php
/**
  * Controlador
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class MatriculasController extends AppController
{  
  
  public function index() 
  {
    try 
    {
      $this->page_action = 'Listado de Estudiantes Activos';
      $this->data = (new Estudiante)->getListSecretaria(estado:1);
      $this->arrData['Salones'] = (array)(new Salon)->getList(estado:1);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }


}