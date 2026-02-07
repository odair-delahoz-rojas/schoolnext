<?php
/**
 * Breadcrumb
 *
 * @package kumbiaphp
 * @author [odairdelahoz] - Odair De La Hoz <odairdelahoz@gmail.com>
 * @copyright 2023
 * @version 1.00
 */
class OdaBreadcrumb
{
    /**
     * Arreglo que contiene el breadcrumb
     */
    private $_path = [];

    /**
     *   Matriz con la informacion necesaria para
     * configurar la salida del breadcrumb.
     *
     *   separator        => (string)Caracter que separa cada crumb.
     *   class_ul         => (string)Nombre de la clase para ul en la lista.
     *   class_separator  => (string)Nombre de la clase para li del separador.
     *   camel_case       => (bool)Activa CamelCase(ucwords) en los titulos.
     *   upper_case       => (bool)Transforma a mayusculas(strtoupper) los titulos.
     *   lower_case       => (bool)Transforma a minusculas(strtolower) los titulos.
     *   cut              => (bool)Cortar los titulos.
     *   cut_len_max      => (int)Longitud maxima del titulo.
     *
     * @var array
     * @access private
     */
    private $attrs = [
        'separator' => '&nbsp;&raquo;&nbsp;',
        'class_ul' => NULL,
        'class_separator' => NULL,
        'camel_case' => TRUE,
        'upper_case' => FALSE,
        'lower_case' => FALSE,
        'cut' => FALSE,
        'cut_len_max' => 10
    ];
    
    public function __construct() {
      array_push($this->_path, array('title' => 'Inicio', 'url' => ''));
    }

    public function __toString(): string { 
      return $this->display(); 
    }

    /**
     * Breadcrumb::__set()
     * 
     * Metodo magico que modifica la configuracion
     * de salida para el breadcrumb.
     */
    public function __set($key, $value) {
      if(!array_key_exists($key, $this->attrs)) { return FALSE; }
      $this->attrs[$key] = $value;
    }

    /**
     * Breadcrumb::__get()
     * 
     * Metodo magico para obtener el valor del parametro,
     * de la configuracion de salida, pasado.
     */
    public function __get($key) {
      if(!array_key_exists($key, $this->attrs)) { return FALSE; }
      return $this->attrs[$key];
    }

    /**
     * Breadcrumb::addCrumb()
     * Agrega una url al final del arreglo.
     */
    public function addCrumb(string $title, string $url) {
      array_push($this->_path, array('title' => $title, 'url' => $url));
      return $this;
    } //END-addCrumb

    /**
     * Breadcrumb::executeFormat()
     * Formato al title.
     * Da formato a los titulos de crumb, segun la configuracion en $this->attrs.
     */
    private function executeFormat()
    {
        foreach($this->_path as $key => $crumb)
        {
            $title = &$this->_path[$key]['title'];
            $this->_path[$key]['title'] = $this->attrs['camel_case'] ?
              ucwords(strtolower($title)) :
                ($this->attrs['upper_case'] ?
                  strtoupper($title) :
                    ($this->attrs['lower_case'] ?
                      strtolower($title) : $title));

            if($this->attrs['cut'] && strlen($title) > $this->attrs['cut_len_max'] && strlen($title) > $this->attrs['cut_len_max'])
            {
                $this->_path[$key]['title'] = substr($title, 0, $this->attrs['cut_len_max']) . '...';
            }
        }
    }



    /**
     * Breadcrumb::display()
     * Genera el breadcrumb
     */
    public function display()
    {
      $html = [];
      $this->executeFormat();
      foreach ($this->_path as $key => $crumb) {
        $html[] = Html::link($crumb['url'], $crumb['title'], "class=\"{$this->attrs['class_separator']}\"").$this->attrs['separator'];
      }
      
      return "<ul class='{$this->attrs['class_ul']}'>" . implode('', $html) . '</ul>';
    } //END-display


    /**
     * Breadcrumb::getArray()
     * Regresa la matriz del path
     */
    public function getArray(): array {
        return $this->_path;
    }

    
} //END-Class