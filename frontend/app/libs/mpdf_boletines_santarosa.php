<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfBoletinesSantarosa extends Mpdf 
{
  private string $bgcolor='';
  private string $color='';

  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);    

    $DoliK = new DoliConst();
    $link_web_page = $DoliK->getValue('MAIN_INFO_SOCIETE_WEB') ?? '';
    $nombre_instituto = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '';
    $resolucion = $DoliK->getValue('MAIN_INFO_SIREN') ?? '';
    
    //$annio = $DoliK->getValue('SCHOOLNEXTACADEMICO_ANNIO_ACTUAL') ?? '';
    //$periodo = $DoliK->getValue('SCHOOLNEXTACADEMICO_PERIODO_ACTUAL') ?? '';

    $this->SetSubject('INFORME ACADEMICO');
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor($nombre_instituto);
    $this->SetTitle('INFORME ACADEMICO'); // no puede llevar tilde
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(10);
    $this->SetMargins(15, 15, 34);
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';
    
    $img_escudo = '<img src="'.PUBLIC_PATH.'img/escudo_co.jpg" alt="Escudo" height="60">';
    $escudo = "<a href=\"{$link_web_page}\" target=\"_blank\">{$img_escudo}</a>";

    $img_branding = '<img src="'.PUBLIC_PATH.'img/logo_brand_santarosa.png" alt="Escudo" height="60">';
    $branding = "<a href=\"{$link_web_page}\" target=\"_blank\">{$img_branding}</a>";

    $this->bgcolor = '#C03F2B';
    $this->color = '#FEF3CA';
    
    //Año Lectivo: {$annio} Periodo: {$periodo}";

    $texto_central = "
    {$nombre_instituto}<br/>
    <small>{$resolucion}</small><br/>
    INFORME DE DESEMPEÑO ACADEMICO<br/>";
    
    $this->SetHTMLHeader("
      <table width=\"100%\">
        <tr>
          <td width=\"20%\" style=\"text-align: left;\">{$branding}</td>
          <td width=\"60%\" style=\"text-align: center; font-weight: bold; color: {$this->bgcolor} \">{$texto_central}</h3></td>
          <td width=\"20%\" style=\"text-align: right;\">{$escudo}</td>
        </tr>
      </table>");

    $this->SetHTMLFooter('
      <table width="100%">
        <tr>
          <td width="33%"></td>
          <td width="33%" align="center">{PAGENO}/{nbpg}</td>
          <td width="33%" style="text-align: right;"></td>
        </tr>
      </table>');
  }

  public function encabezadoBloqueBoletines(array $Params = []): string 
  {
    [ $estudiante_nombre, $salon, $puesto, $promedio, $annio, $periodo ] = $Params;
    $tit_alumno = '<b>'.strtoupper($estudiante_nombre).' ['.strtoupper($salon).']</b>';
    $tit_periodo = "<b>{$annio} Periodo {$periodo}</b>";
    $tit_puesto = ($puesto) ? "<b>PUESTO: {$puesto}</b>" : '';
    $tit_promedio= ($promedio) ? "<b>PROMEDIO: {$promedio}</b>" : '';
    $head = new OdaTable(_attrs: 'class="w3-rounded" color="'.$this->color.'" bgcolor="'.$this->bgcolor.'" cellspacing="5" cellpadding="5" border="0" width="100%"');
    $head->addRow([$tit_alumno, $tit_periodo, $tit_puesto, $tit_promedio]);
    return $head;
  }

  public function encabezadoBloqueBoletinesAntes(array $Params = []): string 
  {
    [ $estudiante_nombre, $salon, $puesto, $promedio, $annio, $periodo ] = $Params;
    $tit_alumno = '<b>ALUMNO: '.strtoupper($estudiante_nombre).'</b>';
    $tit_grado = '<b>GRADO: '.strtoupper($salon).'</b>';
    $tit_puesto = ($puesto) ? "<b>PUESTO: {$puesto}</b>" : '';
    $tit_promedio= ($promedio) ? "<b>PROMEDIO: {$promedio}</b>" : '';
    $tit_annio = "<b>Año: {$annio}</b>";
    $tit_periodo = "<b>Periodo: {$periodo}</b>";
    $head = new OdaTable(_attrs: 'class="w3-rounded" color="'.$this->color.'" bgcolor="'.$this->bgcolor.'" cellspacing="5" cellpadding="5" border="0" width="100%"');
    $head->addRow([ $tit_alumno, $tit_annio, $tit_periodo], attrs_td: ['colspan'=>'3', 'colspan'=>'1', 'colspan'=>'1']);
    $head->addRow([ $tit_grado, ' ', $tit_puesto, ' ', $tit_promedio ], attrs_td: ['colspan'=>'1', 'colspan'=>'1', 'colspan'=>'1', 'colspan'=>'1', 'colspan'=>'1' ]);
    return $head;
  }
  
  public function pieBloqueBoletines(array $Params = []): string 
  {
    [ $img_tabla_rango, $firma_director, $nombre_director ] = $Params;    
    $col1 = $img_tabla_rango;
    $col3 = $firma_director.'<br><b>DIRECTOR DE GRUPO</b><br>'.strtoupper($nombre_director);
    $foot = new OdaTable('style="width: 100%;"');
    $foot->addRow( [$col1, '', $col3], attrs_td: ['style="width: 33%;"', 'style="width: 33%;"']);
    return str_repeat('<br>', 1) .$foot;
  }
  
}