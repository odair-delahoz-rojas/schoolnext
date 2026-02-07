<?php
class OdaCheck
{
  protected $checks;
  const WARNING = 1;
  const ERROR = 2;

  const CLASSW3 = [0=>'',1=>'w3-yellow',2=>'w3-red'];
  public function __construct() {
    $this->checks = $this->createChecks();
  }
  
  protected function createChecks() {
    return array(
      'php config' => array(
         new ServerCheckUnit('version', phpversion(), '7.4.0', self::ERROR),
         new ServerCheckUnit('memory', ini_get('memory_limit'), '48M', self::WARNING),
         new ServerCheckUnit('magic quote gpc', ini_get('magic_quotes_gpc'), false),
         new ServerCheckUnit('upload max filesize', ini_get('upload_max_filesize'), '2M'),
         new ServerCheckUnit('post max size', ini_get('post_max_size'), '2M'),
         new ServerCheckUnit('register globals', ini_get('register_globals'), false),
         new ServerCheckUnit('session auto_start', ini_get('session.auto_start'), false),
         new ServerCheckUnit('mbstring', extension_loaded('mbstring'), true, self::WARNING),
         new ServerCheckUnit('utf8_decode()', function_exists('utf8_decode'), true, self::WARNING),
         //new ServerCheckUnit('exec()', function_exists('exec'), true, self::WARNING),
      ),

      'php extensions' => array(
         //new ServerCheckUnit('pdo', extension_loaded('pdo'), true, ''),
         new ServerCheckUnit('pdo_mysql', extension_loaded('pdo_mysql'), true, self::ERROR),
         //new ServerCheckUnit('pdo_pgsql', extension_loaded('pdo_pgsql'), true),
         //new ServerCheckUnit('pdo_sqlite', extension_loaded('pdo_sqlite'), true),
         new ServerCheckUnit('json', extension_loaded('json') ? phpversion('json') : false, '1.0', self::ERROR),
         //new ServerCheckUnit('gd', extension_loaded('gd'), true, self::ERROR),
         //new ServerCheckUnit('date', extension_loaded('date'), true, self::ERROR),
         //new ServerCheckUnit('ctype', extension_loaded('ctype'), true, self::ERROR),
         //new ServerCheckUnit('dom', extension_loaded('dom'), true, self::ERROR),
         //new ServerCheckUnit('iconv', extension_loaded('iconv'), true, self::ERROR),
         //new ServerCheckUnit('pcre', extension_loaded('pcre'), true, self::ERROR),
         //new ServerCheckUnit('reflection', extension_loaded('Reflection'), true, self::ERROR),
         //new ServerCheckUnit('session', extension_loaded('session'), true, self::ERROR),
         new ServerCheckUnit('simplexml', extension_loaded('SimpleXML'), true, self::ERROR),
         //new ServerCheckUnit('bitset', extension_loaded('bitset'), true),
         //new ServerCheckUnit('apc', function_exists('apc_store') ? phpversion('apc') : false, '3.0'),
         new ServerCheckUnit('mbstring', extension_loaded('mbstring'), true),
         new ServerCheckUnit('curl', extension_loaded('curl'), true),
         new ServerCheckUnit('xml', extension_loaded('xml'), true),
         new ServerCheckUnit('xsl', extension_loaded('xsl'), true)
      ),
    );
  } //END-createChecks

  public function getChecks() {
    return $this->checks;
  }

   public function renderContent() {
    return
     sprintf('<h1>KumbiaPHP Framework %s System Check</h1>', KUMBIA_VERSION)
    .sprintf('<div class="w3-half">%s%s%s</div>',
            $this->renderTable('php config') )
    .sprintf('<div class="w3-half">%s</div>', 
            $this->renderTable('php extensions'));
  }

  protected function renderTable($name) {
    return
    '<table>'.
    sprintf('<thead><tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr></thead>', 
               ucfirst($name), 'Requerimiento', 'Server state', 'Diagnostic').
    sprintf('<tbody>%s</tbody>', $this->renderRows($this->checks[$name])).
    '</table>';
  }

  protected function renderRows(array $checks)
  {
    $html = '';
    foreach($checks as $check)
    {
      $html .= sprintf('<tr class="w3-blue"><th>%s</th><td>%s</td><td>%s</td><td>%s</td></tr>',
      $check->nombre(),
      $check->servidor(),
      $check->rerequerido(),
      $check->diagnostico()
      );
    }
    return $html;
  }



} // END-OdaCheck



class ServerCheckUnit
{
  protected
  $nombre,
  $servidor,
  $requerido,
  $diagnostico;

  public function __construct($nombre, $servidor, $requerido, $diagnostico=0)
  {
    $this->nombre = $nombre;
    $this->servidor = $servidor;
    $this->requerido = $requerido;
    $this->diagnostico = $diagnostico;
  }

  public function isRequired() {
    return OdaCheck::ERROR === $this->diagnostico;
  }

  protected function renderValue($value) {
    if (is_bool($this->requerido)) {
      return (($this->requerido) ? 'ON' : 'OFF' );
    }
    return $this->requerido;
  }

  public function __toString() {
    return $this->nombre;
  }

}