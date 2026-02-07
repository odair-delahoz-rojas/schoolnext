<?php

trait EstudianteAdjuntosTraitProps {

  public function tieneDocumentos(): bool 
  {
    $archivos = 
      $this->nombre_archivo1 
      .$this->nombre_archivo2 
      .$this->nombre_archivo3
      .$this->nombre_archivo4 
      .$this->nombre_archivo5 
      .$this->nombre_archivo6
      .$this->nombre_archivo7;

    return(
      (strlen($archivos) >0) 
      ? true 
      : false
    );
  }

  
  public function getLinkArchivo(int $num_archivo): string 
  {
    $arch = "nombre_archivo$num_archivo";
    $nombre_archivo = Config::get('matriculas.'.INSTITUTION_KEY.'.file_'.$num_archivo.'_titulo');
    if ($this->$arch)
    {
      return OdaTags::linkExterno(
        url: FILE_UPLOAD_PATH.'matriculas_adjuntos/'.$this->$arch, 
        text: "Ver Archivo : $nombre_archivo",
        attrs:'class="w3-button w3-blue"');
    }
    return $nombre_archivo;
  }

  
  public function getEstadoArchivo(int $num_archivo): string 
  {
    $arch = "nombre_archivo$num_archivo";
    $estado = "estado_archivo$num_archivo";
    if ($this->$arch)
    {
      return $this->$estado ?? '';
    }
    return 'Archivo no Subido';
  }

  
  public function getComentAPapa(int $num_archivo): string 
  {
    $arch = "nombre_archivo$num_archivo";
    $coment = "coment_archivo$num_archivo";
    if ($this->$arch)
    {
      return $this->$coment ?? '';
    }
    return '';
  }


  public function getEstadoDocsMatricula(int $grado_id): EstadoMatricula 
  {
    $cant_docs_requeridos = ($grado_id>=9 and $grado_id<=11) ? 5 : 4;
    $cant_docs_subidos = 0;
    $cant_docs_en_revision = 0;
    $cant_docs_rechazados = 0;
    $cant_docs_aprobados = 0;

    for ($i=1; $i<=$cant_docs_requeridos; $i++)
    {
      $nombre = "nombre_archivo$i";
      if ($this->$nombre)
      {
        $cant_docs_subidos += 1;
        //$estado = "estado_archivo$i";
        $estado = $this->{'estado_archivo'.$i} ?? 'En Revisión';
        //switch ($this->$estado) {
        switch ($estado)
        {
          case 'En Revisión':
            $cant_docs_en_revision += 1;
            break;
          case 'Rechazado':
            $cant_docs_rechazados += 1;
            break;
          case 'Aprobado':
            $cant_docs_aprobados += 1;
            break;
          default:
            $cant_docs_en_revision += 1;
        }
      }
    }

    $estado_result = EstadoMatricula::SinDocumentos;

    if ($cant_docs_subidos==0)
    { 
      return EstadoMatricula::SinDocumentos; 
    }

    if ($cant_docs_subidos!=$cant_docs_requeridos)
    { 
      return EstadoMatricula::DocIncompletos; 
    }

    if ($cant_docs_rechazados>0)
    { 
      return EstadoMatricula::DocRechazados; 
    }

    if ($cant_docs_en_revision>0)
    { 
      return EstadoMatricula::DocEnRevision; 
    }

    if ($cant_docs_aprobados>0)
    { 
      return EstadoMatricula::DocAprobados; 
    }
    
    return $estado_result;
  }



}