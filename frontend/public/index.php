<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';
error_reporting(E_ALL ^ E_STRICT);
//ini_set('display_errors', 'Off');

const PRODUCTION = false;
const APP_ROOT_PRIVATE = 'D:/schoolnext/';
const APP_PATH = APP_ROOT_PRIVATE.'frontend/app/';
//define('APP_PATH', dirname(__DIR__).'/app/');
const CORE_PATH = APP_ROOT_PRIVATE.'core1.2/';
//define('CORE_PATH', dirname(dirname(APP_PATH)).'/core1.2/');
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]  LOCAL
$url = $_SERVER['PATH_INFO'] ?? '/';

require APP_PATH . 'libs/bootstrap.php';