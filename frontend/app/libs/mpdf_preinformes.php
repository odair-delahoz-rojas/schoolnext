<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfPreinformes extends Mpdf {

  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);
    
    $DoliK = new DoliConst();
    $link_web_page = $DoliK->getValue('MAIN_INFO_SOCIETE_WEB') ?? '';
    $nombre_instituto = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '';


    $this->SetSubject('PREINFORME ACADÉMICO');
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor($nombre_instituto);
    $this->SetTitle('PREINFORME ACADÉMICO');
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(10);
    $this->SetMargins(20, 15, 40 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.$link_web_page.'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/'.Config::get('institutions.'.INSTITUTION_KEY.'.logo'). '" alt="Logo" height="60"> </a>';

    $logo2 = '<a href="'.$link_web_page.'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/'.Config::get('institutions.'.INSTITUTION_KEY.'.logo_resolucion'). '" alt="Logo" height="60"> </a>';
    
      $this->SetHTMLHeader("<table width=\"100%\">
        <tr>
            <td width=\"33%\" style=\"text-align: left;\"><h4>{$this->title}</h4></td>
            <td width=\"33%\" align=\"center\">{$logo}</td>
            <td width=\"33%\" style=\"text-align: right;\">{$logo2}</td>
        </tr>
    </table>");

/* 
    $this->SetHTMLHeader("
    <div style=\"text-align: center; font-weight: bold;\">
        $logo <br> <h3>$this->title</h3>
    </div>");
 */


    //<td width="33%">{DATE j-m-Y}</td>
    //<td width="33%" align="center">{PAGENO}/{nbpg}</td>
    $this->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center"></td>
            <td width="33%" style="text-align: right;"></td>
        </tr>
    </table>');
    
  }


  public function encabezadoBloqueBoletines(array $Params = []): string 
  {
    [ $estudiante_nombre, $periodo, $annio, $salon ] = $Params;
    
    $col11 = '<b>ALUMNO:</b>';
    $col12 = '<b>'.strtoupper($estudiante_nombre) .'</b>';
    $col13 = "<b>PERIODO 0$periodo - $annio</b>";
    
    $col21 = '<b>GRADO:</b>';
    $col22 = '<b>'.strtoupper($salon).'</b>';
    $col23 = '';
    
    $head = new OdaTable(_attrs: 'class="w3-rounded" bgcolor="#87CEEB" cellspacing="5" cellpadding="5" border="0" width="100%"');
    $head->addRow([ $col11, $col12, $col13 ], attrs_td: ['','colspan'=>3, 'colspan'=>2]);
    $head->addRow([ $col21, $col22, $col23 ], attrs_td: ['','colspan'=>3, 'colspan'=>2]);
    return $head.'<br/>';
  }

  
  public function pieBloqueBoletines(array $Params = []): string 
  {
    [ $img_tabla_rango, $firma_director, $nombre_director ] = $Params;
    
    $col1 = $img_tabla_rango;
    $col3 = $firma_director.'<br><b>DIRECTOR DE GRUPO</b><br>'.strtoupper($nombre_director);
    $foot = new OdaTable('style="width: 100%;"');
    $foot->addRow( [$col1, '', $col3], attrs_td: ['style="width: 33%;"', 'style="width: 33%;"']);
    
    return str_repeat('<br>', 2) .$foot;
  }
  
}