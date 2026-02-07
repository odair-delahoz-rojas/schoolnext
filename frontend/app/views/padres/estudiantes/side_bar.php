<?php
  try {
    
    echo OdaForm::hidden(field: 'ver_matriculas', 
      value: Config::get('padres.mostrar_matriculas'));
    
    echo OdaForm::hidden(field: 'ver_seguimientos', 
      value: Config::get('padres.mostrar_seguimientos'));

    echo OdaForm::hidden(field: 'ver_preinformes', 
      value: Config::get('padres.mostrar_preinformes'));

    echo OdaForm::hidden(field: 'ver_boletines', 
      value: Config::get('padres.mostrar_boletines'));

    echo OdaForm::hidden(field: 'ver_planes_apoyo', 
      value: Config::get('padres.mostrar_planes_apoyo'));

    echo OdaForm::hidden(field: 'ver_reconocimientos', 
      value: Config::get('padres.mostrar_reconocimientos'));


    echo OdaForm::hidden(field: 'periodo_boletines',
      value: Config::get('padres.periodo_boletines'));
      
    echo OdaForm::hidden(field: 'periodo_planes_apoyo',
     value: Config::get('padres.periodo_planes_apoyo'));
    
    echo OdaForm::hidden(field: 'periodo_preinformes',
     value: Config::get('padres.periodo_preinformes'));

    echo OdaForm::hidden(field: 'periodo_seguimientos',
     value: Config::get('padres.periodo_seguimientos'));
    
    $periodo = $arrData['periodo'];
    $buttons = [];
    if (count($data)>0) {
      foreach ($data as $key => $estud) {
        $buttons[$key] = ['caption'=>$estud->getFotoCircle().'<br>'.$estud->nombres, 'action'=>"traer_data($estud->id, '$estud->salon_nombre', $periodo)"];
      }
      return OdaTags::buttonBars(arrButtons: $buttons);
    }
    
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }

?>
