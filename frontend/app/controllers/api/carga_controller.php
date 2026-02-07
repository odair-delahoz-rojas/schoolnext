<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class CargaController extends RestController
{

  /**
   * 
   * @link ../api/carga/asignar_carga
   */
  public function get_asignar_carga(
    int $salon_id, 
    int $asignatura_id, 
    int $profesor_id) 
  {
    try 
    {
      /*
      $DQL = new OdaDql();
      $DQL->from('SalAsigProf')->where('t.salon_id=? and t.asignatura_id=?')->setParams([$salon_id, $asignatura_id]);
      $carga_a_borrar = $DQL->execute();
      foreach ($carga_a_borrar as $key => $registro) { SalAsigProf::deleteById($registro->id); }
      */
      $Objeto = new SalAsigProf();
      $this->data = $Objeto->save([
        'salon_id'=>$salon_id, 
        'asignatura_id'=>$asignatura_id, 
        'user_id'=> $profesor_id 
      ]);
      $this->data = (new SalAsigProf())->getCarga($profesor_id);
    } 
    catch (\Throwable $th) 
    {
      OdaLog::error($th);
    }
  }



}