<?php
/**
 * Clase Base para la gestion de autenticación
 *
 * @category   Kumbia
 * @package    Auth 
 */
abstract class AuthDolibarr {
    protected $_error = '';
    protected $_login = 'login';
    protected $_pass = 'password';
    protected $_algos = 'md5';
    protected $_key = 'jt2D14KIdRs7LA==';
    protected $_checkSession = TRUE;
    protected static $_defaultAdapter = 'curl';

    public function setLogin($field) { $this->_login = $field; }

    public function setPass($field) { $this->_pass = $field; }

    public function setKey($key) { $this->_key = $key; }

    /**
     * Realiza el proceso de identificacion.
     *
     * @param $login string Valor opcional del nombre de usuario en la bd
     * @param $pass string Valor opcional de la contraseña del usuario en la bd
     * @param $mode string Valor opcional del método de identificación (auth)
     * @return bool
     */
    public function identify($login = '', $pass = '', $mode = '') 
    {      
      if ($this->isValid()) 
      {
        return TRUE;
      } 
      else 
      {
        if (($mode == 'auth') || (isset($_POST['mode']) && $_POST['mode'] === 'auth')) 
        {
          $login = empty($login) ? Input::post($this->_login) : $login;
          $pass  = empty($pass) ? Input::post($this->_pass) : $pass;
          return $this->_check($login, $pass);
        }
        return false;
      }
    }

    abstract protected function _check($username, $password);

    public function logout() 
    {
      Session::set($this->_key, FALSE);
      session_destroy();
    }


    public function isValid() 
    {
      if ($this->_checkSession) { $this->_checkSession(); }
      return Session::has($this->_key) && Session::get($this->_key) === TRUE;
    }

    /**
     * Verificar que no se inicie sesion desde browser distinto con la misma IP
     */
    private function _checkSession() 
    {
      Session::set('USERAGENT', $_SERVER['HTTP_USER_AGENT']);
      Session::set('REMOTEADDR', $_SERVER['REMOTE_ADDR']);
      if ($_SERVER['REMOTE_ADDR'] !== Session::get('REMOTEADDR') ||
        $_SERVER['HTTP_USER_AGENT'] !== Session::get('USERAGENT')) 
      {
        session_destroy();
      }
    }

    /**
     * Indica que no se inicie sesion desde browser distinto con la misma IP
     *
     * @param bool $check
     */
    public function setCheckSession($check) { $this->_checkSession = $check; }

    public function setAlgos($algos) { $this->_algos = $algos; }
    
    public function getError() { return $this->_error; }

    public function setError($error) { $this->_error = $error; }
    
    public static function log($msg) {
      $date = date('Y-m-d', strtotime('now'));
    }

    /**
     * Obtiene el adaptador para Auth
     *
     * @param string $adapter (model, openid, oauth)
     */
    public static function factory($adapter = '') 
    {
      if (!$adapter) { $adapter = self::$_defaultAdapter; }
      require_once __DIR__ ."/adapters/{$adapter}_auth.php";
      $class = $adapter.'auth';
      return new $class;
    }

    /**
     * Cambia el adaptador por defecto
     *
     * @param string $adapter nombre del adaptador por defecto
     */
    public static function setDefault($adapter) { self::$_defaultAdapter = $adapter; }

}