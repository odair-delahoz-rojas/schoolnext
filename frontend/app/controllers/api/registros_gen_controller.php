<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class RegistrosGenController extends RestController
{


  public function get_all() 
  {
    $this->data = (new RegistrosGen)->all();
  }

  
  public function get_singleuuid(string $uuid) 
  {
    /*
    $record = (new RegistrosGen)->getByUUID($uuid);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
    */
  }

  
  public function get_singleid(int $id) 
  {
    try
    {
      $record = (new RegistrosGen)::get($id);
      if (isset($record)) 
      {
        $this->data = $record;
      } 
      else 
      {
        $this->error('El registro buscado no existe', 404);
      }
    }
    catch (\Throwable $th)
    {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  }

  
  public function get_reg_observ_annio_salon(
    int $annio, 
    int $salon_id) 
  {
    try
    {
      $result = (new RegistrosGen())->getByAnnioSalon($annio, $salon_id);
      if ( isset($result) )
      {
        $this->data = $result;
      }
      else 
      {
        $this->error('No hay registros que coincidan con la busqueda', 404);
      }
    }
    catch (\Throwable $th)
    {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  }



}