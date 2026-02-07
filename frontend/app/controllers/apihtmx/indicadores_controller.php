<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class IndicadoresController extends HtmxController
{

  public function getListByPeriodoGradoAsignatura(int $periodo_id, int $grado_id, int $asignatura_id) 
  {
    View::select('list');
    $rows = (new Indicador)->getByPeriodoGradoAsignatura($periodo_id, $grado_id, $asignatura_id);
    
    $this->data['headers'] = ['ID', 'Código', 'Concepto', 'Valorativo'];
    $this->arrData['Periodo'] = $periodo_id;
    $this->arrData['Grado'] = (new Grado)->get($grado_id)->nombre;
    $this->arrData['Asignatura'] = (new Asignatura)->get($asignatura_id)->nombre;
    foreach ($rows as $key => $indicador)
    {
      $this->data['items'][] = [$indicador->id, $indicador->codigo, $indicador->concepto, $indicador->valorativo];
    }
  }

  
}