<?php
/**
 * Creación de Archivos PDF con mPDF
 * @category   SchoolNext
 * @package    Libs
 */

require_once VENDOR_PATH . 'autoload.php';
use Mpdf\Mpdf;

class MpdfDocsMatricula extends Mpdf {
  
  public function __construct(array $config = [], $container = null) 
  {
    parent::__construct($config, $container);
    
    $DoliK = new DoliConst();
    $link_web_page = $DoliK->getValue('MAIN_INFO_SOCIETE_WEB') ?? '';
    $nombre_instituto = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '';

    $this->SetSubject('DOCUMENTOS DE MATRICULA');
    $this->SetCreator(APP_NAME.' '.Config::get('config.construxzion.name'));
    $this->SetAuthor($nombre_instituto);
    $this->SetTitle('DOCUMENTOS DE MATRICULA');
    $this->SetDefaultFont('helvetica');
    $this->SetDefaultFontSize(10);
    $this->SetMargins(20, 10, 48 );
    $this->SetDisplayMode('fullpage');
    $this->watermark_font = 'DejaVuSansCondensed';

    $logo = '<a href="'.$link_web_page.'" target="_blank">
      <img src="'.PUBLIC_PATH.'img/'.Config::get('institutions.'.INSTITUTION_KEY.'.logo').'" alt="Logo" height="40"> </a>';
    $this->SetHTMLHeader("
      <div style=\"text-align: center; font-weight: bold;\">
        $logo <br> <h3>$this->title</h3>
      </div>"
    );

    $this->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;"></td>
        </tr>
    </table>');
  }

}