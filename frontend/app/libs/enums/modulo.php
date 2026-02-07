<?php
enum Modulo: int {

  Use EnumsFunciones;
  
  case General  = 0;
  case Admin    = 1;
  case Conta    = 2;
  case Coord    = 3;
  case Docen    = 4;
  case Enfer    = 5;
  case Padre    = 6;
  case Psico    = 7;
  case Secre    = 8;
  case DirGrupo = 9;
  
  
  public function label(bool $abrev=false): string 
  {
    return match($this) 
    {
      static::General  => (($abrev) ? 'Grl'   : 'General'),
      static::Admin    => (($abrev) ? 'Admin' : 'Administrador'),
      static::Conta    => (($abrev) ? 'Cont'  : 'Contabilidad'),
      static::Coord    => (($abrev) ? 'Coor'  : 'Coordinacion'),
      static::Docen    => (($abrev) ? 'Doce'  : 'Docentes'),
      static::Enfer    => (($abrev) ? 'Enfe'  : 'Enfermeria'),
      static::Padre    => (($abrev) ? 'Padr'  : 'Padres'),
      static::Psico    => (($abrev) ? 'Psic'  : 'Psicologia'),
      static::Secre    => (($abrev) ? 'Secr'  : 'Secretaria'),
      static::DirGrupo => (($abrev) ? 'DirG'  : 'Director de Grupo'),
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function carpetas(): string 
  {
    return match($this) 
    {
      static::General  => 'general',
      static::Admin    => 'admin',
      static::Conta    => 'contabilidad',
      static::Coord    => 'coordinador',
      static::Docen    => 'docentes',
      static::Enfer    => 'enfermeria',
      static::Padre    => 'padres',
      static::Psico    => 'sicologia',
      static::Secre    => 'secretaria',
      static::DirGrupo => 'director_grupo',
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function ico(): string 
  {
    return "<i class=\"fa-solid fa-layer-group w3-small\"></i>&nbsp;";
  }
  
  public function label_ico(): string 
  {
    return $this->ico().$this->label();
  }

  public static function caption(): string 
  {
    return 'M&oacute;dulo del sistema';
  }


} // END-ENUM