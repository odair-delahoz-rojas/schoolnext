<?php
/**
 * Modelo 
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
 trait GradoTraitProps {

  public function __toString(): string 
  { 
    return (string)$this->nombre; 
  }


  public function getIsPrescolar(): string 
  { 
    return ( 1 == $this->seccion_id ) ? 'X': ''; 
  }


  public function getIsPrimaria(): string { 
    return ( 2 == $this->seccion_id ) ? 'X': ''; 
  }


  public function getIsMediaAcademica(): string 
  { 
    return (
      (3 == $this->seccion_id ) 
      ? 'X'
      : ''
    ); 
  }


  public function getIsBasicaSecundaria(): string 
  { 
    return (
      (4 == $this->seccion_id) 
      ? 'X'
      : ''
    ); 
  }


  public function getIsBachillerato(): string 
  { 
    return (
      (in_array($this->seccion_id, [3, 4]) ) 
      ? 'X'
      : '' 
    );
  }
  

  public function getValorPension($lim=0) 
  { 
    $pension_ord = $this->valor_pension;
    
    switch ($lim) {
      case 0: // 0: Ordinaria
        $pension = $pension_ord;
        break;

      case 1: // 1: Extemporanea 1
        $pension = round($pension_ord*1.02,-2);
        break;

      case 2: // 2: Extemporanea 2
        $pension = round($pension_ord*1.04,-2);
        break;

      case 3: // 3: Extemporanea 3
        $pension = round($pension_ord*1.06,-2);
        break;

      case 4: // 4: Extemporanea 4
        $pension = round($pension_ord*1.08,-2);
        break;
        
      default:
        $pension = $pension_ord;
        break;
    }

    return $pension;
  }


  public function getValorPensionF($lim=0): string 
  { 
    return '$'.number_format($this->getValorPension($lim), 0, ',', '.'); 
  }
  

  public function getValorMatricula($ordinaria=1): int 
  { 
    if ($ordinaria==1) {
      return (int)$this->valor_matricula;
    }
    
    return ((int)$this->valor_matricula + 100000);
  }


  public function getValorMatriculaF($ordinaria=1): string 
  { 
    return '$'.number_format($this->getValorMatricula($ordinaria), 0, ',', '.'); 
  }


  public function getCostoAnualMatricula($ordinaria=1) 
  {
    return $this->getValorPension()*10 + $this->getValorMatricula($ordinaria);
  }


  public function getCostoAnualMatriculaF($ordinaria=1): string 
  { 
    return '$'.number_format($this->getCostoAnualMatricula($ordinaria), 0, ',', '.'); 
  }


  public function getCostoAnualMatriculaPalabras($ordinaria=1): string 
  { 
    return $this->valor_letras($this->getCostoAnualMatricula($ordinaria));
  }


}