<?php
/**
 * @see KumbiaView
 */
require_once CORE_PATH . 'kumbia/kumbia_view.php';

/**
 * Esta clase permite extender o modificar la clase ViewBase de Kumbiaphp.
 *
 * @category KumbiaPHP
 * @package View
 */
class View extends KumbiaView
{
    
  /**
   * Método que muestra el contenido de una vista
   */
  public static function content() {                
    OdaFlash::output();        
    parent::content();
  }
  
  /**
   * Método para mostrar los mensajes e impresiones del request
   */
  public static function flash() {        
    return self::partial('snippets/flash');        
  }
  
  /**
   * ODAIR: Método para mostrar los headers de cada vista
   */
  public static function Encab($page_module, $page_action, $breadcrumb='') { 
    return self::partial('snippets/encab', '', array('page_module'=>$page_module, 'page_action'=>$page_action, 'breadcrumb'=>$breadcrumb));
  }

  
}
