<?php
trait EstudianteTraitProps
{

  protected static $default_foto_estud = 'upload/estudiantes/user.png';
  protected static $default_foto_estud_f = 'upload/estudiantes/user_f.png';
  protected static $default_foto_estud_m = 'upload/estudiantes/user_m.png';

  public function __toString(): string
  {
    return $this->getNombreCompleto(sanear: true, mayuscula: false) . ' ' . $this->getCodigo();
  }


  static public function getId(string $documento): int
  {
    $source = Config::get('tablas.estudiante');
    $sql = "SELECT id FROM $source WHERE documento = ?";
    $regUser = static::query($sql, [$documento])->fetch();
    return (($regUser) ? (int) $regUser->id : 0);
  }


  public function getCodigo(): string
  {
    return '[Cod: ' . $this->id . ']';
  }


  public function getApellidos(): string
  {
    return $this->apellido1 . ' ' . $this->apellido2;
  }


  public function getNombre($orden = 'n,a1,a2'): string {
    return $this->getNombreCompleto(orden: $orden, sanear: true, mayuscula: false);
  }


  public function getNombreCompleto(
    $orden = 'a1 a2, n',
    $sanear = true,
    $mayuscula = false
  ): string {
    $nombre_completo = str_replace(
      search: ['n', 'a1', 'a2'],
      replace: [(string) $this->nombres, (string) $this->apellido1, (string) $this->apellido2],
      subject: $orden
    );

    if ($sanear)
      $nombre_completo = OdaUtils::sanearString($nombre_completo);

    $nombre_completo = mb_convert_case($nombre_completo, MB_CASE_TITLE, "UTF-8");

    if ($mayuscula)
      $nombre_completo = strtoupper($nombre_completo);

    return $nombre_completo;
  }


  public function isPazYSalvo(): bool
  {
    $periodo = self::$_periodo_actual;
    $annio = self::$_annio_actual;

    // cambiar por match expres
    if (
      $periodo == 1 and $this->mes_pagado >= parent::LIM_PAGO_PERIODOS[1]
      and $this->annio_pagado == $annio
    ) {
      return true;
    }

    if (
      $periodo == 2 and $this->mes_pagado >= parent::LIM_PAGO_PERIODOS[2]
      and $this->annio_pagado == $annio
    ) {
      return true;
    }

    if (
      $periodo == 3 and $this->mes_pagado >= parent::LIM_PAGO_PERIODOS[3]
      and $this->annio_pagado == $annio
    ) {
      return true;
    }

    if (
      $periodo == 4 and $this->mes_pagado >= parent::LIM_PAGO_PERIODOS[4]
      and $this->annio_pagado == $annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos
    ) {
      return true;
    }

    if (
      $periodo == 5 and $this->mes_pagado >= parent::LIM_PAGO_PERIODOS[5]
      and $this->annio_pagado == $annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos
    ) {
      return true;
    }

    return false;
  }


  public function isPazYSalvoIco(): string
  {
    $result =
      ($this->isPazYSalvo())
      ? ' <span class="w3-text-green">' . _Icons::solid('coins', 'w3-large') . '</span>'
      : ' <span class="w3-text-red">' . _Icons::solid('coins', 'w3-large') . '</span>';
    return $result;
  }


  public function getCuentaInstit($show_ico = false): string
  {
    try {
      $app_externa = Config::get('institutions.' . INSTITUTION_KEY . '.app_externa');
      $sufijo = ('msteams' == $app_externa) ? '@' . Config::get('institutions.' . INSTITUTION_KEY . '.dominio') : '';

      $ico = ($show_ico) ? OdaTags::img(src: $app_externa . '_logo.svg', attrs: 'width="16"', err_message: '') . ' ' : '';

      return $ico . (
        ($this->email_instit) ? $this->email_instit . $sufijo . ' ' . $this->clave_instit : 'No tiene usuario en App Externa'
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th, true);
      return '';
    }
  }


