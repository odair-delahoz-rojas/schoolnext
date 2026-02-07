<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class IndicadoresController extends ScaffoldController
{

  protected function before_filter() 
  {
    $this->nombre_modelo = 'indicador';
  }
 

  public function filtrar(
    int $periodo_id,
    int $grado_id,
    int $asignatura_id,
  )
  {
    try
    {
      $this->page_action = "Listado $this->controller_name Filtradas" ;
      $this->fieldsToShow = (new $this->nombre_modelo())->getFieldsShow('filtrar');
      $this->fieldsToShowLabels = (new $this->nombre_modelo())->getFieldsShow('filtrar', true);
      $this->nombre_modelo = OdaUtils::singularize($this->controller_name);
      $Indicador = new Indicador();
      $this->data = $Indicador->getByPeriodoGradoAsignatura($periodo_id, $grado_id, $asignatura_id);
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }




}