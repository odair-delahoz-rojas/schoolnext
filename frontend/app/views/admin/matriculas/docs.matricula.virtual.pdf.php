<?php

class SetDocsMatriculaVirtual {
  public function SetDocInfo($pdf, $tit_rep, $clave, $lang) {
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor(sfConfig::get('app_tcpdf_appname'));
      $pdf->SetTitle($tit_rep);
      $pdf->SetSubject('Documentos Matricula Virtual');
      $pdf->SetKeywords(sfConfig::get('app_tcpdf_colegio'), sfConfig::get('app_tcpdf_appname'), $clave);
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $tit_rep, PDF_HEADER_STRING);
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(10, 10, 10);
//      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(25);
//      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      //set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, 35);
//      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      //set some language-dependent strings
      $pdf->setLanguageArray($lang);
      // set font
      $pdf->SetFont('helvetica', '', 10);
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
  }     
}

function DarFormatoVirtual($var, $var2) {
    return (strlen($var)==0) ? $var2 : '<u>'.$var.'</u>' ; 
  }

function nombreMesVirtual($mes){
  $nombres = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 
                 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
  return $nombres[$mes];
}

// BEGIN SCRIPT
function CrearDocsMatriculaVirtual($info, $estudiante) {

require_once(sfConfig::get('sf_lib_dir').'/vendor/tcpdf/config/lang/spa.php');
require_once(sfConfig::get('sf_lib_dir').'/vendor/tcpdf/tcpdf.php');

$representante = strtoupper(dmConfig::get('Ins_Representante'));
$dir_instit = strtoupper(dmConfig::get('inst_direccion'));
$razon_social = strtoupper(dmConfig::get('inst_razon_social'));
$inst_nit = strtoupper(dmConfig::get('inst_NIT'));
$inst_dir = strtoupper(dmConfig::get('inst_direccion'));

$file_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$func = new SetDocsMatriculaVirtual;
$func->SetDocInfo($file_pdf, strtoupper($info["TITULO"]), 'Documentos Matricula Virtual', $l);

$tipo_pag = $info["TIPO_PAG"];

$file_pdf->AddPage();
$codigo_estud = $estudiante['id'];

// 1: CONTRATO 
$acu1 = strlen($estudiante['padre']);
$acu2 = strlen($estudiante['madre']);
$acu3 = strlen($estudiante['acudiente']);

$acu1_id = strlen($estudiante['padre_id']);
$acu2_id = strlen($estudiante['madre_id']);

$deudor      = $estudiante['deudor_nombre'];
$deudor_cc   = $estudiante['deudor_cc'];
$codeudor    = $estudiante['codeudor'];
$codeudor_cc = $estudiante['codeudor_cc'];

$acudientes = '';
if ($acu1>0 && $acu2>0) {
    $acudientes = strtoupper($estudiante['padre']).' y '.strtoupper($estudiante['madre']);
} elseif ($acu1>0) {
    $acudientes = strtoupper($estudiante['padre']);
} elseif ($acu2>0) {
    $acudientes = strtoupper($estudiante['madre']);
}

$pres     = $estudiante['is_prescolar'];
$bas_prim = $estudiante['is_primaria'];
$med_acad = $estudiante['is_media_academica'];
$bas_sec  = $estudiante['is_basica_secundaria'];


$num_matricula   = $estudiante['numero_mat_f'];
$ordinaria = $info["ORDINARIA"];
$valor_pension   = $estudiante->getValorPensionF(0);
$valor_matricula = $estudiante->getValorMatriculaF($ordinaria);
$costo_anual     = $estudiante->getCostoAnualMatriculaF($ordinaria);
$costo_anual_palabras = strtoupper($estudiante->getCostoAnualMatriculaPalabras($ordinaria));

$annio_mat = (date('n')>8) ? date('Y')+1 : date('Y');
$dia_firma = date('d');
$nombre_mes_firma = nombreMesVirtual(date('n'));
$annio_firma = date('Y');

$contrato1 = dmConfig::get('mat_contrato1');
//$contrato1 = dmConfig::get('mat_contrato_alternancia');
//$dir_img   = sfConfig::get('sf_lib_dir').'/vendor/tcpdf/images/'; // Local
$dir_img   = '../../_windsorviejo_schoolnext_private/lib/vendor/tcpdf/images/'; // hosting

$contrato1 = str_replace("\$CONTRATO\$", $num_matricula, $contrato1);
$contrato1 = str_replace("\$IM_ENCAB_RES\$", $dir_img.'logo.png', $contrato1);
$contrato1 = str_replace("\$NOMBRE_ESTUDIANTE\$", strtoupper($estudiante), $contrato1);
$contrato1 = str_replace("\$PRES\$", DarFormatoVirtual($pres, '__'), $contrato1);
$contrato1 = str_replace("\$BPRIM\$", DarFormatoVirtual($bas_prim, '__'), $contrato1);
$contrato1 = str_replace("\$BSEC\$", DarFormatoVirtual($bas_sec, '__'), $contrato1);
$contrato1 = str_replace("\$MEDA\$", DarFormatoVirtual($med_acad, '__'), $contrato1);
$contrato1 = str_replace("\$REPRESENTANTE\$", $representante, $contrato1);
$contrato1 = str_replace("\$ACUDIENTES\$", $acudientes, $contrato1);
$contrato1 = str_replace("\$ANNIO_LECTIVO\$", $annio_mat, $contrato1);
$contrato1 = str_replace("\$COSTO_ANUAL_PALABRA\$", $costo_anual_palabras, $contrato1);
$contrato1 = str_replace("\$COSTO_ANUAL_NUMEROS\$", $costo_anual, $contrato1);
$contrato1 = str_replace("\$VALOR_MATRICULA\$", $valor_matricula, $contrato1);
$contrato1 = str_replace("\$VALOR_CUOTAS\$", $valor_pension, $contrato1);
$contrato1 = str_replace("\$DIA_EXIGIBLE\$", '5 de febrero de '.$annio_mat, $contrato1);
$contrato1 = str_replace("\$DIA_INI_VIGENCIA\$", 1, $contrato1);
$contrato1 = str_replace("\$DIA_FIN_VIGENCIA\$", 30, $contrato1);
$contrato1 = str_replace("\$DIA_FIRMA\$", date('d'), $contrato1);
$contrato1 = str_replace("\$MES_FIRMA\$", $nombre_mes_firma, $contrato1);
$contrato1 = str_replace("\$ANNIO_FIRMA\$", date('Y'), $contrato1);
$file_pdf->writeHTML($contrato1, true, false, true, false, '');

//$file_pdf->lastPage();






// 2: LIBRO DE MATRICULA
$file_pdf->AddPage();
$libro_matricula = dmConfig::get('mat_libro_matricula');

$libro_matricula = str_replace("\$CODIGO_ESTUD\$", 'Código: '.$codigo_estud, $libro_matricula);
$libro_matricula = str_replace("\$IM_ENCAB_RES\$", $dir_img.'encabezado_resol_000293.png', $libro_matricula);
$libro_matricula = str_replace("\$CIUDAD_FECHA\$", DarFormatoVirtual('Valledupar, '.date('d').' de '.$nombre_mes_firma.' de '.date('Y'), '_____________________________________________'), $libro_matricula);
//$libro_matricula = str_replace("\$CIUDAD_FECHA\$", DarFormatoVirtual('Valledupar, '.date('d').' de diciembre de '.date('Y'), '_____________________________________________'), $libro_matricula);
$libro_matricula = str_replace("\$NOMBRE_ESTUDIANTE\$", DarFormatoVirtual($estudiante, '____________________________________________________'), $libro_matricula);
$libro_matricula = str_replace("\$PAIS_NAC\$", DarFormatoVirtual($estudiante->getDatosestud()->getPaisNac(), '_____________'), $libro_matricula);
$libro_matricula = str_replace("\$DEPTO_NAC\$", DarFormatoVirtual($estudiante->getDatosestud()->getDeptoNac(), '_____________'), $libro_matricula);
$libro_matricula = str_replace("\$CIUDAD_NAC\$", DarFormatoVirtual($estudiante->getDatosestud()->getCiudadNac(), '_____________'), $libro_matricula);
$libro_matricula = str_replace("\$ANNIO_NAC\$", DarFormatoVirtual(date('Y', strtotime($estudiante->getFechaNac())) , '_______'), $libro_matricula);
$libro_matricula = str_replace("\$MES_NAC\$", DarFormatoVirtual(date('m', strtotime($estudiante->getFechaNac())), '_______'), $libro_matricula);
$libro_matricula = str_replace("\$DIA_NAC\$", DarFormatoVirtual(date('d', strtotime($estudiante->getFechaNac())), '_______'), $libro_matricula);

$edad = substr($estudiante->getEdad(), 0, stripos($estudiante->getEdad(), ','));
$libro_matricula = str_replace("\$EDAD\$", DarFormatoVirtual($edad, '_______'), $libro_matricula);
$libro_matricula = str_replace("\$IDENTIFICACION\$", DarFormatoVirtual($estudiante->getDocumento(), '_______________'), $libro_matricula);
$libro_matricula = str_replace("\$RELIGION\$", DarFormatoVirtual($estudiante->getDatosestud()->getReligion(), '______________'), $libro_matricula);
$libro_matricula = str_replace("\$DIRECCION\$", DarFormatoVirtual($estudiante->getDireccion(), '________________________________'), $libro_matricula);
$libro_matricula = str_replace("\$TELEFONO\$", DarFormatoVirtual($estudiante->getTelefono1(), '____________'), $libro_matricula);
$libro_matricula = str_replace("\$GRADO_MAT\$", DarFormatoVirtual($estudiante->getGrado()->getNombre(), '____________'), $libro_matricula);

$libro_matricula = str_replace("\$PADRE\$", DarFormatoVirtual($estudiante['padre'], str_repeat("_", 28)), $libro_matricula);
$libro_matricula = str_replace("\$ID_PADRE\$", DarFormatoVirtual($estudiante['padre_id'], str_repeat("_", 16)), $libro_matricula);
$libro_matricula = str_replace("\$OCUPA_PADRE\$", DarFormatoVirtual($estudiante['padre_ocupa'], str_repeat("_", 22)), $libro_matricula);
$libro_matricula = str_replace("\$TRAB_PADRE\$", DarFormatoVirtual($estudiante['padre_lugar_tra'], str_repeat("_", 20)), $libro_matricula);
$libro_matricula = str_replace("\$TSERV_PADRE\$", DarFormatoVirtual($estudiante['padre_tiempo_ser'], str_repeat("_", 11)), $libro_matricula);
$libro_matricula = str_replace("\$TEL_OF_PADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getPadreTel_1(), str_repeat("_", 12)), $libro_matricula);
$libro_matricula = str_replace("\$CEL_PADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getPadreTel_2(), str_repeat("_", 14)), $libro_matricula);
$libro_matricula = str_replace("\$EMAIL_PADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getPadreEmail(), str_repeat("_", 21)), $libro_matricula);

$libro_matricula = str_replace("\$MADRE\$", DarFormatoVirtual($estudiante['madre'], str_repeat("_", 28)), $libro_matricula);
$libro_matricula = str_replace("\$ID_MADRE\$", DarFormatoVirtual($estudiante['madre_id'], str_repeat("_", 16)), $libro_matricula);
$libro_matricula = str_replace("\$OCUPA_MADRE\$", DarFormatoVirtual($estudiante['madre_ocupa'], str_repeat("_", 22)), $libro_matricula);
$libro_matricula = str_replace("\$TRAB_MADRE\$", DarFormatoVirtual($estudiante['madre_lugar_tra'], str_repeat("_", 20)), $libro_matricula);
$libro_matricula = str_replace("\$TSERV_MADRE\$", DarFormatoVirtual($estudiante['madre_tiempo_ser'], str_repeat("_", 11)), $libro_matricula);
$libro_matricula = str_replace("\$TEL_OF_MADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getMadreTel_1(), str_repeat("_", 12)), $libro_matricula);
$libro_matricula = str_replace("\$CEL_MADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getMadreTel_2(), str_repeat("_", 14)), $libro_matricula);
$libro_matricula = str_replace("\$EMAIL_MADRE\$", DarFormatoVirtual($estudiante->getDatosestud()->getMadreEmail(), str_repeat("_", 21)), $libro_matricula);

$tipo_acudi = $estudiante->getDatosestud()->getTipoAcudi();
switch (strtoupper($tipo_acudi)) {
    case 'PADRE':
        $acudi = 'Padre'; $dir_acudi=''; $tel_acudi=''; $email_acudi=''; $tel_acudi2='';
        $cedente    = strtoupper($estudiante->getDatosestud()->getPadre());
        $cedente_cc = $estudiante->getDatosestud()->getPadreId();
        break;
    case 'MADRE':
        $acudi = 'Madre'; $dir_acudi=''; $tel_acudi=''; $email_acudi=''; $tel_acudi2='';
        $cedente    = $estudiante->getDatosestud()->getMadre();
        $cedente_cc = $estudiante->getDatosestud()->getMadreId();
        break;
    case 'OTRO':
        $acudi       = $estudiante->getDatosestud()->getAcudiente(); 
        $dir_acudi   = $estudiante->getDatosestud()->getAcudiDir(); 
        $tel_acudi   = $estudiante->getDatosestud()->getAcudiTel_1(); 
        $tel_acudi2  = $estudiante->getDatosestud()->getAcudiTel_2(); 
        $email_acudi = $estudiante->getDatosestud()->getAcudiEmail();
        $cedente     = $estudiante->getDatosestud()->getAcudiente();
        $cedente_cc  = $estudiante->getDatosestud()->getAcudiId();
        break;
    default:
        $acudi = ''; $dir_acudi=''; $tel_acudi=''; $email_acudi=''; $tel_acudi2='';
        $cedente     = '';
        $cedente_cc  = '';
}

$libro_matricula = str_replace("\$ACUDIENTE\$", DarFormatoVirtual($acudi, str_repeat("_", 24)), $libro_matricula);
$libro_matricula = str_replace("\$DIR_ACUDIENTE\$", DarFormatoVirtual($dir_acudi, str_repeat("_", 20)), $libro_matricula);
$libro_matricula = str_replace("\$TEL_ACUDIENTE1\$", DarFormatoVirtual($tel_acudi, str_repeat("_", 12)), $libro_matricula);
$libro_matricula = str_replace("\$TEL_ACUDIENTE2\$", DarFormatoVirtual($tel_acudi2, str_repeat("_", 12)), $libro_matricula);
$libro_matricula = str_replace("\$EMAIL_ACUDIENTE\$", DarFormatoVirtual($email_acudi, str_repeat("_", 21)), $libro_matricula);

$si = (strlen($estudiante->getDatosestud()->getAnteInstit())>0) ? true : false ;
$libro_matricula = str_replace("\$SI\$", DarFormatoVirtual((($si) ? 'X' : ''), str_repeat("_", 4)), $libro_matricula);
$libro_matricula = str_replace("\$NO\$", DarFormatoVirtual((($si) ? '' : 'X'), str_repeat("_", 4)), $libro_matricula);
$libro_matricula = str_replace("\$PLANTEL\$", DarFormatoVirtual($estudiante->getDatosestud()->getAnteInstit(), str_repeat("_", 33)), $libro_matricula);
$libro_matricula = str_replace("\$GRADO_PLANTEL\$", DarFormatoVirtual($estudiante->getDatosestud()->getGrado()->getNombre(), str_repeat("_", 11)), $libro_matricula);
$libro_matricula = str_replace("\$DIR_PLANTEL\$", DarFormatoVirtual($estudiante->getDatosestud()->getAnteInstitDir(), str_repeat("_", 33)), $libro_matricula);
$libro_matricula = str_replace("\$TEL_PLANTEL\$", DarFormatoVirtual($estudiante->getDatosestud()->getAnteInstitTel(), str_repeat("_", 14)), $libro_matricula);
$libro_matricula = str_replace("\$FECHA_RET_PLANTEL\$", DarFormatoVirtual($estudiante->getDatosestud()->getAnteFechaRet(), str_repeat("_", 14)), $libro_matricula);
$libro_matricula = str_replace("\$IM_PIE_RES\$", $dir_img.'logo.png', $libro_matricula);

$file_pdf->writeHTML($libro_matricula, true, false, true, false, '');



/*

// 3: PAGRÉ:

if ($tipo_pag=='S') {
  # PLANTILLA PAGARÃ‰ SIN CODEUDOR (DEBEN SALIR DOS COPIAS)
  $mat_pagare_sin_cod = dmConfig::get('mat_pagare_sin_cod');
  $mat_pagare_sin_cod = str_replace("\$CONTRATO\$", $num_matricula, $mat_pagare_sin_cod);
  $mat_pagare_sin_cod = str_replace("\$RAZON_SOCIAL\$", $razon_social, $mat_pagare_sin_cod);
  $mat_pagare_sin_cod = str_replace("\$DEUDOR\$", $deudor, $mat_pagare_sin_cod);
  $mat_pagare_sin_cod = str_replace("\$CC_DEUDOR\$", $deudor_cc, $mat_pagare_sin_cod);
  $mat_pagare_sin_cod = str_replace("\$VALOR_DEUDA\$", $costo_anual, $mat_pagare_sin_cod);
  $mat_pagare_sin_cod = str_replace("\$CIUDAD_DIR\$", 'Valledupar, '.$inst_dir, $mat_pagare_sin_cod);

  // ========================================
  // CARTA DE INSTRUCCIONES PARA ESTE PAGARÃ‰
  $mat_carta_inst_pag_sin_cod = dmConfig::get('mat_carta_inst_pag_sin_cod');
  
  $mat_carta_inst_pag_sin_cod = str_replace("\$CONTRATO\$", $num_matricula, $mat_carta_inst_pag_sin_cod);
  $mat_carta_inst_pag_sin_cod = str_replace("\$DEUDOR\$", $deudor, $mat_carta_inst_pag_sin_cod);
  $mat_carta_inst_pag_sin_cod = str_replace("\$RAZON_SOCIAL\$", $razon_social, $mat_carta_inst_pag_sin_cod);
  $mat_carta_inst_pag_sin_cod = str_replace("\$INSTIT_NIT\$", $inst_nit, $mat_carta_inst_pag_sin_cod);
  $mat_carta_inst_pag_sin_cod = str_replace("\$CIUDAD_FECHA\$", DarFormatoVirtual('Valledupar, '.date('d').' de '.$nombre_mes_firma.' de '.date('Y'), str_repeat("_", 45)), $mat_carta_inst_pag_sin_cod);
  
  
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_pagare_sin_cod, true, false, true, false, '');
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_carta_inst_pag_sin_cod, true, false, true, false, '');
  
  //$file_pdf->AddPage();
  //$file_pdf->writeHTML($mat_pagare_sin_cod, true, false, true, false, '');
  //$file_pdf->AddPage();
  //$file_pdf->writeHTML($mat_carta_inst_pag_sin_cod, true, false, true, false, '');
  
} else {
  # PLANTILLA PAGARÃ‰ CON CODEUDOR (DEBEN SALIR DOS COPIAS)
  $mat_pagare_con_cod = dmConfig::get('mat_pagare_con_cod');
  $mat_pagare_con_cod = str_replace("\$CONTRATO\$", $num_matricula, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$RAZON_SOCIAL\$", $razon_social, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$DEUDOR\$", $deudor, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$CC_DEUDOR\$", $deudor_cc, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$CODEUDOR\$", $codeudor, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$CC_CODEUDOR\$", $codeudor_cc, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$VALOR_DEUDA\$", $costo_anual, $mat_pagare_con_cod);
  $mat_pagare_con_cod = str_replace("\$CIUDAD_DIR\$", 'Valledupar, '.$inst_dir, $mat_pagare_con_cod);
  
  // ========================================
  // CARTA DE INSTRUCCIONES PARA ESTE PAGARÃ‰
  $mat_carta_inst_pag_con_cod = dmConfig::get('mat_carta_inst_pag_con_cod');
  
  $mat_carta_inst_pag_con_cod = str_replace("\$CONTRATO\$", $num_matricula, $mat_carta_inst_pag_con_cod);
  $mat_carta_inst_pag_con_cod = str_replace("\$DEUDOR\$", $deudor, $mat_carta_inst_pag_con_cod);
  $mat_carta_inst_pag_con_cod = str_replace("\$CODEUDOR\$", $codeudor, $mat_carta_inst_pag_con_cod);
  $mat_carta_inst_pag_con_cod = str_replace("\$RAZON_SOCIAL\$", $razon_social, $mat_carta_inst_pag_con_cod);
  $mat_carta_inst_pag_con_cod = str_replace("\$INSTIT_NIT\$", $inst_nit, $mat_carta_inst_pag_con_cod);
  $mat_carta_inst_pag_con_cod = str_replace("\$CIUDAD_FECHA\$", DarFormatoVirtual('Valledupar, '.date('d').' de '.$nombre_mes_firma.' de '.date('Y'), str_repeat("_", 45)), $mat_carta_inst_pag_con_cod);
  
  
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_pagare_con_cod, true, false, true, false, '');
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_carta_inst_pag_con_cod, true, false, true, false, '');
  
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_pagare_con_cod, true, false, true, false, '');
  $file_pdf->AddPage();
  $file_pdf->writeHTML($mat_carta_inst_pag_con_cod, true, false, true, false, '');

}

*/




/*

  // ===========================================================
  // CARTA DE AUTORIZACION DE DERECHOS DE IMAGEN PERSONAL
  $derechos_imagen_personal = dmConfig::get('derechos_imagen_personal');
  $derechos_imagen_personal = str_replace("\$IM_ENCAB_RES\$", $dir_img.'encabezado_resol_000293.png', $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$CEDENTE_NOMBRE\$", $cedente, $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$CEDENTE_CC\$", $cedente_cc, $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$ESTUDIANTE\$", $estudiante, $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$ESTUDIANTE_ID\$", $estudiante['documento'], $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$DIA\$", $dia_firma, $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$MES_LETRA\$", $nombre_mes_firma, $derechos_imagen_personal);
  $derechos_imagen_personal = str_replace("\$ANNIO\$", $annio_firma, $derechos_imagen_personal);
  
  $file_pdf->AddPage();
  $file_pdf->writeHTML($derechos_imagen_personal, true, false, true, false, '');
  
  */


  $file_pdf->lastPage();

  $nombre_archivo = str_replace(" ", "-", strtolower($info["TITULO"]).'_'.$estudiante);
  $file_pdf->Output($nombre_archivo.'.pdf', 'D');

}

// END SCRIPT