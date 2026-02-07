<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class EnfermeriaController extends AppController
{


  protected function before_filter(): void {
    parent::before_filter();

    if ( !str_contains('enfermeria', Session::get('roll')) && !str_contains('admin', Session::get('roll')) ) {
      OdaFlash::warning("No tiene permisos de acceso al m&oacute;dulo <b>{$this->controller_name}</b>, fu&eacute; redirigido");
      Redirect::to(Session::get('modulo'));
    }
  }

    
  public function index(): void {
    $this->page_action = 'Inicio';
  }

    
  public function estudiantes(): void {
    $this->page_action = 'Estudiantes Activos';
    $this->data = (new Estudiante)->getListEnfermeria();
  }


    
}