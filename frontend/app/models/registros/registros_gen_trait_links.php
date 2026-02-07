<?php

trait RegistrosGenTraitLinks {

  public function lnkEditRegistro(string $nombre_estudiante): string 
  {
    $result = '';
    if (!$this->isRegistroOk()) { 
      $result = "
      <button 
        id=\"id_btn_edit\" 
        class=\"w3-btn w3-pale-green\" 
        onclick=\"show_edit_form($this->id, '$nombre_estudiante')\">
          Editar
      </button>";
    }
    return $result;
  }

  
  public static function lnkPageRegistrosGrupo(): string 
  {
    return OdaTags::linkButton(
      action: "docentes/registros_grupo", 
      text: "Ver Registros del Grupo",      
      attrs: 'class="w3-button w3-pale-red"',
    );
  }
  
}