<?php

trait TraitSubirAdjuntos {

  protected static $_ruta_destino = '/files/upload';
  protected static string $_upload_max_filesize = '1M';
  protected static string $_upload_errors = '';

  public function uploadAdjuntos(string $frm_name): int {
    $uploads_dir = ABS_PUBLIC_PATH.self::$_ruta_destino;
    
    $this->setUploadMaxFilesize();

    $arrArchMov = [];
    foreach ($_FILES[$frm_name]["error"] as $key => $error) {
      if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES[$frm_name]["tmp_name"][$key];
        $pathinfo = pathinfo($_FILES[$frm_name]["name"][$key]);
        $base = $pathinfo["filename"];
        $base = preg_replace("/[^\w-]/", "_", $base);
        $new_filename = md5(time()).rand(1,100) . "." . $pathinfo["extension"];
        if (move_uploaded_file($tmp_name, "$uploads_dir/$new_filename")) {
          $arrArchMov[$key] = $new_filename;
        }
      } else {
        self::$_upload_errors .= "File Error : $key -> $error " . $this->getUploadMaxFilesize();
      }
    }

    foreach ($arrArchMov as $key => $value) {
      $_POST[$frm_name][$key]=$value;
    }
    
    return count($arrArchMov);
  }
  
  public function setRutaDestino(string $ruta_destino): void 
  {
    self::$_ruta_destino = $ruta_destino;
  }
  

  public function setUploadMaxFilesize(): void 
  {
    self::$_upload_max_filesize = ini_get('upload_max_filesize');
  }
  

  public function getUploadMaxFilesize(): string 
  {
    return self::$_upload_max_filesize;
  }


  public function getUploadErrors() 
  {
    return self::$_upload_errors;
  }



}
