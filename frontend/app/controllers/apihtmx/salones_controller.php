<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class SalonesController extends HtmxController
{

  public function get_activos() 
  {
    View::select('index');
    $rows = (new Salon)->getListActivos();
    
    $this->data['headers'] = ['ID', 'Nombre Salón'];
    foreach ($rows as $key => $salon)
    {
      $this->data['items'][] = [$salon->id, $salon->nombre];
    }
  }

  
}