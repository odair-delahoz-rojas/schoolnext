<?php
trait NotaTraitLinks 
{

  public static function lnkCuadroHonorPrescolarPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorPrescolarPdf/$periodo", 
        text: "Prescolar Top 10 - P$periodo",      
        attrs: 'class="w3-button w3-green" target="_blank"',
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }

  public static function lnkCuadroHonorPrimariaPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorPrimariaPdf/$periodo", 
        text: "Primaria Top 10 - P$periodo",      
        attrs: 'class="w3-button w3-green" target="_blank"',
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }  
  
  public static function lnkCuadroHonorBachilleratoPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorBachilleratoPdf/$periodo", 
        text: "Bachillerato Top 10 - P$periodo",
        attrs: 'class="w3-button w3-green" target="_blank"',
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }
    
  public static function lnkCuadroHonorGeneralPrescolarPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorGeneralPrescolarPdf/$periodo", 
        text: "Prescolar Puestos P$periodo",      
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }

  public static function lnkCuadroHonorGeneralPrimariaPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorGeneralPrimariaPdf/$periodo", 
        text: "Primaria Puestos P$periodo",      
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }  
  
  public static function lnkCuadroHonorGeneralBachilleratoPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorGeneralBachilleratoPdf/$periodo", 
        text: "Bachillerato Puestos P$periodo",
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }
  
  public static function lnkPageCalificar(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try
    {
      if (!$enabled)
      {
        return '';
      }
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificar/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Calificar <br>Periodo {$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar NOTAS" class="w3-button w3-small w3-pale-green w3-round-large"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function lnkPageSeguimientos(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try
    {
      if (!$enabled)
      {
        return '';
      }

      $titulo = (INSTITUTION_KEY=='santarosa') ? 'PREINFORMES' : 'SEGUIMIENTOS INTERMEDIOS';
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificarSeguimientos/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "{$titulo} <br>Periodo {$periodo_id}", 
        icon: '', 
        attrs: "title=\"Ingresar {$titulo}\" class=\"w3-button w3-small w3-pale-blue w3-round-large\""
      );
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function lnkPagePlanesApoyo(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try 
    {
      if (!$enabled)
      {
        return '';
      }
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificarPlanesApoyo/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Planes de <br>Apoyo Periodo {$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar PLANES DE APOYO" class="w3-button w3-small w3-pale-red w3-round-large"'
      );
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }


}