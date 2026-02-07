<?php

trait SeguimientosTraitLinks {

  public static function lnkPageSeguimientosGrupo(): string 
  {
    return OdaTags::linkButton(
      action: "docentes/seguimientos_grupo", 
      text: "Ver Seguimientos del Grupo",      
      attrs: 'class="w3-button w3-pale-blue"',
    );
  }
  

}