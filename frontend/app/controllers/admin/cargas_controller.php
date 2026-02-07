<?php
/**
  * Controlador Cargas  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class CargasController extends ScaffoldController
{
  
  public function exportListasDeClaseProfesorPdf(int $periodo_id) 
  {
    try
    {
      $this->data = (new SalAsigProf())->getCarga($this->user_id);
      $this->arrData['periodo']  = $periodo_id;
      $this->arrData['user_id']  = $this->user_id;
      $this->file_tipo = 'Listas de clase';
      $this->file_name = OdaUtils::getSlug("lista-de-clase-periodo-$periodo_id");
      $this->file_title = "Lista de Clase PDF - Periodo $periodo_id";
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    View::select(view: "lista_clase.pdf", template: null);
  }



}