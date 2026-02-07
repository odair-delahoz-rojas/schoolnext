<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "seguimientos/seguimientos_trait_links.php";
include "seguimientos/seguimientos_trait_props.php";

#[AllowDynamicProperties]
class Seguimientos extends Nota {

  use SeguimientosTraitProps, SeguimientosTraitLinks;


  public function getByEstudiantePeriodo(int $estudiante_id, int $periodo_id) 
  {
    try {
      $ok = self::$asi_valido;
      $DQL = (new OdaDql(__CLASS__))
        ->select('t.uuid, t.periodo_id, a.nombre as asignatura_nombre')
        ->leftJoin('asignatura', 'a')
        ->where(" (t.is_asi_validar_ok>=$ok) AND (t.estudiante_id=?) AND (t.periodo_id=?)")
        ->setParams([$estudiante_id, $periodo_id]);

      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
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

  
  public static function getConsolidadoBySalonPeriodo(
    string $salon_uuid, 
    int $periodo,
  ) {
    try {
      $ok = self::$asi_valido;
      $RegSalon = (new Salon)::getByUUID($salon_uuid);
      $GradoAsig = (new GradoAsignatura())->getByGrado($RegSalon->grado_id);
      
      $DQL = (new OdaDql(__CLASS__))
      ->select('t.uuid, t.estudiante_id, t.asignatura_id, t.asi_activ_profe, t.asi_activ_estud, t.asi_desempeno, t.asi_fecha_entrega, t.is_asi_validar_ok')
      ->addselect('a.nombre as asignatura_nombre, a.abrev as asignatura_abrev')
      ->concat(['e.apellido1', 'e.apellido2', 'e.nombres'], 'estudiante_nombre')
      ->leftJoin('estudiante', 'e')
      ->leftJoin('asignatura', 'a')
      ->where("(t.periodo_id = ?) AND (t.salon_id=?) AND (t.is_asi_validar_ok>=$ok)")
      ->orderBy('e.apellido1, e.apellido2, e.nombres, a.nombre')
      ->setParams([$periodo, $RegSalon->id]);
      $DQL->setFrom('sweb_notas');
      $AccSeguimientos = $DQL->execute();
      
      $ConstGrados = [];
      foreach ($GradoAsig as $key => $grado_asignat) {
        $ConstGrados[$grado_asignat->asignatura_abrev] = [];
      }


      $ArrResult = [];
      $pivote = 0;
      foreach ($AccSeguimientos as $keyRecs => $AccSeg) {
        if ($pivote != $AccSeg->estudiante_nombre) { // primer registro del ese estudiante
          $ArrResult[$AccSeg->estudiante_nombre][$AccSeg->estudiante_id]['abrev'] = $ConstGrados;
        }
        $ArrResult[$AccSeg->estudiante_nombre][$AccSeg->estudiante_id]['abrev'][$AccSeg->asignatura_abrev] = $AccSeg;
        $pivote = $AccSeg->estudiante_nombre;
      }

      return $ArrResult;
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }



}