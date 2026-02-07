<?php
/**
  * Controlador RegistrosGen  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class RegistrosGenController extends ScaffoldController
{

  public function create_ajax(string $redirect='') {
    $this->page_action = 'CREAR Registro de Observaciones Generales';
    $redirect = 'docentes/registros_observaciones';
    
    try {

      View::select(null, null);
      $post_name = 'registrosgens';
      $Registro = new RegistrosGen();
      
      if (!Input::hasPost($post_name)) {
        OdaFlash::warning("$this->page_action - No coincide post [$post_name]");
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($post_name))) {
        OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }

      if ($Registro->createWithPhoto(Input::post($post_name))) {
        OdaFlash::valid($this->page_action);
        Input::delete();
      } else {
        $this->data = Input::post($post_name);
        OdaFlash::warning("$this->page_action - No Cre&oacute; el Registro.");
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }

  } //END-create_ajax()

  
  /**
   * Actualiza un Registro con AJAX
   */
  public function edit_ajax(int $id, string $redirect='') {
    $this->page_action = 'EDITAR Registro de Observaciones Generales';
    $redirect = 'docentes/registros_observaciones';

    try {
      View::select(null, null);
      $post_name = 'registrosgens';
      $Registro = (new RegistrosGen)::get($id);

      if (!Input::hasPost($post_name)) {
        OdaFlash::warning("$this->page_action - No coincide post [$post_name]");
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($post_name))) {
        OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }
      
      if ($Registro->saveWithPhoto(Input::post($post_name))) {
        OdaFlash::valid($this->page_action);
        Input::delete();
      } else {
        $this->data = Input::post($post_name);
        OdaFlash::warning("$this->page_action - No actualizó el Registro.");
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }

  } //END-edit_ajax()
  
  
  
} // END CLASS
