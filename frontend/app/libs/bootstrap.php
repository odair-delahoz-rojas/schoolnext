<?php
// Bootstrap de la aplicacion para personalizarlo
// Para cargar cambia en public/index.php el require del bootstrap a app
// Arranca KumbiaPHP
const INSTITUTION_KEY = "development";
const APP_NAME= "SchoolNEXT>>";

const VENDOR_PATH = APP_PATH.'../vendor/' ;
const HELPERS_PATH = APP_PATH.'extensions/helpers/' ;

if ('windsor' === INSTITUTION_KEY) {
  define('ABS_PUBLIC_PATH', '/home/windsor1/schoolnext.windsorschool.edu.co');
} 
else 
{
  if ('santarosa' === INSTITUTION_KEY) {
    define('ABS_PUBLIC_PATH', '/home/u113041793/domains/colegiomixtosantarosa.com/public_html/_schoolnext_santarosa');
  }
  else
  {
    define('ABS_PUBLIC_PATH', 'D:\schoolnext\frontend\public');
  }
}

const LOGO = 'logo_'.INSTITUTION_KEY.'.png';
const LOGO_BRAND = 'logo_brand_'.INSTITUTION_KEY.'.png';

const FILE_UPLOAD_PATH   = PUBLIC_PATH.'files/upload/';
const FILE_DOWNLOAD_PATH = PUBLIC_PATH.'files/download/';

const IMG_UPLOAD_PATH    = PUBLIC_PATH.'img/upload/';
const IMG_DOWNLOAD_PATH  = PUBLIC_PATH.'img/download/';
const IMG_ESTUDIANTES_PATH  = IMG_UPLOAD_PATH.'estudiantes/';

const PREFIJO_TABLAS_DOLIBARR = 'llx_';

require_once CORE_PATH . 'kumbia/bootstrap.php';
