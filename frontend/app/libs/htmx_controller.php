<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador DMZ (Sin seguridad)
 *
 * Todos las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquí definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class HtmxController extends Controller
{
  
  use TraitControllers;

  public string $_instituto_id = '';
  public string $_instituto_nombre = '';
  public int|null $_max_periodos = 0;
  public int|null $_periodo_actual = 0;
  public int|null $_annio_actual = 0;
  public int|null $_annio_inicial = 0;
  public int|null $_annio_matricula = 0;

  protected function before_filter() 
  {
    View::template(null);
  }

  protected function after_filter()
  {
  }

  protected function initialize()
  {
    $this->_instituto_id = INSTITUTION_KEY;
    $this->_instituto_nombre = INSTITUTION_NAME;
    $this->_max_periodos = MAX_PERIODOS;
    $this->_periodo_actual = PERIODO_ACTUAL;
    $this->_annio_actual = ANNIO_ACTUAL;
    $this->_annio_inicial = ANNIO_INICIAL;
    $this->_annio_matricula = ANNIO_MATRICULA;
  }

  protected function finalize()
  {
  }

}