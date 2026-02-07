<?php

 trait IndicadorTraitProps {

  public function __toString() 
  { 
    return (string)$this->codigo;
  }

  
  public static function indicadorF(
    int $indicador=101, 
    array $ListaIndicadores = [], 
    array $attr = [], 
    $react = false
  ): string
  {
    if (0==$indicador) {
      return '';
    }

    if (!is_null($ListaIndicadores)) {
      if (array_key_exists($indicador, $ListaIndicadores)) {
        $valorativo = Valorativo::tryFrom( $ListaIndicadores[$indicador]['valorativo'][0] );
        $concepto = trim($ListaIndicadores[$indicador]['concepto']);
        
        $fnc_react = '';
        if ($react) {
          $fnc_react = "
            onclick=\"indicador_onclick($indicador)\"
            onmouseenter=\"indicador_onmouseenter('$concepto')\"
            onmouseleave=\"indicador_onmouseleave()\"
          ";
        }

        return "
          <span 
            title=\"[$indicador] $concepto\"
            codigo_indic=\"$indicador\"
            color_indic=\"{$valorativo->color()}\"
            $fnc_react
            class=\"show-indic w3-tag w3-round w3-{$valorativo->color()} w3-border w3-border-white\"
          >
              $indicador
          </span>";

      } else {
        return "<span>$indicador</span>";
      }
    }

    return "<span>$indicador</span>";    
  }



}