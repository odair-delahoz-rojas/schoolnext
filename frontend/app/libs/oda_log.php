<?php
/**
 * Librería para el manejo de auditorías y registro de acciones de usuarios
 *
 * @category  
 * @package   Libs
 */

class OdaLog extends Logger {

  protected static $_login; //Usuario que realiza la acción
  protected static $_ip; // Dirección ip donde realiza la acción
  protected static $_route; // Url en donde se produce la acción
  protected static $_logName = 'audit.txt'; // Nombre del archivo
  
  public static function initialize($name=''):void {
    self::$_login = Session::get('username');
    self::$_ip  = Session::get('ip');
    self::$_route = Router::get('route');
    if(!empty($name)) { self::$_logName = date('Y-m-d').'-'.self::$_login .'-'.strtolower($name) .'.txt'; }
  } //END-initialize

  /**
   * Almacena un mensaje en el log
   * @param string $type: WARNING, ERROR, DEBUG, ALERT, CRITICAL, NOTICE, INFO, EMERGENCE, 
   */
  public static function set(string $type='DEBUG', string|array $msg='', string $name_log=''): void {
    self::initialize($type);
    $msg = trim(trim($msg),'.').'.';
    parent::log(
      strtoupper(trim($type)), 
      PHP_EOL.'[ruta:'.self::$_route.'] [login:'.self::$_login.'] [ip:'.self::$_ip.'] '.PHP_EOL.$msg.PHP_EOL, 
      self::$_logName
    );
  }

  public static function error(mixed $msg, string $rastreo = '', string $name_log = ''): void {
    $message = 'UUID: '.$rastreo
    .PHP_EOL.'ARCHIVO: '.$msg->getFile().' - LINEA: '.$msg->getLine()
    .PHP_EOL.'ERROR: '.$msg->getCode().': '.$msg->getMessage().PHP_EOL.str_repeat('..', 10)
    .PHP_EOL.$msg->getTraceAsString()
    .PHP_EOL.str_repeat('==', 10);
    self::set('ERROR', $message, $name_log);
  }

  public static function warning($msg, string $rastreo = '', string $name_log = ''): void {
      self::set('WARNING', $rastreo.PHP_EOL.$msg, $name_log);
  }

  public static function debug($msg, string $rastreo = '', string $name_log = ''): void {
      self::set('DEBUG', $rastreo.PHP_EOL.$msg, $name_log);
  }

  public static function info($msg, string $rastreo = '', string $name_log = ''): void {
      self::set('INFO', $rastreo.PHP_EOL.$msg, $name_log);
  }

}
?>