<?php


#[AllowDynamicProperties]
class IndicadorAdmin extends ActiveRecord
{
  protected $source = 'sweb_indicadores';
    
  public function getList() 
  {
    return (new User)->find();
  }
  

  public function getUsuarios($page, $ppage=50) 
  {
    return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');
  }


  public function getUsuariosActivos($page, $ppage=50) 
  {
    return $this->paginate("page: $page", 'conditions: is_active=1' , "per_page: $ppage", 'order: id desc');
  }


  public function getUsuariosInactivos($page, $ppage=50) 
  {
    return $this->paginate("page: $page", 'conditions: is_active=0' , "per_page: $ppage", 'order: id desc');
  }



}