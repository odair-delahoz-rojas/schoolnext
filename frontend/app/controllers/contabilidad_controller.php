<?php
/**
  * Controlador
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

  
class ContabilidadController extends AppController
{
    
  protected function before_filter() 
  {
    parent::before_filter();

    if ( !str_contains('contables', Session::get('roll')) && !str_contains('admin', Session::get('roll'))) {
      OdaFlash::warning("No tiene permisos de acceso al m&oacute;dulo <b>{$this->controller_name}</b>, fu&eacute; redirigido");
      Redirect::to(Session::get('modulo'));
    }
  }


  public function index(): void 
  {
    $this->page_action = 'Inicio';
  }
    

  public function listadoEstudActivos(): void {
    try 
    {
      $this->page_action = 'Listado de Estudiantes Activos';
      $this->data = (new Estudiante)->getListContabilidad();
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select(view: 'estudiantes/estudiantes_list');
  }

    
  public function actualizarPago(int $estudiante_id): void { // Actualizar Mes Pagado de un Estudiante
    try 
    {
      $this->page_action = 'Actualizar Mes Pagado Estudiante';
      $Estud = (new Estudiante)::get($estudiante_id);
      if ($Estud->setActualizarPago())
      {
        OdaFlash::valid("$this->page_action: $Estud");
      }
      else 
      {
        OdaFlash::warning("$this->page_action: $Estud");
      }
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    Redirect::toAction(action: 'listadoEstudActivos');
  }
  

  public function setMesPago(
    int $estudiante_id, 
    int $mes) 
  {
    try 
    {
      $this->page_action = 'Actualizar Mes Pagado Estudiante';
      $Estud = (new Estudiante)::get($estudiante_id);
      if ( $Estud->setMesPago($mes) )
      {
        OdaFlash::valid("$this->page_action: $Estud");
      } 
      else 
      {
        OdaFlash::warning("$this->page_action: $Estud");
      }
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    Redirect::toAction(action: 'listadoEstudActivos');
  }

}