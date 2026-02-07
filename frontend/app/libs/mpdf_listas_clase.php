<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */
require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfListasClase extends Mpdf 
{
  
  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);
    $DoliK = new DoliConst();
    $link_web_page = $DoliK->getValue('MAIN_INFO_SOCIETE_WEB') ?? '';
    $nombre_instituto = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '';

    $this->SetTitle('LISTAS DE CLASE');
    $this->SetAuthor($nombre_instituto);
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetSubject('LISTAS DE CLASE');
    $this->SetKeywords('listas, clase');
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(9);
    $this->SetMargins(15, 5, 30 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.$link_web_page.'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/'.Config::get('institutions.'.INSTITUTION_KEY.'.logo').'" alt="Logo" height="40"> </a>';
    $this->SetHTMLHeader("
    <div style=\"text-align: center; font-weight: bold;\"> $logo </div>");
    //<td width="33%">{DATE j-m-Y}</td>
    $this->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">SchoolNEXT>></td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">Listas de Clase</td>
        </tr>
    </table>');
  }


  public function encabezado(&$tabla, int $periodo): void
  {
    $titulos_ini = ['No.', 'Estudiante'];
    $anchos_ini = ['style="width: 0.8cm;"', 'style="width: 6.0cm;"'];
    if ($periodo>=2) 
    {
      $lim = $periodo-1;
      for ($i=1; $i<=$lim; $i++)
      { 
        array_push($titulos_ini, "P{$i}");
        array_push($anchos_ini, 'style="width: 0.8cm; text-align: center; vertical-align: middle;"');
      }
      if ($periodo>2) 
      {
        array_push($titulos_ini, "Prom");
        array_push($anchos_ini, 'style="width: 0.8cm; text-align: center; vertical-align: middle;"');
      }
    }

    $titulos_final = [
        "Partici",
        "Tareas",
        "Ev. Oral",
        "Ev. Escri",
        "clase",
        "Actitud",
        "Asist",
        "Final",
        "P.A.",
    ];
    $anchos_final = array_fill(0, 9, 'style="width: 1.5cm;"');

    $titulos_completo = [ ...$titulos_ini, ...$titulos_final];
    $anchos_completo = [ ...$anchos_ini, ...$anchos_final];

    $tabla->setHead(
      $titulos_completo,
      '',
      $anchos_completo,
    );
  }
  

  public function cuerpo(&$tabla, $key, $registro, int $periodo): void
  {  ///estudiante_nombre,asignatura_nombre
    $cols = [
      ($key+1),
      trim($registro->nombre_estudiante),
    ];
    $styles = ['', ''];
    if ($periodo>=2)  // Las notas históricas se agregan desde el 2 periodo
    {
      $lim = $periodo-1;
      $cont_notas = 0;
      $suma_notas = 0;
      for ($i=1; $i<=$lim; $i++) // agregar notas anteriores
      {
        $nombre_col_nota = "nota_final_periodo_{$i}";
        array_push($cols, $registro->$nombre_col_nota);
        array_push($styles, 'style="text-align: center; vertical-align: middle;"');
        $cont_notas += $registro->$nombre_col_nota ? 1: 0;
        $suma_notas += (int)$registro->$nombre_col_nota;
      }
      if ($periodo>2) /// mostrar columna adicional del promedio
      {
        $promedio = ($cont_notas>0) ? round($suma_notas/$cont_notas, 1) : 0;
        array_push($cols, round($promedio, 1) );
        array_push($styles, 'style="text-align: center; vertical-align: middle;"');
      }
    }    
    $cols = [...$cols, ... array_fill(0, 9, '') ];
    $tabla->addRow($cols, '', $styles);
  }


  public function pie(): string
  {
    return '<hr>'.str_repeat('<br>', 2);
  }


}