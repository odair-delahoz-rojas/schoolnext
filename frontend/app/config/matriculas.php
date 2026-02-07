<?php
$year = date('Y');
$month = date('m');

return [
  'matriculas'   => 1,
  'matriculas_fecha_ini' => '',
  'mostrar_fecha_fin'    => '',
  'annio_mat'     => (($month>=11) ? $year+1 : $year),

  'windsor' => [
    'num_archivos' => 7,

    'file_1' => 'https://www.pensioneswin.tecnorobotica.com/windsor/',
    'file_1_titulo' => 'Recibo de Pago de Matrícula',

    'file_2' => FILE_DOWNLOAD_PATH.'matriculas/windsor_formato_pagare.pdf',
    'file_2_titulo' => 'Pagaré',
    
    'file_3' => FILE_DOWNLOAD_PATH.'matriculas/windsor_formato_instruccion_pagare.pdf',
    'file_3_titulo' => 'Carta de Instrucciones del Pagaré',

    'file_4' => FILE_DOWNLOAD_PATH.'matriculas/windsor_formato_actualizacion.pdf',
    'file_4_titulo' => 'Formato de Consulta y Reporte en Centrales de Riesgo',

    'file_5' => FILE_DOWNLOAD_PATH.'matriculas/windsor_formulario_simpade_2024.pdf',
    'file_5_titulo' => 'Formulario SIMPADE [Min de Educación]',
    
    'file_6'  => '',
    'file_6_titulo'  => 'Recibo de Pago del 50% del Curso PRE-ICFES <br> --> solo para los grados 9°, 10° y 11°',
    
    'file_7' => FILE_DOWNLOAD_PATH.'matriculas/windsor_encuesta_movilidad_escolar.pdf',
    'file_7_titulo' => 'Encuesta Movilidad Escolar [Agencia Nacional de Seguridad Vial]',
  ],

  'santarosa' => [
    'num_archivos' => 0,

    'file_1' => '',
    'file_1_titulo' => '',

    'file_2' => '',
    'file_2_titulo' => '',
    
    'file_3' => '',
    'file_3_titulo' => '',

    'file_4' => '',
    'file_4_titulo' => '',

    'file_5' => '',
    'file_5_titulo' => '',
    
    'file_6'  => '',
    'file_6_titulo'  => '',
    
    'file_7' => '',
    'file_7_titulo' => '',

  ],

];
