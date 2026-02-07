<?php
trait UsuarioTraitProps {

  protected static $default_foto_usuario = 'upload/users/user.png';

  public function __toString() 
  {
    return $this->getNombreCompleto('a1 a2 n');
  }
  
  public static function getFotoUser(
    int $id, 
    int $max_width=80, 
    string $class='w3-round', 
    bool $show_cod=true
  ): string { 
    $cod_id  = ($show_cod) ? $id.'<br>' : '' ;
    $foto_default = OdaTags::img(
        src:          self::$default_foto_usuario, 
        alt:          $id,
        attrs:        "class=\"$class\" style=\"width:100%;max-width:".$max_width."px\"",
        err_message:  'no image'
    );

    return $cod_id .OdaTags::img(
      src: "upload/users/$id.png", 
      alt: $id, 
      attrs: "class=\"$class\" style=\"width:100%;max-width:".$max_width."px\"",
      err_message: $foto_default
    );
  }

  
  public function getFoto(
    int $max_width=80, 
    bool $show_cod=true
  ) { 
    return self::getFotoUser($this->documento, $max_width, 'w3-round', $show_cod);
  }


  public function getFotoCircle(
    int $max_width=80,
    bool $show_cod=true
  ) { 
    return self::getFotoUser($this->documento, $max_width, 'w3-circle', $show_cod);
  }


  public function getNombreCompleto2(
    $orden='a1 a2, n', 
    $sanear=true, 
    $humanize=false
  ) {
    if ($sanear) {
      $this->nombres   = OdaUtils::sanearString($this->nombres);
      $this->apellido1 = OdaUtils::sanearString($this->apellido1);
      $this->apellido2 = OdaUtils::sanearString($this->apellido2);
    }
    
    if ($humanize) {
      $this->nombres   = OdaUtils::nombrePersona($this->nombres);
      $this->apellido1 = OdaUtils::nombrePersona($this->apellido1);
      $this->apellido2 = OdaUtils::nombrePersona($this->apellido2);
    }
        
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), $orden);
  }


  public function getNombreCompleto(
    $orden='a1 a2, n'
  ): array|string {
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), 
            $orden);
  }

  public function getLnkRetirar(): string 
  {
    return OdaTags::link(
      action: "admin/usuarios/retirar/$this->id", 
      text: 'Retirar');
  }


  public function getCuentaInstit($show_ico=false): string 
  { 
    try {
      $app_externa = Config::get('institutions.'.INSTITUTION_KEY.'.app_externa');
      $sufijo = 'msteams'==$app_externa ? '@'.Config::get('institutions.'.INSTITUTION_KEY.'.dominio') : '';
      
      $ico = $show_ico ? OdaTags::img(src:$app_externa.'_logo.svg', attrs:'width="16"', err_message:'').' '  : '';
      $usuario = $this->usuario_instit ? "{$this->usuario_instit}{$sufijo} {$this->clave_instit}" : 'No tiene usuario en App Externa';
      return $ico . $usuario;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function getId(string $documento): int 
  {
    $source  =  Config::get('tablas.usuario');
    $sql = "SELECT id FROM $source WHERE documento = ?";
    $regUser = static::query($sql, [$documento])->fetch();
    return $regUser ? (int)$regUser->id: 0;
  }


  public static function existe(string $documento): bool 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.id, t.documento")
        ->where('t.documento=?')
        ->setParams([$documento]);
    $Reg = $DQL->executeFirst(true);
    return $Reg ? true : false;
  }


}