<?php

trait RegistrosGenTraitProps {

  public function __toString(): string 
  { 
    return $this->fecha.'<br>'.$this->annio .'-P' .$this->periodo_id ; 
  }

  public function getFecha($date_format="d-M-Y"): string 
  { 
    return date($date_format, strtotime($this->fecha)); 
  }
  
  public function getFotoAcudiente(): string 
  {
    return '';  // TEMPORAL
    //if (!$this->foto_acudiente) {  return 'sin evidencia'; }
    //if (!$this->foto_acudiente) { 
    //  return ''; 
    //}
    // $filename = 'estud_reg_observ_gen/'.$this->foto_acudiente;
    // return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  }
  
  
  public function getFotoDirector() 
  {
    if (!$this->foto_director) { 
      return 'sin evidencia'; 
    }

    $filename = 'estud_reg_observ_gen/'.$this->foto_director;

    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  }


  public function isRegistroOk(): bool 
  {
    if (empty($this->foto_director)) { 
      return false;
    }

    return true;
  }
  
  

}