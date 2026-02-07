<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
 trait RegistroDesempAcadTraitProps {

  public function __toString(): string 
  { 
    return $this->fecha.'<br>'.$this->annio .'-P' .$this->periodo_id ; 
  }


  public function getFecha($date_format="d-M-Y"): string 
  { 
    return date($date_format, strtotime($this->fecha)); 
  }


  public function getFotoAcudiente() 
  {
    if (!$this->foto_acudiente) { return 'sin evidencia'; }
    $filename = 'estud_reg_des_aca_com/'.$this->foto_acudiente;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  }
  
  
  public function getFotoDirector() 
  {
    if (!$this->foto_director) { return 'sin evidencia'; }
    $filename = 'estud_reg_des_aca_com/'.$this->foto_director;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  }



}