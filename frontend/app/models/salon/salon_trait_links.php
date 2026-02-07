<?php

trait SalonTraitLinks {
  
  public function getLnkPreboletin(): string {
    try {
      $periodo_actual = self::$_periodo_actual;
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/0", text: 'Preboletin', attrs: " target=\"_blank\" class=\"w3-button w3-green\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
  public function getLnkBoletin(): string {
    try {
      $periodo_actual = self::$_periodo_actual;
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/1", text: 'Boletin', attrs: " target=\"_blank\" class=\"w3-button w3-green\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
  public function getLnkSetupCalificarSalon(): string
  {
    try
    {
      $result = '';
      if (self::$_periodo_actual != $this->is_ready_print)
      {
        $result = OdaTags::linkButton(action: "admin/salones/setupCalificarSalon/$this->id", text: 'Setup Cal', attrs: " class=\"w3-button w3-green\"");
      }
      return $result;
    } 
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }
  

} //END-Trait