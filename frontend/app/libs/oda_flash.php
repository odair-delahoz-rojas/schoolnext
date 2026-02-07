<?php
/**
 * Extension para el manejo de mensajes sin hacer uso del "echo" en los controladores o modelos
 * @category  Flash
 * @package   Helpers
 * Se utiliza en el método content de la clase view.php
 * OdaFlash::output();
 */

class OdaFlash
{
  private static $_contentMsj = [];

  protected static $icons = [
    'error' => 'x',
    'warning' => 'circle-exclamation',
    'info' => 'bell',
    'valid' => 'hands-clapping',
  ];

  protected static $themes = [
    'error' => 'w3-pale-red',
    'warning' => 'w3-pale-yellow',
    'info' => 'w3-pale-blue',
    'valid' => 'w3-pale-green',
  ];

  protected static function UUIDReal(int $lenght = 20): string {
    if (function_exists("random_bytes")) {
      $bytes = random_bytes(ceil($lenght / 2));
    } 
    elseif (function_exists("openssl_random_pseudo_bytes")) {
      $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
      throw new Exception("no cryptographically secure random function available");
    }

    return substr(bin2hex($bytes), 0, $lenght);
  }

  public static function set(string $name, $msg, bool $audit = FALSE) : void {
    $color = self::$themes[$name];
    $icon = '<i class="fa fa-' . self::$icons[$name] . '"></i>&nbsp; ';
    $uuid = self::UUIDReal();
    $lnk = OdaUtils::linkToSupportWhatsApp($uuid);

    if (self::hasMessage()) {
      self::$_contentMsj = Session::get('flash_message');
    }

    $message = match ($name) {
      'error'   => "<b>EXCEPCIÓN INTERNA CAPTURADA:</b> {$msg->getMessage()}<br>{$lnk}",
      'warning' => "{$msg}<br>{$lnk}",
      default   => $msg,
    };

    if (isset($_SERVER['SERVER_SOFTWARE'])) {
      $tmp_id = round(1, 5000);
      self::$_contentMsj[] = "<div id=\"alert-id-{$tmp_id}\" class=\"w3-panel w3-display-container w3-round {$color}\">
                <span onclick=\"this.parentElement.style.display='none'\"
                class=\"w3-button w3-large w3-display-topright\">&times;</span>
                <p>{$icon} {$message}</p>
              </div>";
    } 
    else {
      self::$_contentMsj[] = $name . ': ' . Filter::get($msg, 'striptags') . PHP_EOL;
    }

    Session::set('flash_message', self::$_contentMsj);
  
    if ($audit) {
      match ($name) {
          'error'   => OdaLog::error($msg, $uuid),
          'warning' => OdaLog::warning($msg, $uuid),
          'info'    => OdaLog::info($msg, $uuid),
          'valid'   => OdaLog::notice($msg, $uuid),
          default   => null,
      };
    }

  }


  public static function hasMessage(): bool {
    return Session::has('flash_message') ? TRUE : FALSE;
  }


  public static function clean(): void {
    self::$_contentMsj = [];
    Session::delete('flash_message');
  }


  public static function output(): void {
    if (OdaFlash::hasMessage()) {
      $tmp_msg = Session::get('flash_message');
      foreach ($tmp_msg as $msg) {
        echo $msg;
      }
      self::clean();
    }
  }


  public static function toString(): string {
    $tmp = self::hasMessage() ? Session::get('flash_message') : [];
    $msg = [];

    foreach ($tmp as $item) {
      $item = explode('<script', $item);
      if (!empty($item[0])) {
        $msg[] = str_replace('×', '', Filter::get($item[0], 'striptags'));
      }
    }

    $flash = (string)Filter::get(ob_get_clean(), 'striptags', ['trim']); // Almaceno los mensajes que hay en el buffer (por los echo)
    $msg = (string)Filter::get(join('<br/>', $msg), 'trim');
    self::clean();

    return ($flash) ? "{$flash} <br/> {$msg}" : $msg;
  }

  public static function error(Throwable $msg, bool $audit = TRUE): void {
    self::set('error', $msg, $audit);
  }

  public static function warning(string $msg, bool $audit = TRUE): void {
    self::set('warning', '<b>ATENCI&Oacute;N: FALL&Oacute; OPERACI&Oacute;N:</b> ' . $msg, $audit);
  }

  public static function info(string $msg, bool $audit = FALSE): void {
    self::set('info', '<b>Aviso informativo:</b> ' . $msg, $audit);
  }

  public static function valid(string $msg, bool $audit = FALSE): void {
    self::set(name: 'valid', msg: '<b>Operaci&oacute;n exitosa:</b> ' . $msg, audit: $audit);
  }


}