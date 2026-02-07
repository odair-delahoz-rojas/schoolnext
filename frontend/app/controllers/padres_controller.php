<?php
/**
  * Controlador  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class PadresController extends AppController
{

  protected function before_filter() 
  {
    parent::before_filter();

    if ( !str_contains('padres', Session::get('roll')) && 
         !str_contains('admin', Session::get('roll')) )
    {
      OdaFlash::warning("No tiene permisos de acceso al m&oacute;dulo <b>{$this->controller_name}</b>, fu&eacute; redirigido");
      Redirect::to(Session::get('modulo'));
    }
  }


  public function index(): void 
  {
    $this->page_action = 'Inicio';
    Redirect::toAction('estudiantes');
  }
  
  
  public function contabilidad(): void 
  {
    $this->page_action = 'Informaci&oacute;n Contable';
  }
  

  public function estudiantes(): void 
  {
    try 
    {
      $this->page_action = 'Estudiantes a Cargo';
      $this->arrData['periodo'] = $this->_periodo_actual;
      //$user_id = (1!=$this->user_id) ? $this->user_id : 22482 ; // simular un usuario de padres
      $this->data = (new Estudiante)->getListPadresRetirados($this->user_id);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th, true);
    }
    View::select('estudiantes/index');
  }
  
  
  public function matriculas(): void 
  {
    $this->page_action = 'Matr&iacute;culas A&ntilde;o '.(string)$this->_annio_matricula;

    $this->data = (new Estudiante)->getListPadres($this->user_id);
    foreach ($this->data as $estudiante) 
    {
      $tabla_datos_adju = Config::get('tablas.estud_adjuntos');
      $Adjuntos = (new EstudianteAdjuntos())::first(
        "SELECT * FROM $tabla_datos_adju WHERE estudiante_id=?", [$estudiante->id]
      );
      if (!$Adjuntos) 
      {
        $Adjuntos = new EstudianteAdjuntos;
        $Adjuntos->create([
          'estudiante_id'=>$estudiante->id, 
          'uuid'=>$Adjuntos->xxh3Hash(), 
          'created_at'=> $this->_ahora,
          'updated_at'=> $this->_ahora,
          'created_by'=> $this->user_id,
          'updated_by'=> $this->user_id,
          'estado_archivo1'=> EstadoAdjuntos::ENREVISION->value,
          'estado_archivo2'=> EstadoAdjuntos::ENREVISION->value,
          'estado_archivo3'=> EstadoAdjuntos::ENREVISION->value,
          'estado_archivo4'=> EstadoAdjuntos::ENREVISION->value,
          'estado_archivo5'=> EstadoAdjuntos::ENREVISION->value,
          'estado_archivo6'=> EstadoAdjuntos::ENREVISION->value,
        ]);
      }
      $this->arrData['Adjuntos'][$estudiante->id] = $Adjuntos;
    }
    View::select('matriculas/index');
  }
  
  
  public function subirArchivos($estudiante_id): void 
  {
    $this->page_action = 'Subir Archivos';
    $tabla_datos_adju = Config::get('tablas.estud_adjuntos');

    $this->arrData['Adjuntos'] = (new EstudianteAdjuntos())::first(
      "SELECT * FROM {$tabla_datos_adju} WHERE estudiante_id=?", [$estudiante_id]
    );
    View::select('matriculas/upload');
  }


}
