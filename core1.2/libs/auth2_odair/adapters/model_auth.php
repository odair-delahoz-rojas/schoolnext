<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 * 
 * @copyright  Copyright (c) 2005 - 2020 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    https://github.com/KumbiaPHP/KumbiaPHP/blob/master/LICENSE   New BSD License
 */

/**
 * Clase de Autenticacón por BD
 *
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 */
class ModelAuth extends Auth2Odair
{

    /**
     * Modelo a utilizar para el proceso de autenticacion
     *
     * @var String
     */
    protected $_model = 'users';
    /**
     * Namespace de sesion donde se cargaran los campos del modelo
     *
     * @var string
     */
    protected $_sessionNamespace = 'default';
    /**
     * Campos que se cargan del modelo
     *
     * @var array
     */
    protected $_fields = array('id');
     /**
     *
     *
     * @var string
     */
    protected $_algos ;
     /**
     *
     *
     * @var string
     */
    protected $_key;
    /**
     * Asigna el modelo a utilizar
     *
     * @param string $model nombre de modelo
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * Asigna el namespace de sesion donde se cargaran los campos de modelo
     *
     * @param string $namespace namespace de sesion
     */
    public function setSessionNamespace($namespace)
    {
        $this->_sessionNamespace = $namespace;
    }

    /**
     * Indica que campos del modelo se cargaran en sesion
     *
     * @param array $fields campos a cargar
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;
    }

    /**
     * Check
     *
     * @param $username
     * @param $password
     * @return bool
     */
    protected function _check($username, $password)
    {
        // TODO $_SERVER['HTTP_HOST'] puede ser una variable por si quieren ofrecer autenticacion desde cualquier host indicado
        if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === FALSE) {
            $msg = '('.__METHOD__.') Error Login: INTENTO HACK IP ' . $_SERVER['HTTP_REFERER'];
            self::log($msg); 
            $this->setError('INTENTO HACK IP ' . $_SERVER['HTTP_REFERER']);
            return FALSE;
        }

        // TODO: revisar seguridad
        //$password = hash($this->_algos, $salt.$password); // ORIGINAL
        //$username = addslashes($username);
        //$username = filter_var($username, FILTER_SANITIZE_MAGIC_QUOTES);
        $username = filter_var($username, FILTER_SANITIZE_ADD_SLASHES);
        $Model = new $this->_model;
        $user_salt = $Model->find_first("$this->_login = '$username'");
        if (!$user_salt) {
            $msg = '('.__METHOD__." Error Login: Usuario $username no encontrado!";
            self::log($msg); 
            $this->setError("Usuario $username no encontrado!");
            Session::set($this->_key, FALSE);
            return FALSE;
        }

        if (1 != $user_salt->is_active) {
            $msg = '('.__METHOD__.") Error Login: Usuario $username Inactivo";
            self::log($msg); 
            $this->setError("Usuario $username Inactivo");
            Session::set($this->_key, FALSE);
            return FALSE;
        }

        $password_salt = hash($this->_algos, $user_salt->salt.$password);
        $user=$Model->find_first("$this->_pass = '$password_salt' ");
        if (!$user) {
            $msg = '('.__METHOD__.") Error Login: ($username) password errado! ";
                    "password:$password \nHASH Buscado:$password_salt \nHASH Encontrado:".$Model->password." \nAlgortimo de Busqued:$this->_algos";
            self::log($msg);
            $this->setError("Password errado!");
            Session::set($this->_key, FALSE);
            return FALSE;
        }

        foreach ($this->_fields as $field) { // Carga los atributos indicados en sesion
            Session::set($field, $user->$field, $this->_sessionNamespace);
        }
        Session::set($this->_key, TRUE);
        //self::log('('.__METHOD__.') Login Correcto: '.$username);
        return TRUE;

    } // END function _check

}
