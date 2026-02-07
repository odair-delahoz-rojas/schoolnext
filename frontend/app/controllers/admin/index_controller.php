<?php

/**
 * Controller por defecto en admin
 *
 */
class IndexController extends AppController
{

  public function index() 
  {
    try
    {
      $this->page_action = 'M&oacute;dulo Admin';
      $this->data = (new Evento)->getEventosDashboard();
      if ('bootstrap' == Config::get('config.theme.admin'))
      {        
        View::select(view: 'indexb', template: 'bootstrap5htmx-template');
      }
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }



}