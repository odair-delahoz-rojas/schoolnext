/**
 * Controlador <?=$class?>
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
 * @source   frontend\app\extensions\helpers\oda_table.php
 */

class <?=$class?>Controller extends AppController
{
  // $this->module_name, $this->controller_name, $this->action_name, 
  // $this->parameters, $this->limit_params, $this->scaffold, $this->data

  protected function before_filter() {  // antes de cualquier acción
        // Si es AJAX enviar solo el view
        if (Input::isAjax()) {
            View::template(null);
        }
  }

  //protected function after_filter() { // después de cada acción }

  public function index() {
      //$this->page_title = 'Inicio';
      $this->page_action = 'M&oacute;dulo <?=$class?>';

      $this->data = (new <?=$class?>())->getList();
      //$this->data = <?=$class?>::all();

      //View::select(view: 'carpeta/archivo', template: 'nombre_template');
      //View::template(null);

      //Redirect::to('controlador/action'); a otro controlador
      //Redirect::to(); Al index del Controlador Actual
      //Redirect::toAction('action'); Otra acción del mismo controlador
  }

  /**
    * Descripción del Método.
    * @example echo "como se usa";
    */
  public function nombre_action(){
    OdaLog::info('ojo info',  'mensaje ojo'); // tipos: [warning, error, debug, info]
    OdaFlash::valid('mensaje', $audit: TRUE); // tipos: [valid, error, warning, info]
  }

  
  public function find($id) {
    $this->data = <?=$class?>::get($id);
  }

}
