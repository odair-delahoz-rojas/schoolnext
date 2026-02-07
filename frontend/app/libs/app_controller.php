<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todos las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquí definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class AppController extends Controller
{
  public int  $_data_count = 0;
  public array  $arrData = [];
  public object $Modelo;
  public array  $fieldsToShow = [];
  public array  $fieldsToShowLabels = [];
  public array  $fieldsToHidden = [];
  public string $nombre_post = '';
  public string $nombre_modelo = '';
  
  public string $_default_search = '';

	// ACL (Access Control List) permisos
	public $_acl; //variable objeto ACL
	public $_userRol = ""; //variable con el rol del usuario autenticado en la aplicación

  
  // PARA LA GENERACIÓN DE ARCHIVOS
  public string|null $file_tipo = null;
  public string|null $file_name = null;
  public string|null $file_title = null;
  public bool $file_download = true;
  public string $file_orientation = 'L';
  
  public string $page_action = '';
  public string $page_module = '';
  public string $page_title  = 'Título Página';
  public $breadcrumb;

  public string $theme = 'dark';
  public string $themei = 'd';
  
  public int $user_id = 0;
  public string|null $user_name = '';
  public string|null $user_nombre_completo = '';

  public string $_instituto_id = '';
  public string $_instituto_nombre = '';
  
  public int|null $_max_periodos = 0;
  public int|null $_periodo_actual = 0;
  public int|null $_annio_actual = 0;
  public int|null $_annio_inicial = 0;
  
  public int|null $_annio_matricula = 0;
  public bool|null $_show_matricula = false;

  public string $_ahora = '';
  public $_now = null;

  
  protected function before_filter()
  {
    if (Input::isAjax()) {
      View::template(null);
    }
  }


  final protected function initialize() 
  {
    try 
    {
      if (!Session::get('usuario_logged'))
      {
        Redirect::to("auth/login");
        return false;
      }
      //if(Auth::is_valid()) $this->userRol = Auth::get("rol");
      $this->data = [0];
      $this->breadcrumb = new OdaBreadcrumb();
      $this->breadcrumb->__set('cut', true);
      
      $this->user_id = Session::get('id');
      $this->user_name = Session::get('username');
      $this->user_nombre_completo = trim(Session::get('nombres').' '.Session::get('apellido1').' '.Session::get('apellido2'));

      $this->_max_periodos = MAX_PERIODOS;
      $this->_periodo_actual = PERIODO_ACTUAL;
      $this->_annio_actual = ANNIO_ACTUAL;
      $this->_annio_inicial = ANNIO_INICIAL;

      $this->_instituto_id = INSTITUTION_KEY;
      $this->_instituto_nombre = INSTITUTION_NAME;
      
      $this->_annio_matricula = ANNIO_MATRICULA;
      $this->_show_matricula = SHOW_MATRICULA;

      
      $this->theme = (Session::get('theme')) ? Session::get('theme') : 'dark' ;
      $this->themei = substr($this->theme,0,1);
      
      $this->nombre_post   = strtolower(OdaUtils::pluralize($this->controller_name));
      $this->nombre_modelo = ucfirst(OdaUtils::singularize($this->controller_name));
      
      $this->_ahora = date('Y-m-d H:i:s', time());
      $this->_now = new DateTime("now", new DateTimeZone("America/Bogota"));
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }
  
  
final protected function finalize()
  {
    try {
      $this->page_action ??= $this->action_name;
      $this->page_title  = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .Config::get('institutions.'.INSTITUTION_KEY.'.nombre');
      if ($this->action_name!=='index')
      {
        $this->_data_count = 0;
        if (is_countable($this->data))
        {
          if (0 == count($this->data))
          {
            OdaFlash::info('No hay registros para mostrar.'); 
          }
        }        
      }
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
  

  public function index() {
    try {
      $this->page_action = "Listado $this->controller_name" ;
      $this->data = (new $this->nombre_modelo())->getList();
      $this->fieldsToShow = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__);
      $this->fieldsToShowLabels = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__, true);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-index
  
  public function create() {
    try {
      $this->page_action = 'CREAR Registro';
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = new $this->nombre_modelo();

      if (Input::hasPost($this->nombre_post)) {
      if ((new $this->nombre_modelo())->validar(Input::post($this->nombre_post))) {
        if ( (new $this->nombre_modelo())->create(Input::post($this->nombre_post))) {
        OdaFlash::valid("$this->page_action");
        Input::delete();
        return Redirect::to();
        }
        OdaFlash::warning("$this->page_action Guardar");
        return Redirect::to("admin/$this->controller_name/create");
      } else {
        OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
        return Redirect::to("admin/$this->controller_name/create");
      }
      }
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-create

  
  public function edit(int $id) {
    try {
      $this->page_action = 'Editar Registro';
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::get($id);

      if (Input::hasPost($this->nombre_post)) {
        if ((new $this->nombre_modelo())->validar(Input::post($this->nombre_post))) {
        if ((new $this->nombre_modelo())->update(Input::post($this->nombre_post))) { // procede a guardar
          OdaFlash::valid("$this->page_action $id");
          return Redirect::to(); // regresa al listado
        }
        OdaFlash::warning("$this->page_action Guardar");
        return Redirect::to("admin/$this->controller_name/edit/$id");
        } else {
        OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
        return Redirect::to("admin/$this->controller_name/edit/$id");
        }
      }
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-edit


  public function editUuid(string $uuid) {
    try {
      $this->page_action = 'Editar Registro';
      if (Input::hasPost($this->nombre_post)) { // valida si hay datos a guardar
        if ( (new $this->nombre_modelo())->update(Input::post($this->nombre_post)) ) { // ´procede a guardar
        OdaFlash::valid("$this->page_action: $uuid");
        return Redirect::to();
        }
        OdaFlash::warning($this->page_action);
        return; // Redirect::to();
      }
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::getByUUID($uuid);
      View::select('edit');
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-editUuid


  public function del(int $id, string $redirect='') {
    try {
      $this->page_action = 'Eliminar Registro';
      if ( (new $this->nombre_modelo())::delete($id)) {
        OdaFlash::valid("$this->page_action: $id");
      } else {
        OdaFlash::warning("$this->page_action: $id");
        return;
      }
      $redirect = str_replace('.','/', $redirect);
      return Redirect::to("$redirect");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-del


  public function delUuid(string $uuid, string $redirect='') {
    try {
      $this->page_action = 'Eliminar Registro';
      if ( (new $this->nombre_modelo())::deleteByUUID($uuid)) {
        OdaFlash::valid("$this->page_action: $uuid");
      } else {
        OdaFlash::warning("$this->page_action: $uuid");
        return;
      }
      $redirect = str_replace('.','/', $redirect);
      return Redirect::to("$redirect");
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-delUuid

  
  public function ver(int $id) {
    $this->data = (new $this->nombre_modelo())::get($id);
  }//END-ver


} //END-CLASS
