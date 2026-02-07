<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';
error_reporting(E_ALL);

const PRODUCTION = true;
const APP_ROOT_PRIVATE = '/home/u113041793/domains/colegiomixtosantarosa.com/_schoolnext_santarosa_private/';
const APP_PATH = APP_ROOT_PRIVATE.'frontend/app/';
const CORE_PATH = APP_ROOT_PRIVATE.'core1.2/';
const PUBLIC_PATH = 'https://schoolnext.colegiomixtosantarosa.com/';

$url = $_SERVER['PATH_INFO'] ?? '/';

require APP_PATH . 'libs/bootstrap.php';
