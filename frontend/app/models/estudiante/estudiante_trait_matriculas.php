<?php
trait EstudianteTraitMatriculas {
  
  public function getEstadoMat(): EstadoMatricula 
  {
    try
    {
      if ($this->esDeudor()) {
        return EstadoMatricula::Bloqueado;
      }

      if (!$this->puedeMatricular()) {
        return EstadoMatricula::NoPromovido;
      }

      //  POR MEJORAR !!
      $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM ".static::getSource()." WHERE estudiante_id=?", [$this->id] );
      if ($Adjuntos) {
        $estado_docs = $Adjuntos->getEstadoDocsMatricula($this->grado_promovido);
      } 
      else {
        return EstadoMatricula::Error;
      }
      

      if (EstadoMatricula::DocAprobados != $estado_docs) { 
        return $estado_docs; // Atascado en revisión de documentos
      }

      if ( empty($this->numero_mat) ) { 
        return EstadoMatricula::DocAprobados; // Aprobados pero sin firmas de documentos
      }

      return EstadoMatricula::Terminado;
    
    }
    
    catch
    (\Throwable $th)
    {
      OdaFlash::error($th, true);
      return EstadoMatricula::Error;
    }
  }


  public function esDeudor(): bool 
  {
    $mes_limite = 1;
    if ($this->annio_promovido > $this->annio_pagado) 
    {
      $mes_limite = 11;
    }
    return (
      ($this->is_debe_preicfes) 
      or ($this->is_debe_almuerzos) 
      or ($this->mes_pagado>=$mes_limite));
  }

  
  public function puedeMatricular(): bool 
  {
    return (1==$this->is_habilitar_mat);
  }
  
  
  public function numero_mat_f(): string
  {
    if ( empty($this->numero_mat) ) 
    {
      return '';
    }
    return str_pad($this->numero_mat, 4, '0', STR_PAD_LEFT);
  }

  
  function getListMatriculados() 
  {
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.*, g.nombre AS grado_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'estudiante_nombre')
      ->leftJoin('grado', 'g', 't.grado_promovido=g.id')
      ->where("t.is_active=1 AND t.numero_mat>0")
      ->orderBy('g.orden,t.apellido1,t.apellido2,t.nombres');
    
    return $DQL->execute();
  }

  
  function getListPendientesMatricula() 
  {
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.*, g.nombre AS grado_nombre')
      ->addSelect('de.tipo_acudi, de.madre, de.madre_tel_1, de.padre, de.padre_tel_1, de.acudiente, de.acudi_tel_1')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'estudiante_nombre')
      ->leftJoin('grado', 'g', 't.grado_promovido=g.id')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->where("t.is_active=1 AND (t.numero_mat=0 OR ISNULL(t.numero_mat))")
      ->orderBy('g.orden,t.apellido1,t.apellido2,t.nombres');
    
    return $DQL->execute();
  }
  

  public function getInfoContactoAcudiente() 
  {
    if ('MADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return "$this->madre $this->madre_tel_1";
    }
    if ('PADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return "$this->padre $this->padre_tel_1";
    }    
    return "$this->acudiente $this->acudi_tel_1";
  }



  
}