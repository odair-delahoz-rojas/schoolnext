<?php
/**
  * Controlador Admisiones
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class AdmisionesController extends DmzController
{
  protected function before_filter()
  {
    parent::before_filter();
    $this->theme = 'light';
    $this->themei = 'l';
    View::template('admisiones');
  }


  public function index() 
  {
    try
    {
      $this->page_action = 'Inicio';
      $DoliK = new DoliConst();
      $this->data['institucion_nombre'] = $this->_instituto_nombre;
      $this->data['institucion_email']  = INSTITUTION_MAIL;
      $this->data['annio_matricula']    = ANNIO_MATRICULA;
      $this->data['tipo_form_admisiones'] = INSTITUTION_FRM_ADMISIONES;
      //View::select('index2', 'layout_adminlte4_blank');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th, true);
    }
  }

  public function index2() 
  {
    try
    {
      $this->page_action = ' ';
      $this->data['institucion_nombre'] = $this->_instituto_nombre;
      $this->data['institucion_email']  = INSTITUTION_MAIL;
      $this->data['annio_matricula']    = ANNIO_MATRICULA;
      $this->data['tipo_form_admisiones'] = INSTITUTION_FRM_ADMISIONES;
      View::select('index2', 'layout_adminlte4_blank');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th, true);
    }
  }


  public function success($id) 
  {
    try
    {
      $this->page_action = 'Success';
      $this->arrData['institucion_nombre'] = $this->_instituto_nombre;
      
      $this->data = (new Aspirante())::get($id);
      $GradosActivos = (new Grado())->getListActivos();
      $this->arrData['Grados'] = null;
      
      foreach ($GradosActivos as $key => $grado)
      {
        $this->arrData['Grados'][$grado->id] = $grado->nombre;
      }
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th, true);
    }
  }




}