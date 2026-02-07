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
 * @package  Console
 *
 * @copyright  Copyright (c) 2005 - 2021 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license  https://github.com/KumbiaPHP/KumbiaPHP/blob/master/LICENSE   New BSD License
 */

/**
 * Consola para manejar modelos.
 *
 * @category   Kumbia
 * @package  Console
 */
class ModelConsole
{
  /**
   * Comando de consola para crear un modelo.
   *
   * @param array  $params parametros nombrados de la consola
   * @param string $model  modelo
   * @throw KumbiaException
   */
  public function create($params, $model)
  {
    $file = APP_PATH.'models';// nombre de archivo
    $path = explode('/', trim($model, '/')); // obtiene el path
    $model_name = array_pop($path); // obtiene el nombre de modelo

    if (count($path)) {
      $dir = implode('/', $path);
      $file .= "/$dir";
      if (!is_dir($file) && !FileUtil::mkdir($file)) {
        throw new KumbiaException("No se ha logrado crear el directorio \"$file\"");
      }
    }

    $file_modelo = $file."/$model_name.php";
    // si no existe o se sobreescribe
    if (!is_file($file_modelo) ||
      Console::input('El modelo existe, desea sobrescribirlo? (s/n): ', array('s', 'n')) == 's') {
      $class = Util::camelcase($model_name); // nombre de clase

      // codigo de modelo
      ob_start();
      include __DIR__.'/generators/model.php';
      $code = '<?php'.PHP_EOL.ob_get_clean();

      // genera el archivo
      if (file_put_contents($file_modelo, $code)) {
        echo "-> Creado modelo $model_name en: $file_modelo".PHP_EOL;
      } else {
        throw new KumbiaException("No se ha logrado crear el archivo \"$file_modelo\"");
      }
    }


    $traits_array = ['set_up'];

    foreach ($traits_array as $key => $trait_name) {
      $file_trait = $file."/$model_name"."_trait_$trait_name.php";
      
      if (!is_file($file_trait) ||
      Console::input("El archivo $file_trait existe, desea sobrescribirlo? (s/n): ", array('s', 'n')) == 's') {
        $class = Util::camelcase($model_name); // nombre de clase
        
        // codigo de modelo
        ob_start();
        include __DIR__."/generators/trait_$trait_name.php";
        $code = '<?php'.PHP_EOL.ob_get_clean();
        
        // genera el archivo
        if (file_put_contents($file_trait, $code)) {
          echo "-> Creado traits $model_name"."_trait_$trait_name en: $file_trait".PHP_EOL;
        } else {
          throw new KumbiaException("No se ha logrado crear el archivo \"$file_trait\"");
        }
      }
      
    }
  }

  /**
   * Comando de consola para eliminar un modelo.
   *
   * @param array  $params parametros nombrados de la consola
   * @param string $model  modelo
   * @throw KumbiaException
   */
  public function delete($params, $model)
  {
    // nombre de archivo
    $file = APP_PATH.'models/'.trim($model, '/');

    // si es un directorio
    if (is_dir($file)) {
      $success = FileUtil::rmdir($file);
    } else {
      // entonces es un archivo
      $file = "$file.php";
      $success = unlink($file);
    }

    // mensaje
    if ($success) {
      echo "-> Eliminado: $file".PHP_EOL;
    } else {
      throw new KumbiaException("No se ha logrado eliminar \"$file\"");
    }
  }
}
