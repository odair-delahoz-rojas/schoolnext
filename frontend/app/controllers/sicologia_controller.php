<?php
/**
  * Controlador  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SicologiaController extends AppController
{
    
  protected function before_filter()
  {
    parent::before_filter();

    if ( !str_contains('sicologos', Session::get('roll')) && 
         !str_contains('admin', Session::get('roll')) ) 
    {
      OdaFlash::warning("No tiene permisos de acceso al m&oacute;dulo <b>{$this->controller_name}</b>, fu&eacute; redirigido");
      Redirect::to(Session::get('modulo'));
    }
  }


  public function index() 
  {
    $this->page_action = 'Inicio';
    $this->data = (new Evento)->getEventosDashboard();
  }
    
  public function estudiantes() 
  {
    try 
    {
      $this->page_action = 'Estudiantes Activos';
      $this->data = (new Estudiante)->getListSicologia();
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('estudiantes/index');
  }    


  public function admisiones() 
  {
    try 
    {
        $this->page_action = 'M&oacute;dulo de Admisiones';
        $this->data = (new Aspirante)->getListActivos();
    } 
    catch (\Throwable $th) 
    {
        OdaFlash::error($th);
    }
    View::select('admisiones/index');
  }

    
  public function admisiones_edit(int $aspirante_id) 
  {
    try 
    {
      $this->page_action = 'Admisiones - Editando Aspirante';
      $this->data = [0];
      $this->arrData['Aspirante'] = (new Aspirante)->get($aspirante_id);
      $this->arrData['AspirantePsico'] = (new AspirantePsico)::first(
        'SELECT * FROM sweb_aspirantepsico WHERE aspirante_id=?', [$aspirante_id]
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('admisiones/edit/edit');
  }
  


}