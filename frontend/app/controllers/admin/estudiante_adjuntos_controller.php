<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudianteAdjuntosController extends ScaffoldController
{

  public function edit_ajax(int $id, string $redirect='') 
  {
    $this->page_action = 'EDITAR Archivos Adjuntos de Matriculas';
    try
    {
      $redirect = str_replace('.','/', $redirect);      
      //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      View::select(null, null);
      $post_name = 'estudianteadjuntos';      
      if (!Input::hasPost($post_name))
      {
        OdaFlash::warning("$this->page_action - No coincide post [$post_name]");
        return Redirect::to($redirect);
      }      
      $Registro = (new EstudianteAdjuntos)::get($id);
      if (!$Registro->validar(Input::post($post_name)))
      {
        OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }      
      if ($number_files = $Registro->uploadAdjuntos($post_name)>0)
      {
        OdaFlash::info("Total archivos subidos: $number_files");
      }
      if ($Registro->save(Input::post($post_name)))
      {
        OdaFlash::valid($this->page_action);
        Input::delete();
      }
      else
      {
        $this->data = Input::post($post_name);
        OdaFlash::warning("$this->page_action - No actualizó el Registro.");
      }
      return Redirect::to($redirect);
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }
  }
  


}