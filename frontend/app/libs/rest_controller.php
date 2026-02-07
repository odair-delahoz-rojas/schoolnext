<?php

/**
 * Controlador para manejar peticiones REST
 * 
 * Por defecto cada acción se llama como el método usado por el cliente
 * (GET, POST, PUT, DELETE, OPTIONS, HEADERS, PURGE...)
 * ademas se puede añadir mas acciones colocando delante el nombre del método
 * seguido del nombre de la acción put_cancel, post_reset...
 *
 * @category Kumbia
 * @package Controller
 * @author kumbiaPHP Team
 */
require_once CORE_PATH . 'kumbia/kumbia_rest.php';
abstract class RestController extends KumbiaRest {
    protected $users_valid = array(  /// USUARIOS LIMITADOS
        'admin' => '123456',
        'rafabarros' => '987123654'
    );

    /**
     * Aqui debe ir la autenticación de la API
     */
    final protected function initialize() {
      return true;
        // $user = isset($_SERVER['PHP_AUTH_USER']) ? filter_var($_SERVER['PHP_AUTH_USER']) : null;
        // $pass = isset($_SERVER['PHP_AUTH_PW']) ? filter_var($_SERVER['PHP_AUTH_PW']) : null;
        // if (isset($this->users_valid[$user]) && ($this->users_valid[$user] == $pass)) {
        //   return true;
        // } else {
        //   $this->data = $this->error("Fail authentication", 401);
        //   header('WWW-Authenticate: Basic realm="Private Area"');
        //   return false;
        // }
    }

    final protected function finalize() {
        
    }

}