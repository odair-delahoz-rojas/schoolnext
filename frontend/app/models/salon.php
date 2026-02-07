<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

 include "salon/salon_trait_call_backs.php";
include "salon/salon_trait_links.php";
include "salon/salon_trait_props.php";
include "salon/salon_trait_set_up.php";

#[AllowDynamicProperties]
class Salon extends LiteRecord {
  use SalonTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.salon');
    self::$pk = 'id';
    self::$_order_by_defa = 't.is_active DESC, t.position';
    $this->setUp();
  }


  public function getList2($estado=null, $select='*', string|bool $order_by=null) 
  { 
    $DQL = "SELECT s.*, g.nombre AS grado, CONCAT(ud.nombres, ' ', ud.apellido1, ' ', ud.apellido2) AS director, 
              CONCAT(uc.nombres, ' ', uc.apellido1, ' ', uc.apellido2) AS codirector 
            FROM ".self::$table." AS s
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON s.grado_id=g.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS ud ON s.director_id=ud.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS uc ON s.codirector_id=uc.id";

    if (!is_null($estado)) {
      $DQL .= " WHERE (s.is_active=?) ORDER BY s.position ";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY s.position ";
    return $this::all($DQL);
  }


  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*, g.nombre AS grado_nombre")
        ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
        ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
        ->leftJoin('grado',   'g')
        ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
        ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
        ->orderBy(self::$_order_by_defa);

    if (!is_null($estado)) { $DQL->andWhere("t.is_active=$estado"); }

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }
    
    return $DQL->execute();
  }
  

  public function getByCoordinador(int $user_id) 
  { 
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select("t.*, g.nombre AS grado_nombre")
          ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
          ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
          ->leftJoin('grado',   'g')
          ->leftJoin('seccion',   's', 'g.seccion_id = s.id')
          ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
          ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
          ->orderBy(self::$_order_by_defa)
          ->where("t.is_active=1");
      
      if ($user_id<>1) {
        $DQL->andWhere("s.coordinador_id=? or s.secretaria_id=? ")
          ->setParams([$user_id, $user_id]);
      }
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
  

  public function getByDirector(int $user_id) 
  { 
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select("t.*, g.nombre AS grado_nombre")
          ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
          ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
          ->leftJoin('grado', 'g')
          ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
          ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
          ->orderBy(self::$_order_by_defa)
          ->where("t.is_active=1");
      
      if ($user_id<>1) {
        $DQL->andWhere("(t.director_id=? or t.codirector_id=?)")
          ->setParams([$user_id, $user_id]);
      }
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
  
      
  public static function setupCalificarSalon(int $salon_id) 
  {
    try
    {
      
      $DoliK = new DoliConst();
      $annio_actual = $DoliK->getValue('SCHOOLNEXTACADEMICO_ANNIO_ACTUAL');
      $periodo_actual = $DoliK->getValue('SCHOOLNEXTACADEMICO_PERIODO_ACTUAL');

      $RegSalon = (new Salon())->get($salon_id);
      $cnt = 0;
      if (isset($RegSalon))
      {
        $RegGrado = (new Grado())::get($RegSalon->grado_id);
        //$nota_default = (1==$RegGrado->seccion_id) ? 100: 0;
        $nota_default = 0;
        
        // OBTENER TODAS LAS ASIGNATURAS DE ESE SALON (GRADO).
        $Model = new GradoAsignatura();
        $DQL = new OdaDql(__CLASS__);
        $DQL->setFrom('sweb_grado_asignat');
        $DQL->where('t.grado_id=?');
        $DQL->setParams([$RegSalon->grado_id]);
        if ($periodo_actual<5) // Excluir comportamiento
        {
          $DQL->andWhere('t.asignatura_id<>30');
        }
        $Asignaturas = $DQL->execute();
          
        // OBTENER TODAS LOS ESTUDIANTES DE ESE SALON
        $Model = new Estudiante();
        $DQL = new OdaDql(__CLASS__);
        $DQL->setFrom('sweb_estudiantes');
        $DQL->where('t.is_active=1 AND t.salon_id=?');
        $DQL->setParams([$salon_id]);
        $Estudiantes = $DQL->execute();
          
        foreach ($Estudiantes as $estud)
        {
          foreach ($Asignaturas as $asignat)
          {
              $Now = new DateTime('now', new DateTimeZone('America/Bogota'));
              $Model = new Nota();
              $DQL = new OdaDql(__CLASS__);
              $DQL->setFrom('sweb_notas');

              $DQL->insert([
                'uuid' => $Model->xxh3Hash($periodo_actual),
                'annio' => $annio_actual,
                'periodo_id' => $periodo_actual,
                'grado_id' => $RegSalon->grado_id,
                'salon_id' => $salon_id,
                'asignatura_id' => $asignat->asignatura_id,
                'estudiante_id' => $estud->id,
                'definitiva' => $nota_default,
                'created_at' => $Now->format('Y-m-d H:i:s'),
                'updated_at' => $Now->format('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_by' => 1,
            ]);
            $DQL->execute();
            $cnt += 1;

            if (4==$periodo_actual) { // OJO EXCEPCIÓN añadir el 5to periodo automáticamente
              $DQL->insert([
                'uuid' => $Model->xxh3Hash(5),
                'annio' => $annio_actual,
                'periodo_id' => 5,
                'grado_id' => $RegSalon->grado_id,
                'salon_id' => $salon_id,
                'asignatura_id' => $asignat->asignatura_id,
                'estudiante_id' => $estud->id,
                'definitiva' => $nota_default,
                'created_at' => $Now->format('Y-m-d H:i:s'),
                'updated_at' => $Now->format('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_by' => 1,
              ]);
              $DQL->execute();
              $cnt += 1;
            }
              
            }// END-foreach-Asignaturas

            if (4==$periodo_actual) { // OJO EXCEPCIÓN añadir comportamiento el 5to periodo automáticamente
              $DQL->insert([
                'uuid' => $Model->xxh3Hash(5),
                'annio' => $annio_actual,
                'periodo_id' => 5, // QUINTO PERIDO SOLAMENTE.
                'grado_id' => $RegSalon->grado_id,
                'salon_id' => $salon_id,
                'asignatura_id' => 30, // MATERIA COMPORTAMIENTO
                'estudiante_id' => $estud->id,
                'created_at' => $Now->format('Y-m-d H:i:s'),
                'updated_at' => $Now->format('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_by' => 1,
              ]);
              $DQL->execute();
              $cnt += 1;
            }

          }// END-foreach-Estudiantes
      }
      
      if($cnt>0) {
        $total_estudiantes = Count($Estudiantes);
        $DQL = new OdaDql(__CLASS__);
        $DQL->setFrom('sweb_salones');
        $DQL->update(['is_ready_print' => $periodo_actual, 
                      'tot_estudiantes' => $total_estudiantes])
            ->where('id=?')->setParams([$salon_id]);
        $DQL->execute();    
      }
      
      return $cnt;
    } 
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }

  
  public function setNumeroEstudiantes() 
  {
    $tot_estudiantes = (new Estudiante)->getNumEstudiantes_BySalon($this->id);
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom('sweb_salones');
    $DQL->update(['tot_estudiantes' => $tot_estudiantes])
        ->where('t.id=?')
        ->setParams([$this->id]);

    $DQL->execute();
  }
  


}