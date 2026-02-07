<?php
/**
 * KumbiaPHP web & app Framework
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 */

/**
 * Clase de Autenticacón a API DOLIBARR através de cURL
 *
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 */
class CurlAuth extends AuthDolibarr
{
  protected $_model = 'users';
  protected $_sessionNamespace = 'default';
  protected $_fields = ['id'];
  protected $_algos ;
  protected $_key;
  public function setModel($model) { $this->_model = $model; }
  public function setSessionNamespace($namespace) { $this->_sessionNamespace = $namespace; }
  public function setFields($fields) { $this->_fields = $fields; }

  protected function _check($username, $password): bool
  {
    $apiUrl = Config::get('dolibarr.'.INSTITUTION_KEY.'.api_url');
    $apiKey = Config::get('dolibarr.'.INSTITUTION_KEY.'.api_key');
    $HTTPHeader = ['DOLAPIKEY: '.$apiKey];

    /// fase 1. Autenticación
    $Curl1 = curl_init();
    $endPointLogin = $apiUrl.'/login?login='.$username.'&password='.$password;    
    curl_setopt($Curl1, CURLOPT_URL, $endPointLogin);
    curl_setopt($Curl1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($Curl1, CURLOPT_HTTPHEADER, $HTTPHeader);
    $result_json = curl_exec($Curl1);
    if (curl_errno($Curl1))
    {
      $err_message = "{$username} Error en la solicitud cURL: [login] " . curl_error($Curl1);
      $this->setError($err_message.PHP_EOL.$endPointLogin);
      Session::set($this->_key, FALSE);
      return false;
    }
    $dataLogin = json_decode($result_json, true);
    if (isset($dataLogin['error']))
    {
      // USUARIO NO AUTENTICADO
     $err_message = "{$username} Error del API: [login] " . $dataLogin['error']['message'].'. No autenticado';
      $this->setError($err_message);
      Session::set($this->_key, FALSE);
      return false;
    }

    // USUARIO AUTENTICADO CORRECTAMENTE
    $token = $dataLogin['success']['token'];
    curl_close($Curl1);

    /// fase 2. Obtener INFORMACIÓN DEL USUARIO
    $Curl2 = curl_init();
    $endPoint = $apiUrl."/users/login/{$username}?includepermissions=1";
    $HTTPHeader = ['DOLAPIKEY: '.$token];
    curl_setopt($Curl2, CURLOPT_URL, $endPoint);
    curl_setopt($Curl2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($Curl2, CURLOPT_HTTPHEADER, $HTTPHeader);
    $result_json = curl_exec($Curl2);
    $dataUserInfo = json_decode($result_json, true);
    if (curl_errno($Curl2))
    {
      $err_message = "{$username} Error en la solicitud cURL: [UserInfo] " . curl_error($Curl2);
      $this->setError($err_message.PHP_EOL.$endPoint);
      Session::set($this->_key, FALSE);
      return false;
    }
    if (isset($dataUserInfo['error']))
    {
      $err_message = "{$username} Error del API: [UserInfo] " . $dataUserInfo['error']['message'];
      $this->setError($err_message);
      Session::set($this->_key, FALSE);
      return false;
    }
    curl_close($Curl2);

    /// fase 3. Establecer GRUPOS
    $roll = '';
    if ( 'admin' == strtolower($dataUserInfo['login']) )
    {
      $roll = 'admin';
    }
    else 
    {      
      $Usuarios = new UsuarioDolibarr();
      $dataUserGroups = $Usuarios->getUserGroups((int)$dataUserInfo['id']);
      $losGrupos = [];
      foreach ($dataUserGroups as $UserGroup) 
      {
        $losGrupos[]=strtolower(trim($UserGroup->nom));
      }
      $gruposPrioritarios = ["docentes", "padres", "secretarias", "contabilidad", "coordinadores", "psicologos"];
      $roll = '';
      foreach ($gruposPrioritarios as $grupo) 
      {
        if (in_array($grupo, $losGrupos))
        {
          $roll = $grupo;
          break;
        }
      }
      if ('sicologa'==strtolower($dataUserInfo['login']))
      {
        $roll = 'sicologos';
      }
    }

    Session::set('id', $dataUserInfo['id'], $this->_sessionNamespace);
    Session::set('token', $token, $this->_sessionNamespace);
    Session::set('username', (string)$username, $this->_sessionNamespace);
    Session::set('password', (string)$password, $this->_sessionNamespace);
    Session::set('nombres', (string)$dataUserInfo['firstname'], $this->_sessionNamespace);
    Session::set('apellido1', (string)$dataUserInfo['lastname'], $this->_sessionNamespace);
    Session::set('apellido2', '', $this->_sessionNamespace);
    Session::set('roll', $roll, $this->_sessionNamespace);
    Session::set('documento', (string)$dataUserInfo['array_options']['options_identificacion'], $this->_sessionNamespace);
    Session::set('usuario_instit', '', $this->_sessionNamespace);
    Session::set('clave_instit', '', $this->_sessionNamespace);
    Session::set('theme', 'dark', $this->_sessionNamespace);
    Session::set($this->_key, TRUE);
    return TRUE;    
  }


}