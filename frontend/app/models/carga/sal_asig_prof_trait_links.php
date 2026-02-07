<?php

trait SalAsigProfTraitLinks {

  public static function getLnkListaClase(int $periodo_id): string 
  {
    return OdaTags::linkButton(
      action: "admin/cargas/exportListasDeClaseProfesorPdf/$periodo_id", 
      text: "Lista de Clase {$periodo_id}P", 
      attrs: " target=\"_blank\" class=\"w3-button w3-green\""
    );
  }


  public function getLnkPageIndicadores(int $grado_id): string 
  {
    return OdaTags::link(
      action: "docentes/listIndicadores/$grado_id/$this->asignatura_id", 
      text: 'Indicadores'
    );
  }

  public function getLnkPageListNotas(): string 
  {
    return OdaTags::link(
      action: "docentes/listNotas/$this->asignatura_id/$this->salon_id", 
      text: 'Notas'
    );
  }

  
  public function getAsignaturaF(
    int $user_id, 
    string $asignatura_nombre, 
    string $profesor_nombre
  ): string {
    return OdaUtils::sanearString($asignatura_nombre).' '.(($user_id==1)?"[$this->asignatura_id]":'')
            .(($user_id==1) ? "<br> [$profesor_nombre] ($user_id)" :'');
  }

  
  public function getSalonF(
    int $user_id, 
    string $salon_nombre
  ): string {
    return $salon_nombre.' '.(($user_id==1)?"[$this->salon_id]":'');
  }
  


}