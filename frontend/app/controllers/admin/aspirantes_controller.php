<?php
/**
  * Controlador
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class AspirantesController extends ScaffoldController
{


  function trasladar(int $id) 
  {
    try
    {
      $redirect = "sicologia/admisiones";
      $this->page_action = 'TRASLADAR Aspirante';
      echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      View::select(null, null);
      Aspirante::trasladar($id);
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return Redirect::to($redirect);
  }


  function crear() 
  {
    $id = 0;
    try
    {
      $this->page_action = "Crear Aspirante";
      $redirect = "admisiones/success";
      //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      // =================================================================
      $post_name_aspir = 'aspirantes';
      if ( !Input::hasPost($post_name_aspir) )
      {
        OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir</b>, no llegó"); 
      }
      $documento = '';
      if ( Input::hasPost($post_name_aspir) )
      {
        $Post = Input::post($post_name_aspir);
        $dataAspir = [];
        foreach ($Post as $field_name => $value)
        {
          $dataAspir[$field_name] = $value;
          if ( 'documento'==$field_name )
          {
            $documento = $value;
          }
        }
      }
      // =================================================================
      // AGREGA CAMPOS $dataAdicAspir (DE CONTROL)
      $dataAdicAspir =[];
      $dataAdicAspir['uuid'] = (new Aspirante())->xxh3Hash();
      $dataAdicAspir['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['created_by']= 0;
      $dataAdicAspir['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['updated_by']= 0;

      // OJO :: después buscar otra alternativa mas eficiente
      $AspExiste = (new Aspirante())::first(
        'Select documento from sweb_aspirantes where documento =?', [$documento]
      );
      if (isset($AspExiste)) 
      {
        // Elimina registros de este estudiante anteriores
        (new Aspirante())::query("DELETE FROM sweb_aspirantes WHERE documento = ?", [$AspExiste->documento]);
        (new AspirantePsico())::query("DELETE FROM sweb_aspirantepsico WHERE aspirante_id = ?", [$AspExiste->id]);
      }

      // Crea el registro del Aspirante
      $DQL = new OdaDql((new Aspirante)::class);
      $DQL->insert($dataAspir)
      ->addInsert($dataAdicAspir)
      ->execute();
      
      $aspirante_id = $DQL->getLastInsertId();
      $id = $aspirante_id->last_id??0;

      $post_name_aspir_psico = 'aspirantepsicos';
      $dataAspirPsico = [];
      if ( Input::hasPost($post_name_aspir_psico) )
      {
        $Post = Input::post($post_name_aspir_psico);
        foreach ($Post as $field_name => $value)
        {
          $dataAspirPsico[$field_name] = $value;
        }
      }

      // =================================================================
      // AGREGA CAMPOS DE CONTROL
      $dataAdicAspirPsico =[];
      $dataAdicAspirPsico['uuid'] = (new AspirantePsico())->xxh3Hash();
      $dataAdicAspirPsico['aspirante_id'] = $id;
      $dataAdicAspirPsico['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['created_by']= 0;
      $dataAdicAspirPsico['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['updated_by']= 0;

      $DQL = new OdaDql((new AspirantePsico)::class);
      $DQL->insert($dataAspirPsico)
      ->addInsert($dataAdicAspirPsico)
      ->execute();
      
      OdaFlash::valid("El registro de aspirante #$id ha sido creado satisfactoriamente");

    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return Redirect::to($redirect."/{$id}");
  }


  function actualizarPsicologia() 
  {
    try
    {
      $debug = false;
      if ($debug)
      { 
        echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      }

      $this->page_action = "Actualizar Aspirante";
      $redirect = "sicologia/admisiones";
      $post_name_aspir = 'aspirantes';

      if ( !Input::hasPost($post_name_aspir) )
      {
        OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir</b>, no llegó"); 
      }

      // CARGA LOS DATOS DEL POST EN UN ARRAY
      $arrCamposValidos = [
        "estatus"         => '',
        "grado_aspira"    => '',
        "fecha_entrev"    => '000-00-00 00:00:00', 
        "is_fecha_entrev" => '0', 
        "fecha_eval"      => '000-00-00 00:00:00', 
        "is_fecha_eval"   => '0', 

        "result_matem"  => '', 
        "result_caste"  => '', 
        "result_ingle"  => '', 
        "result_scien"  => '',
        "entrevista"    => '', 
        "recomendac"    => '', 
      ];

      $aspirante_id = 0;
      if (Input::hasPost($post_name_aspir)) 
      {
        $Post = Input::post($post_name_aspir);        
        $is_active_ctrl = false;
        $is_fecha_entrev = false;
        $is_fecha_eval = false;
        foreach ($Post as $field_name => $value)
        {          
          if ('is_active'==$field_name) 
          {
            $is_active_ctrl = true; 
          }
          if ('is_fecha_entrev'==$field_name)
          {
            $is_fecha_entrev = true; 
          }
          if ('is_fecha_eval'==$field_name)
          {
            $is_fecha_eval = true; 
          }
          if ( array_key_exists($field_name, $arrCamposValidos) and strlen($value)>0 )
          {
            $arrCamposValidos[$field_name] = $value;
          }
          if ('id'==$field_name)
          {
            $aspirante_id = $value;
          }
        }
        $arrCamposValidos['is_active'] = ($is_active_ctrl) ? 1 : 0 ;
        $arrCamposValidos['is_fecha_entrev'] = ($is_fecha_entrev) ? 1 : 0 ;
        $arrCamposValidos['is_fecha_eval'] = ($is_fecha_eval) ? 1 : 0 ;
      }

      // AGREGA CAMPOS DE CONTROL
      $dataAdicAspir =[];
      $dataAdicAspir['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['updated_by'] = $this->user_id;      
      $DQL = new OdaDql((new Aspirante)::class);
      $DQL->update($arrCamposValidos)
          ->addUpdate($dataAdicAspir)
          ->where('id=?')
          ->setParams([$aspirante_id]);
      $DQL->execute($debug);
      OdaFlash::valid('Actualización exitosa.');    
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return Redirect::to($redirect);
  }




  function actualizarSecretaria() 
  {
    try
    {
      $debug = false;
      if ($debug)
      {
        echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      }
      $this->page_action = "Actualizar Aspirante";
      $redirect = "secretaria/admisiones";
      $post_name_aspir = 'aspirantes';
      if (!Input::hasPost($post_name_aspir)) 
      { 
        OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir</b>, no llegó"); 
      }      
      // CARGA LOS DATOS DEL POST EN UN ARRAY
      $arrCamposValidos = [
        "ctrl_llamadas" => '', 
        'is_pago'       => 0,
        'grado_aspira'  => '',
      ];
      $aspirante_id = 0;
      if (Input::hasPost($post_name_aspir)) 
      {
        $Post = Input::post($post_name_aspir);
        $is_pago_ctrl = false;
        foreach ($Post as $field_name => $value) 
        {
          if ('is_pago'==$field_name)
          {
            $is_pago_ctrl = true;
          }
          if (array_key_exists($field_name, $arrCamposValidos) and strlen($value)>0)
          {
            $arrCamposValidos[$field_name] = $value;
          }
          if ('id'==$field_name)
          {
            $aspirante_id = $value;
          }
        }
        $arrCamposValidos['is_pago'] = ($is_pago_ctrl) ? 1 : 0 ;
      }
      // AGREGA CAMPOS DE CONTROL
      $dataAdicAspir =[];
      $dataAdicAspir['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['updated_by'] = $this->user_id;      
      $DQL = new OdaDql((new Aspirante)::class);
      $DQL->update($arrCamposValidos)
          ->addUpdate($dataAdicAspir)
          ->where('id=?')
          ->setParams([$aspirante_id]);
      $DQL->execute($debug);
      OdaFlash::valid('Actualización exitosa.');    
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return Redirect::to($redirect);
  }



}