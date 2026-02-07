<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */
require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfRegistros extends Mpdf 
{
  
  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);

    $DoliK = new DoliConst();
    $link_web_page = $DoliK->getValue('MAIN_INFO_SOCIETE_WEB') ?? '';
    $nombre_instituto = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '';
    
    $this->SetTitle('REGISTRO DE OBSERVACIONES DE ESTUDIANTE');
    $this->SetAuthor($nombre_instituto);
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetSubject('REGISTRO DE OBSERVACIONES DE ESTUDIANTE');
    $this->SetKeywords('registros, estudiantes');

    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(9);
    $this->SetMargins(15, 5, 30 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.$link_web_page.'" target="_blank">
             <img src="'.PUBLIC_PATH.'img/'.LOGO.'" alt="Logo" height="40"> </a>';
    
    $this->SetHTMLHeader("<div style=\"text-align: center; font-weight: bold;\"> $logo </div>");
    //<td width="33%">{DATE j-m-Y}</td>
    $this->SetHTMLFooter('
    <table width="100%">
      <tr>
        <td width="33%">SchoolNEXT>></td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">Registro de Observaciones</td>
      </tr>
    </table>');
  }


  public function encabezado(&$tabla): void
  {
    $tabla->setHead(
      [
        'No.',
        'Estudiante',
        "Nota",
        "Prom",
        "Partici",
        "Tareas",
        "Ev. Oral",
        "Ev. Escri",
        "clase",
        "Actitud",
        "Final",
        "P.A.",
        "Asist",
      ],
      '',
      ['style="width: 0.5cm;"', 'style="width: 6cm;"', 'style="width: 0.8cm;"']
    );
  }
  

  public function cuerpo(&$tabla, $key, $registro): void
  {  ///estudiante_nombre,asignatura_nombre
    $cols = [
      ($key+1),
      $registro->estudiante_nombre,
      '',
      "",
      "",
      "",
      "",
      "",
      "",
      "",
      "",
      "",
      "",
    ];
    $tabla->addRow($cols);
  }


  public function pie(): string
  {
    return '<hr>'.str_repeat('<br>', 2);
  }

  

}