  public static function getFotoEstud(
    int $id,
    int $max_width = 80,
    string $class = 'w3-round',
    bool $show_cod = true,
    string $sexo = 'm'
  ): string {
    $cod_id = ($show_cod) ? 'est-' . $id . '<br>' : '';

    $img_default = match (strtolower(substr(trim($sexo), 0, 1))) {
      'm' => self::$default_foto_estud_m,
      'f' => self::$default_foto_estud_f,
      default => self::$default_foto_estud,
    };

    $foto_default = OdaTags::img(
      src: $img_default,
      alt: $id,
      attrs: "class=\"$class\" width:\"{$max_width}\"",
      err_message: 'no image'
    );

    return $cod_id . OdaTags::img(
      src: "upload/estudiantes/$id.png",
      alt: $id,
      attrs: "class=\"$class\" width=\"{$max_width}\"",
      err_message: $foto_default
    );
  }


  public function getFoto(int $max_width = 80, bool $show_cod = false)
  {
    return self::getFotoEstud((int) $this->id, $max_width, 'w3-round', $show_cod, $this->sexo);
  }


  public function getFotoCircle(int $max_width = 80, bool $show_cod = true)
  {
    return self::getFotoEstud((int) $this->id, $max_width, 'w3-circle', $show_cod, $this->sexo);
  }


  public function isNuevo(): bool
  {
    $fecha_lim = (string) (Date('Y') - 1) . '-10-01';
    return ((substr($this->created_at, 0, 10) >= $fecha_lim) ? true : false);
  }


  public function tiempoRetiro(): string
  {
    $timezone = new DateTimeZone("America/Bogota");
    if ($this->fecha_ret !== null and '0000-00-00' != $this->fecha_ret) {
      $fecha_ret = new DateTime($this->fecha_ret, $timezone);
      $hoy = new DateTime("NOW", $timezone);
      $interval = $hoy->diff($fecha_ret);
      $reciente = '<span class="w3-tag w3-green w3-round"> Reciente </span>';

      if ($interval->format('%y') > 0) {
        if ($interval->format('%y') == 1) {
          return $interval->format("%y año, %m mes(es), %d día(s) {$reciente}");
        } else {
          return $interval->format('%y año(s), %m mes(es), %d día(s)');
        }
      } else {
        if ($interval->format('%m') > 0) {
          return $interval->format("%m mes(es), %d día(s) {$reciente}");
        } else {
          if ($interval->format('%d') > 0) {
            return $interval->format("%d día(s)  {$reciente}");
          } else {
            return "Se retiró hoy {$reciente}";
          }
        }
      }
    }
    return 'No registrado';
  }


  public function isNuevoIco(): string
  {
    return ($this->isNuevo() ? '<span class="w3-text-red"> [NEW]</span>' : '');
  }


  public function getPagoPension(): string
  {
    return 'Pago Pensión: ' . OdaUtils::nombreMes((int) $this->mes_pagado) . ' de ' . $this->annio_pagado;
  }


  public function getDebePreicfes(): string
  {
    return 'Debe Preicfes: ' . (($this->is_debe_preicfes) ? 'SI' : 'NO');
  }


  public function getDebeAlmuerzos(): string
  {
    return 'Debe Almuerzos: ' . (($this->is_debe_almuerzos) ? 'SI' : 'NO');
  }


  public function getAnnioNac()
  {
    return (($this->fecha_nac) ? date('Y', strtotime($this->fecha_nac)) : '');
  }


  public function getMesNac(): string
  {
    return (($this->fecha_nac) ? date('M', strtotime($this->fecha_nac)) : '');
  }


  public function getDiaNac()
  {
    return (($this->fecha_nac) ? date('d', strtotime($this->fecha_nac)) : '');
  }


  public function getEdad(): string
  {
    if (!$this->fecha_nac) {
      return '';
    }
    $timezone = new DateTimeZone("America/Bogota");
    $fecha_nac = new DateTime($this->fecha_nac, $timezone);
    $hoy = new DateTime("now", $timezone);
    $interval = $hoy->diff($fecha_nac);
    return $interval->format('%y año(s), %m mes(es), %d día(s)');
  }



}