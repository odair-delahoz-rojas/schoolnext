<?php
/**
  * Controlador
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SecretariaController extends AppController
{  
  
  protected function before_filter(): void 
  {
    parent::before_filter();
    if ( !str_contains('secretarias', Session::get('roll')) && 
         !str_contains('admin', Session::get('roll')) ) 
    {
      OdaFlash::warning("No tiene permisos de acceso al m&oacute;dulo <b>{$this->controller_name}</b>, fu&eacute; redirigido");
      Redirect::to(Session::get('modulo'));
    }
  }
  
  
  public function index(): void 
  {
    $this->page_action = 'Inicio';
    $this->data = (new Evento)->getEventosDashboard();
  }


  public function showEstudiante(int $estudiante_id) 
  {
    $this->page_action = 'Mostrar Estudiante';
    $this->arrData = [];
    
    try 
    {
      $Estudiante = (new Estudiante())::get($estudiante_id);

      $tabla_datos_estud = Config::get('tablas.datosestud');
      $DatosEstud = (new DatosEstud())::first("SELECT * FROM {$tabla_datos_estud} WHERE estudiante_id=?", [$estudiante_id]);
      
      $tabla_datos_adju = Config::get('tablas.estud_adjuntos');
      $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM {$tabla_datos_adju} WHERE estudiante_id=?", [$estudiante_id]);

      if (!$Adjuntos) 
      {
        $Adjuntos = new EstudianteAdjuntos();
        $Adjuntos->save([
          'estudiante_id' => $estudiante_id,
          'created_by' => $this->user_id,
          'updated_by' => $this->user_id,
          'created_at' => $this->_ahora,
          'updated_at' => $this->_ahora,
        ]);
      }
      
      if (!$DatosEstud) 
      {
        $DatosEstud = new DatosEstud();
        $DatosEstud->save([
          'estudiante_id' => $estudiante_id,
          'created_by' => $this->user_id,
          'updated_by' => $this->user_id,
          'created_at' => $this->_ahora,
          'updated_at' => $this->_ahora,
        ]);
      }      

      $this->arrData['Estudiante'] = $Estudiante;
      $this->arrData['DatosEstud'] = $DatosEstud;
      $this->arrData['Adjuntos']   = $Adjuntos;
    } 

    catch (\Throwable $th) 
    {
      OdaFlash::error($th, true);
    }
    View::select('estudiantes/show_estud/showForm');
  }
  
  
  public function listadoEstudActivos(string $search = ''): void 
  {
    $this->page_action = 'Listado de Estudiantes Activos';
    $this->_default_search = $search;
    $orden = ($this->user_id==1) ? 'a1,a2,n' : 'n,a1,a2';
    $this->data = (new Estudiante(true))->getListSecretaria(orden: $orden, estado: 1);
    $this->arrData['Salones'] = (array)(new Salon)->getList(estado: 1);

    View::select('estudiantes/estud_list_activos');
  }

  
  public function listadoEstudInactivos(): void 
  {
    $this->page_action = 'Listado de Estudiantes Inactivos';
    $this->data = (new Estudiante(true))->getListSecretaria(orden: 'n,a1,a2', estado: 0);
    $this->arrData['Grados'] = (new Grado())::getGradosArray();
    View::select('estudiantes/estud_list_inactivos');
  }
  
  
  public function editEstudiante(int $estudiante_id) 
  {
    $this->page_action = 'Editando Estudiante';
    $this->arrData = [];
    try 
    {      
      $this->arrData['Estudiante'] = (new Estudiante())::get($estudiante_id);
      
      $tabla_datos_estud = Config::get('tablas.datosestud');
      $this->arrData['DatosEstud'] = (new DatosEstud())::first("SELECT * FROM {$tabla_datos_estud} WHERE estudiante_id=?", [$estudiante_id]);
      
      $tabla_datos_adju = Config::get('tablas.estud_adjuntos');
      $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM {$tabla_datos_adju} WHERE estudiante_id=?", [$estudiante_id]);
      
      if (!$Adjuntos) 
      {
        $Adjuntos = new EstudianteAdjuntos();
        $Adjuntos->save([
          'estudiante_id' => $estudiante_id,
          'created_by' => $this->user_id,
          'updated_by' => $this->user_id,
          'created_at' => $this->_ahora,
          'updated_at' => $this->_ahora,
        ]);
      }
      $this->arrData['Adjuntos']   = $Adjuntos;
    }

    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('estudiantes/edit_estud/editForm');
  }
  

  public function actualizarPago(int $estudiante_id) {
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
    Redirect::toAction('listadoEstudActivos');
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
  

  public function activarEstudiante(int $estudiante_id) 
  {
    try 
    {
      $this->page_action = 'Activar Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ( $Estud->setActivar() )
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
    Redirect::toAction('listadoEstudInactivos');
  }
  

  public function retirarEstudiante(
    int $estudiante_id, 
    string $motivo) 
  {
    try 
    {
      $this->page_action = 'Retirar Estudiante';
      $Estud = (new Estudiante)::get($estudiante_id);
      if ($Estud->setRetirar($motivo, $this->user_id)) 
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
    Redirect::toAction('listadoEstudActivos');
  }
  
  
  public function cambiar_salon_estudiante(
    int $estudiante_id, 
    int $nuevo_salon_id, 
    bool $cambiar_en_notas = true) 
  {
    try 
    {
      $this->page_action = 'Cambiar Sal&oacute;n Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ( $Estud->setCambiarSalon($estudiante_id, $nuevo_salon_id, $cambiar_en_notas) ) 
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
    return Redirect::to('/secre-estud-list-activos');
  }

  
  public function historico_notas() 
  {
    $this->page_action = 'Hist&oacute;rico de Notas';
    $this->data = range($this->_annio_matricula-1, $this->_annio_inicial, -1);
    View::select('historico_notas/index');
  }


  public function admisiones(): void 
  {
    $this->page_action = 'M&oacute;dulo de Admisiones';
    $this->data = (new Aspirante)->getListActivos();
    View::select('admisiones/index');
  }

    
  public function admisiones_edit(int $aspirante_id) 
  {
    $this->page_action = 'Admisiones - Editando Aspirante';
    $this->breadcrumb->addCrumb('admisiones', 'secretaria/admisiones');
    $this->data = [0];
    $this->arrData['Aspirante'] = (new Aspirante)->get($aspirante_id);
    $this->arrData['AspirantePsico'] = (new AspirantePsico)::first(
      'SELECT * FROM sweb_aspirantepsico WHERE aspirante_id=?', [$aspirante_id]
    );
    View::select('admisiones/edit/edit');
  }

  
  public function subirAdjuntosMatricula(int $estudiante_id): void 
  {
    $this->page_action = 'Subir Archivos';
    $tabla_datos_adju = Config::get('tablas.estud_adjuntos');
    $this->arrData['Adjuntos'] = (new EstudianteAdjuntos)::first(
      "SELECT * FROM $tabla_datos_adju WHERE estudiante_id=?", [$estudiante_id]
    );
    View::select('estudiantes/edit_estud/upload');
  }
  


}