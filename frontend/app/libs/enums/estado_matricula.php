<?php
enum EstadoMatricula: int {
  Use EnumsFunciones;

  case Bloqueado = 0;
  case NoPromovido = 1;
  case SinDocumentos = 2;
  case DocIncompletos = 3;
  case DocEnRevision = 4;
  case DocRechazados = 5;
  case DocAprobados = 6;
  case FaltaFirmas = 7;
  case Terminado = 8;
  case Error = 99;
  
  public function label(): string 
  {
    return match($this) {
      static::Bloqueado       => 'Bloqueado x Contabilidad',
      static::NoPromovido     => 'Estudiante No Promovido', // estan pendientes de notas 
      static::SinDocumentos   => 'No ha subido Documentos',
      static::DocIncompletos  => 'Documentos INCOMPLETOS',
      static::DocEnRevision   => 'Documentos EN REVISIÓN',
      static::DocRechazados   => 'Documentos RECHAZADOS',
      static::DocAprobados    => 'Documentos APROBADOS, Falta ASIGNAR NÚMERO DE MATRÍCULA',
      static::FaltaFirmas     => 'Documentos APROBADOS, Falta FIRMAS DE ACEPTACIÓN del Acudiente',
      static::Terminado       => 'Proceso Terminado',
      static::Error           => 'Error en el Proceso',
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function comments(): string 
  {
    return match($this) {
      static::Bloqueado       => 'Debe comunicarse con el departamento de contabilidad',
      static::NoPromovido     => 'EL estudiante está pendiente de validar planes de apoyo del año anterior',
      static::SinDocumentos   => 'Debe subir la totalidad de los documentos exigidos',
      static::DocIncompletos  => 'Debe subir los documentos faltantes',
      static::DocEnRevision   => 'solo falta que el funcionario encargado apruebe los documentos, debe acercarse lo mas pronto posible a la institución para finalizar el proceso',
      static::DocRechazados   => 'Debe subir los documentos rechazados nuevamente',
      static::DocAprobados    => 'Falta ASIGNAR NÚMERO DE MATRÍCULA',
      static::FaltaFirmas     => 'Debe firmar los documentos de matrícula, dirigirse a la institución para realizarlo',
      static::Terminado       => 'El estudiante ya se encuentra matriculado.',
      static::Error           => 'Error en el Proceso',
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function puedeMatricular(): bool
  {
    return match($this) {
      static::Bloqueado, static::NoPromovido => false,
      default => true,
    };
  }

  //Una vez que hayas cargado los documentos, .

  public function ico(): string 
  {
    return ''; // "<i class=\"fa-solid fa-calendar-day w3-small\"></i>&nbsp;";
  }
  
  public function label_ico(): string 
  {
    return $this->ico().$this->label();
  }

  public static function caption(): string 
  {
    return 'Estado del Proceso de Matriculas';
  }

} // END-ENUM