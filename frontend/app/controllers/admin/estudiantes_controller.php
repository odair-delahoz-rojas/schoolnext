<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudiantesController extends ScaffoldController
{

  public function uploadFotosEstudiantes(): void 
  {
    //header("Content-Type: application/json");
    $uploadDir = IMG_UPLOAD_PATH . "tmp/";
    if (!is_dir($uploadDir)) 
    {
      mkdir($uploadDir, 0775, true);
    }
    $response = [];
    if (!empty($_FILES['files'])) 
    {
      foreach ($_FILES['files']['tmp_name'] as $index => $tmpName)
      {
        $fileName = $_FILES['files']['name'][$index];
        $fileSize = $_FILES['files']['size'][$index];
        $fileTmp  = $_FILES['files']['tmp_name'][$index];
        $fileType = $_FILES['files']['type'][$index];

        $result = ["file" => $fileName, "success" => false];

        if ($fileType !== "image/png") 
        {
          $result["error"] = "El archivo no es PNG";
          $response[] = $result;
          continue;
        }

        if ($fileSize > 100 * 1024) 
        {
          $result["error"] = "El archivo pesa más de 100kb";
          $response[] = $result;
          continue;
        }

        $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
        if (!preg_match('/^\d+$/', $nameWithoutExt)) 
        {
          $result["error"] = "El nombre del archivo debe ser un número";
          $response[] = $result;
          continue;
        }

        $destination = $uploadDir . basename($fileName);
        if (move_uploaded_file($fileTmp, $destination)) 
        {
          $result["success"] = true;
        } 
        else 
        {
          $result["error"] = "Error al mover el archivo";
        }
        $response[] = $result;
      }
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }


  public function index(): void 
  {
    $this->page_action = "Listado $this->controller_name" ;
    $this->fieldsToShow = (new Estudiante())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new Estudiante())->getFieldsShow(__FUNCTION__, true);
    $this->data = (new Estudiante())->getListEstudiantes();
  }

  public function exportRegistroEscolarByAnnioEstudiante(int $annio, int $estudiante_id) 
  {
    try
    {
      $this->data['Annio']  = $annio;
      $this->data['Estudiante'] = (new Estudiante())->get($estudiante_id);
      $tabla_datos_adju = Config::get('tablas.datosestud');
      $this->data['DatosEstud'] = (new DatosEstud())->first("SELECT * FROM {$tabla_datos_adju} WHERE estudiante_id=?", [$estudiante_id]);

      $this->data['Grado'] = (new Grado())->get($this->data['Estudiante']->grado_mat);
      $this->data['Salon'] = (new Salon())->get($this->data['Estudiante']->salon_id);
      $this->arrData['RegGenerales'] = (new RegistrosGen())->getByAnnioEstudiante($annio, $estudiante_id);
      $this->arrData['RegAcademicos'] = (new RegistroDesempAcad())->getByAnnioEstudiante($annio, $estudiante_id);

      $this->file_tipo = 'Informe Coordinadores';
      $this->file_name = OdaUtils::getSlug("registro_academico_{$annio}_{$this->data['Estudiante']}");
      $this->file_title = "Registro Academico {$annio} {$this->data['Estudiante']}";
      View::select(view: "export_pdf_registro_escolar_annio_estudiante_id.pdf", template: null);    
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function exportMoodleCsv(): void 
  {
    $this->file_title = "export Estudiantes Moodle";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = [];
    $this->registros = (new Estudiante)->getListExportMoodle();
    $this->file_download = false;
    View::select(view: "export_csv_estudiantes_moodle", template: 'csv'); //'xls_easy');
  }


  public function exportCentralesDeRiesgoXls(): void 
  {
    $this->file_title = "export Centrales de Riesgo";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = [];
    $this->registros = (new Estudiante)->getListEstudiantes();

    $this->file_download = false;
    View::select(view: "export_xls_centrales_de_riesgo", template: 'csv'); //'xls_easy');
  }

  public function exportListMatriculadosPdf(): void 
  {
    $this->file_title = "Listado de Estudiantes Matriculados";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = (new Estudiante)->getListMatriculados();
    $this->file_download = false;
    View::select(view: "export_pdf_matriculados", template: 'pdf/mpdf');
  }  

  public function exportListPendientesMatriculaPdf(): void 
  {
    $this->file_title = "Listado de Estudiantes Pendientes x Matricular";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = (new Estudiante)->getListPendientesMatricula();
    $this->file_download = false;
    View::select(view: "export_pdf_pendientes_matricula", template: 'pdf/mpdf');
  }  

  public function exportPdf(): void 
  {
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->file_title = "Listado de $this->controller_name";
    $this->data = (new Estudiante)->getList();
    $this->file_download = false;
    View::select(view: "export_pdf_$this->controller_name", template: 'pdf/mpdf');
  }

  public function exportEstudiantesBySalonPdf(string $salon_uuid) 
  {
    $RegSalon = (new Salon)::getByUUID($salon_uuid);
    $this->file_tipo = "Listado de $this->controller_name";
    $this->file_title = "Listado de $this->controller_name de $RegSalon->nombre";
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name-salon-$RegSalon->nombre");
    $this->data = (new Estudiante)->getListBySalon($RegSalon->id);
    View::select(view: "secre_pdf_estudiantes_by_salon", template: 'pdf/mpdf');
  }


  public function promoverMatriculas(int $grado_id, bool $trasladar = false) 
  {
    try
    {
      $no_promover = '414';
      $NewGrado = (new Grado())::get($grado_id);
      $DQLEstudiantes = new OdaDql('Estudiante');
      $DQLEstudiantes->setFrom(Config::get('tablas.estudiantes'));

      $dataE = [
        'is_active' => (($NewGrado->id == $NewGrado->proximo_grado) ? 0 : 1), // SE INACTIVAN SI ES GRADO FINAL 
        'is_habilitar_mat' => 1,
        'annio_promovido' => $this->_annio_matricula,
        'grado_promovido' => $NewGrado->proximo_grado,
        'numero_mat' => '', 
      ];

      if ($trasladar) {
        $dataE['grado_mat'] = $NewGrado->proximo_grado;
        $dataE['salon_id'] = $NewGrado->proximo_salon;
      }

      $DQLEstudiantes->update($dataE)
        ->where(' (t.is_active=1) and (t.id NOT IN ('.$no_promover.')) and (t.grado_mat=?)')
        ->setParams([$grado_id]);
      
      $DQLEstudiantes->execute();

      redirect::to('secre-estud-list-activos');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function editEstudiante(int $id, string $redirect='') 
  {
    try
    {
      $redirect = str_replace('.','/', $redirect);
      $this->page_action = 'EDITAR Registro Estudiante';
      //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      View::select(null, null);

      // ============================================================================
      
      if (!Input::hasPost('estudiantes')) 
      {
        OdaFlash::warning("$this->page_action - No coincide post 'estudiantes'");
        return Redirect::to($redirect);
      }
      if (!(new Estudiante)->validar(Input::post('estudiantes')))
      {
        OdaFlash::warning("$this->page_action - tabla ESTUDIANTES - ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }
      if ( (new Estudiante)->update(Input::post('estudiantes')) )
      {
        OdaFlash::valid("$this->page_action - Se actualizó tabla ESTUDIANTES");
      }
      else
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en ESTUDIANTES.");
      }

      // ============================================================================
      
      if (!Input::hasPost('datosestuds'))
      {
        OdaFlash::warning("$this->page_action - No coincide post DATOSESTUDS");
      }
      if (!(new DatosEstud)->validar(Input::post('datosestuds')))
      {
        OdaFlash::warning("$this->page_action. No pudo validar DATOSESTUDS");
      }
      if ( !(new DatosEstud)->update(Input::post('datosestuds')) )
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en DATOSESTUDS.");
      }

      // ============================================================================
      
      if (!Input::hasPost('estudianteadjuntos'))
      {
        OdaFlash::warning("$this->page_action - No coincide post estudianteadjuntos");
      }
      if (!(new EstudianteAdjuntos)->validar(Input::post('estudianteadjuntos')))
      {
        OdaFlash::warning("$this->page_action. No pudo validar estudianteadjuntos");
      }
      if ( !(new EstudianteAdjuntos)->update(Input::post('estudianteadjuntos')) )
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en estudianteadjuntos.");
      }
      
      return Redirect::to($redirect);
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }
  }

  public function exportDocsMatricula(int $estudiante_id) 
  {
    try
    {
      $this->data = (new Estudiante())->get($estudiante_id);
      $tabla_datosestud = Config::get('tablas.datosestud');
      $tabla_grados = Config::get('tablas.grados');
      $this->arrData['DatosEstud'] = (new DatosEstud())->first("SELECT * FROM {$tabla_datosestud} WHERE estudiante_id=?", [$estudiante_id]);
      $this->arrData['Grado'] = (new Grado())->first("SELECT * FROM {$tabla_grados} WHERE id=?", [$this->data->grado_promovido]);
      $this->file_tipo = '';
      $this->file_name = OdaUtils::getSlug("DOC-MAT-ESTUD");
      $this->file_title = OdaUtils::getSlug("DOC-MAT-ESTUD");
      View::select(view: "export_pdf_docs_matriculas", template: null);    
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }

  public function generarNumeroMatricula(int $estudiante_id) 
  {
    try 
    {
      $Estud = (new Estudiante())->get($estudiante_id);
      if ( ($Estud) and ((0==$Estud->numero_mat) or (is_null($Estud->numero_mat))) )
      {
        $DQL = new OdaDql('Estudiante');
        $DQL->setFrom('sweb_estudiantes');
        $next_numero_mat = (int)$DQL->getMax('numero_mat') + 1;
        $DQL->update(['numero_mat' => $next_numero_mat])
            ->where('t.id=?')
            ->setParams([$estudiante_id])
            ->execute();
      }
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return redirect::to('secre-estud-list-activos');
  }

  public function vincularPadresHijos(int $estudiante_id) 
  {
    (new EstudiantePadres)->vincularPadresHijos($estudiante_id);
    return Redirect::to('admin/estudiantes');
  }

}