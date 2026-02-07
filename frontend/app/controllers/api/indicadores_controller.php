<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/indicadores/all
  */
class IndicadoresController extends RestController
{

  public function get_all() 
  {
    $this->data = (new Indicador)->getListActivos();
  }

  
  public function get_list(
    int $periodo_id, 
    int $grado_id, 
    int $asignatura_id) 
  {
    $this->data = (new Indicador)->getListIndicadores(
      $periodo_id, $grado_id, $asignatura_id
    );
  }
  

  public function get_singleuuid(string $uuid) 
  {
    $record = (new Indicador)->getByUUID($uuid);
    if (isset($record)) 
    {
      $this->data = $record;
    } 
    else 
    {
      $this->error('El registro buscado no existe', 404);
    }
  }

  
  public function get_singleid(int $id) 
  {
    $record = (new Indicador)::get($id);
    if (isset($record)) 
    {
      $this->data = $record;
    } 
    else 
    {
      $this->error('El registro buscado no existe', 404);
    }
  }



}