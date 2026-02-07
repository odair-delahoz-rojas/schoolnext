<?php
/**
  * Controlador
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class SeguimientosController extends ScaffoldController
{
  function guardarSeguimientos(int $salon_id, int $asignatura_id) {
    $this->page_action = "Guardar Seguimientos";
    $redirect = "docentes/listNotas/$asignatura_id/$salon_id";
    //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');

    try
    {
      $post_name = 'seguimientos';
      if (!Input::hasPost($post_name)) {
        OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$this->nombre_post</b>, no lleg車");
      }
      if (Input::hasPost($post_name)) {
        $Post = Input::post($post_name); // vienen todos los registro mezclados
        
        $notas = [];
        foreach ($Post as $field_name => $value)
        {
          $codigo_id = (int)substr($field_name, strripos($field_name, "_") + 1);
          if ($codigo_id>0) { // evitar que se cuele una variable que no sea del registro de calificacion (formato "_$id")
            $notas[$codigo_id][$field_name] = $value;

            if (str_starts_with($field_name, 'profesor_id')) {
              if ( (is_null($value) or (0==$value)) and (1!=$this->user_id)) {
                $notas[$codigo_id][$field_name] = $this->user_id; // reemplace el valor por el usuario actual
              }
            }
            if (str_starts_with($field_name, 'asi_fecha_entrega')) {
              if ( (is_null($value) or ('0000-00-00'==$value)) ) {
                $notas[$codigo_id][$field_name] = ''; // reemplace el valor por el usuario actual
              }
            }
          } // else { OdaLog::debug("excluidos $field_name"); }
        }        
        
        // ----------------------------------------------------------------
        $INDEX_INDCI_INI = 21; $INDEX_INDCI_FIN = 30;  // INDICADORES DE PLANES DE APOYO 31=>40
        foreach ($notas as $id => $registro) {
           // PREPARA EL REGISTRO INDIVIDUAL DE NOTAS
          $data_temp = [];
          foreach ($registro as $field_name_id => $value_temp)
          {
            $long = strlen($field_name_id) - (strlen($id)+1);
            $field_name = substr($field_name_id,0,$long);
            $data_temp[$field_name] = "$value_temp";
            if (str_starts_with($field_name_id, 'profesor_id') & (0==$value_temp) & (1!=$this->user_id) )
            {
              $data_temp[$field_name] = $this->user_id;
            }
          }          
          // ORGANIZA LOS INDICADORES
          $cnt_num_ind = 0;
          $data_indicadores = [];
          $data = [];
          foreach ($data_temp as $key => $value)
          { 
            if (str_starts_with($key, 'i')) // campos de indicadores
            {
              if (strlen($value)>0) // indicadores validos
              {
                $index = 'i'.($INDEX_INDCI_INI + $cnt_num_ind);
                $data_indicadores[$index] = $value;
                $cnt_num_ind +=1;
              }
            }
            else  // campos que no son indicadores
            {
              $data[$key] = $value;
            }
          }
          $data_indicadores = array_unique($data_indicadores); // Elimina indicadores duplicados
          sort($data_indicadores, SORT_NUMERIC); // ordena los indicadores
          $cnt_data_indic = count($data_indicadores); // cuenta de los indicadores que se ingresaron realmente
          // GUARDA LOS INDICADORES REALES Y EN ORDEN
          $indic_i = $INDEX_INDCI_INI;
          foreach ($data_indicadores as $value)
          { 
            $index = "i{$indic_i}";
            $data[$index] = $value;
            $indic_i +=1;
          }
          // COMPLETA LOS INDICADORES EN BLANCO hasta $INDEX_INDCI_FIN
          $indic_blank = $indic_i;
          for ($i=$indic_blank; $i<=$INDEX_INDCI_FIN; $i++)
          {
            $index = "i{$i}";
            $data[$index] = '';
          }
          // CALCULA EL ESTADO DEL REGISTRO (PARA LOS PDF)
          $cnt_ok = 0;
          $cnt_ok += ($cnt_data_indic>0) ? 1 : 0 ; // #1
          if ($data['asi_fecha_entrega'])
          {
            $month = (int)date('m', strtotime($data['asi_fecha_entrega']) );
            $day   = (int)date('d', strtotime($data['asi_fecha_entrega']) );
            $year  = (int)date('Y', strtotime($data['asi_fecha_entrega']));
            $cnt_ok += (checkdate($month, $day, $year)) ? 1 : 0 ; // #2
          }
          $cnt_ok += (strlen($data['asi_desempeno'])>0) ? 1 : 0 ; // #3
          //$cnt_ok += (strlen($data['asi_calificacion'])>0) ? 1 : 0 ; // #4
          $cnt_ok += (strlen($data['asi_activ_profe'])>0) ? 1 : 0 ; // #5
          $cnt_ok += (strlen($data['asi_activ_estud'])>0) ? 1 : 0 ; // #6
          // AGREGA CAMPOS ADICIONALES (DE CONTROL)
          $adicionales =[];
          $adicionales['is_asi_validar_ok']= $cnt_ok;
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;
          // UPDATE SQL PURO
          $Modelo = (new Seguimientos());
          $DQL = new OdaDql('Seguimientos');
          $DQL->update($data)
              ->addUpdate($adicionales)
              ->where("t.id=?")
              ->setParams([$id])
              ->execute();
        }
      }

    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }

    return Redirect::to($redirect);
  }

    
  public function exportSeguimientosRegistroPdf(string $seguimientno_uuid): void {
    try
    {      
      $Seg = (new Seguimientos)::getByUUID($seguimientno_uuid);
      $this->data = $Seg;
      $Estud = (new Estudiante)::get($Seg->estudiante_id);
      $this->arrData['Estud'] = $Estud;
      $this->arrData['Periodo'] = $Seg->periodo_id;
      $this->arrData['Asign']   = (new Asignatura)::get($Seg->asignatura_id);
      $this->arrData['Salon']   = (new Salon)::get($Seg->salon_id);
      $this->arrData['Grado']   = (new Grado)::get($Seg->grado_id);
      $this->arrData['Docentes'] = [];
      foreach ((new Usuario)->getDocentes() as $empleado)
      {
        $this->arrData['Docentes'][$empleado->id] = $empleado;
      }
      $Indicadores = (new Indicador())->getByPeriodoGrado($Seg->periodo_id, (int)$Seg->grado_id);
      foreach ($Indicadores as $key => $indic)
      {
        $this->arrData [ 'Indicadores' ] [ $indic->asignatura_id ] [ $indic->codigo ] ['concepto'] = trim($indic->concepto);
      }
      $this->file_tipo  = 'Seguimientos Intermedios';
      $this->file_name  = OdaUtils::getSlug("seguim-intermedios-{$Estud}-periodo-{$Seg->periodo_id}");
      $this->file_title = "$this->file_tipo de $Estud";
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    
    View::select(view: "seguimientos.pdf", template: null);
  }



}