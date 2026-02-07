<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "planes_apoyo/planes_apoyo_trait_props.php";

#[AllowDynamicProperties]
class PlanesApoyo extends Nota {

  use PlanesApoyoTraitProps;
  
  public function getByEstudiantePeriodo(
    int $estudiante_id, 
    int $periodo_id
  ) {
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.uuid, t.periodo_id, a.nombre as asignatura_nombre, t.grado_id')
        ->leftJoin('asignatura', 'a')
        ->where("t.is_paf_validar_ok>=3 AND t.estudiante_id=? AND t.periodo_id=?")
        ->setParams([$estudiante_id, $periodo_id]);
    return $DQL->execute();
  }

  
  public function getBySalonAsignaturaPeriodos(
    int $salon_id, 
    int $asignatura_id, 
    array $periodos=[], 
    $annio=null
  ): array {
    $str_p = implode(',', $periodos);      
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*')
        ->addSelect('a.nombre as asignatura_nombre')
        ->addSelect('s.nombre as salon_nombre')
        ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')

        ->leftJoin('asignatura', 'a')
        ->leftJoin('salon', 's')
        ->leftJoin('estudiante', 'e')

        ->where("t.periodo_id IN($str_p) AND t.salon_id=? AND t.asignatura_id=?")
        ->setParams([$salon_id, $asignatura_id])
        ->orderBy('t.annio, t.periodo_id DESC, s.nombre, e.apellido1, e.apellido2, e.nombres');
    return $DQL->execute();
  }



}