<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class SeguimientosController extends RestController
{


  public function get_all()
  {
    try
    {
      $this->data = (new Seguimientos)->all();          
    }
    catch (\Throwable $th)
    {
      OdaLog::error($th);
      $this->error('Excepcion interna capturada', 404);
    }
  }


  public function get_singleuuid(string $uuid) 
  {
    // try {
    //   $record = (new PlanesApoyo)->getByUUID($uuid);
    //   if (isset($record)) {
    //      $this->data = $record;
    //   } else {
    //      $this->error('El registro buscado no existe', 404);
    //   }
          
    // } catch (\Throwable $th) {
    //   OdaLog::error($th);
    //   $this->error('Excepcion interna capturada', 404);
    // }
  }
  

  public function get_singleid(int $id) 
  {
    // try {
    //   $record = (new PlanesApoyo)::get($id);
    //   if (isset($record)) {
    //     $this->data = $record;
    //   } else {
    //     $this->error('El registro buscado no existe', 404);
    //   }
          
    // } catch (\Throwable $th) {
    //   OdaLog::error($th);
    //   $this->error('Excepcion interna capturada', 404);
    // }
  }
  

  public function get_by_estudiante_periodo(
    int $estudiante_id, 
    int $periodo_id) 
  {
    try 
    {
      $record = (new Seguimientos)->getByEstudiantePeriodo($estudiante_id, $periodo_id);
      if (isset($record))
      {
        $this->data = $record;
      }
      else
      {
        $this->error('No hay registros que coincidan con la busqueda', 404);
      }
    }
    catch (\Throwable $th)
    {
      $this->error('Excepcion interna capturada', 404);
    }
  }


  public function get_by_salon_periodo(
    string $salon_uuid, 
    int $periodo_id) 
  {
    try 
    {
      $record = (new Seguimientos)->getConsolidadoBySalonPeriodo($salon_uuid, $periodo_id);
      if ( isset($record) )
      {
        $this->data = $record;
      } 
      else
      {
        $this->error('No hay registros que coincidan con la busqueda', 404);
      }
    }
    catch (\Throwable $th)
    {
      $this->error('Excepcion interna capturada', 404);
    }
  }



}