<?php

require_once VENDOR_PATH.'autoload.php';
/**
 * Controlador base para la construcción de CRUD para modelos rápidamente
 *
 * @category Kumbia
 * @package Controller
 */

 require_once "enums.php";

abstract class ScaffoldController extends AdminController
{
  public string $scaffold = 'schoolnext'; // en views/_shared/scaffolds/
  public string $model = ''; //Nombre del modelo en CamelCase
 
  public function info($view) 
  {
    View::response($view);
  }
  
  public function exportPdf() 
  {
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->file_title = "Listado de $this->controller_name";
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    $this->file_download = false;
    View::select(view: "export_pdf_$this->controller_name", template: 'pdf/mpdf');
  }

  public function exportCsv() 
  {
    $this->file_name = OdaUtils::getSlug(string: "listado-de-$this->controller_name");
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    View::select(view: null, template: "csv");
  }
  
  public function exportXml() 
  {
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    View::select(view: null, template: "xml");
  }
  
  public function exportXls() 
  {
    $this->Modelo = new $this->nombre_modelo();
    View::select(view: "export_xls_$this->controller_name", template: 'xls');
    $this->file_name = OdaUtils::getSlug(string: "listado-de-$this->controller_name");
    $this->file_title = "listado de $this->controller_name";
    $this->registros = $this->Modelo->getList(estado:1);
    $this->fieldsToShow = $this->Modelo->getFieldsShow('excel');
    $this->header = [];
    // foreach ($this->fieldsToShow as $fields) {
    //   $this->header[$fields->caption] = $fields->data_type;
    // }
    
  }

  public function index() 
  {
    $this->page_action = "Listado $this->controller_name" ;
    $this->data = (new $this->nombre_modelo())->getList();
    $this->fieldsToShow = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__, true);
  }
  
  /**
   * admin/../create
   */
  public function create() 
  {
    try {
      $this->page_action = 'CREAR Registro';
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = new $this->nombre_modelo();
      $redirect = "admin/$this->controller_name/create";

      if (Input::hasPost($this->nombre_post)) {
        if (!$this->Modelo->validar(Input::post($this->nombre_post))) {
          OdaFlash::warning($this->page_action.Session::get('error_validacion'));
          return Redirect::to($redirect);
        }
  
        if ($this->Modelo->create(Input::post($this->nombre_post))) {
          OdaFlash::valid($this->page_action);
          Input::delete();
          return Redirect::to();
        } else {
          OdaFlash::warning("$this->page_action - No Creó el Registro.");
          $this->data = Input::post($this->nombre_post);
          return Redirect::to($redirect);
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }
  }

   
  /**
   * admin/../create_ajax
   */
  public function create_ajax(string $redirect='') 
  {
    $this->page_action = 'CREAR Registro ';
    $redirect = str_replace('.','/', $redirect);

    try {
      View::select(null, null);
      $Registro = new $this->nombre_modelo();

      if (!Input::hasPost($this->nombre_post)) {
        OdaFlash::warning("$this->page_action - Variable Post [$this->nombre_post] vacío.");
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($this->nombre_post))) {
        OdaFlash::warning($this->page_action.Session::get('error_validacion'));
        return Redirect::to($redirect);
      }

      if ($Registro->create(Input::post($this->nombre_post))) {
        OdaFlash::valid("$this->page_action");
        Input::delete();
      } else {
        $this->data = Input::post($this->nombre_post);
        OdaFlash::warning("$this->page_action - No Creó el Registro.");
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }

  }

  /**
   * admin/.../edit/{id}
   */
  public function edit(int $id) 
  {
    $this->page_action = 'Editar Registro';
    try {
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::get($id);
      $redirect = "admin/$this->controller_name/edit/$id";

      if (Input::hasPost($this->nombre_post)) {
        if ($this->Modelo->validar(Input::post($this->nombre_post))) {
          if ($this->Modelo->update(Input::post($this->nombre_post))) {
            OdaFlash::valid("$this->page_action $id");
            return Redirect::to();
          }
          OdaFlash::warning("$this->page_action. Guardar.");
          return Redirect::to($redirect);
        } else {
          OdaFlash::warning($this->page_action.Session::get('error_validacion'));
          return Redirect::to($redirect);
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to();
    }
  }



  /**
   * admin/.../editUuid/{$uuid}
   */
  public function editUuid(string $uuid) 
  {
    $this->page_action = 'Editar Registro';
    try {
      $this->Modelo = (new $this->nombre_modelo())::getByUUID($uuid);
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);

      if (Input::hasPost($this->nombre_post)) {
        if ( $this->Modelo->update(Input::post($this->nombre_post)) ) {
          OdaFlash::valid("$this->page_action: $uuid");
          return Redirect::to();
        }
        OdaFlash::warning($this->page_action);
        return Redirect::to();
      }
      View::select('edit');

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  /**
   * admin/../edit_ajax
   */
  public function edit_ajax(int $id, string $redirect='') 
  {
    $this->page_action = 'EDITAR Registro ';
    $redirect = str_replace('.','/', $redirect);

    try {
      View::select(null, null);
      $Registro = (new $this->nombre_modelo())::get($id);

      if (!Input::hasPost($this->nombre_post)) {
        OdaFlash::warning("$this->page_action - No coincide post [$this->nombre_post]");
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($this->nombre_post))) {
        OdaFlash::warning("$this->page_action. Error de Validación ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }

      if ( $Registro->update(Input::post($this->nombre_post)) ) {
        OdaFlash::valid($this->page_action);
      } else {
        $this->data = Input::post($this->nombre_post);
        OdaFlash::warning("$this->page_action - No actualizó el Registro.");
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }

  }//END-edit_ajax


  /**
   * admin/.../del/{id}
   */
  public function del(int $id, string $redirect='') 
  {
    $this->page_action = 'Eliminar Registro';
    $redirect = str_replace('.','/', $redirect);

    try {
      $Registro = new $this->nombre_modelo();
      if ( $Registro::delete($id) ) {
        OdaFlash::valid("$this->page_action: $id");
      } else {
        OdaFlash::warning("$this->page_action: $id");
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }
  }


  /**
   * admin/.../delUuid/{uuid}/{redirect}
   */
  public function delUuid(string $uuid, string $redirect='') 
  {
    $this->page_action = 'Eliminar Registro';
    $redirect = str_replace('.','/', $redirect);

    try {
      $Registro = new $this->nombre_modelo();
      if ( $Registro::deleteByUUID($uuid)) {
        OdaFlash::valid("$this->page_action: $uuid");
      } else {
        OdaFlash::warning("$this->page_action: $uuid");
        return;
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to("$redirect");
    }
  }

  /**
   * admin/.../ver/{id}
   */
  public function ver(int $id) 
  {
    $this->data = (new $this->nombre_modelo())::get($id);
  }



}