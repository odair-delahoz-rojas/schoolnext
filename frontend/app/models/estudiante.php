<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
 
include "estudiante/estudiante_trait_correcciones.php";
include "estudiante/estudiante_trait_datos_padres.php";
include "estudiante/estudiante_trait_links.php";
include "estudiante/estudiante_trait_matriculas.php";
include "estudiante/estudiante_trait_props.php";
include "estudiante/estudiante_trait_setters.php";
include "estudiante/estudiante_trait_call_backs.php";
include "estudiante/estudiante_trait_set_up.php";

#[AllowDynamicProperties]
class Estudiante extends LiteRecord 
{
  use EstudianteTraitSetUp;

  public function __construct(private bool $write_log = false) {
    parent::__construct();
    self::$table = Config::get('tablas.estudiante');
    self::$pk = 'id';
    self::$_order_by_defa = 'g.orden,s.nombre,t.apellido1,t.apellido2,t.nombres';
    
    $this->DQL = (new OdaDql('Estudiante'));
    $this->DQL->setFrom(self::$table);

    $this->DQL
      ->select('t.*, CONCAT(t.apellido1, " ", t.apellido2, " ", t.nombres) AS estudiante_nombre')
      ->addSelect('CONCAT(t.nombres, " ", t.apellido1, " ", t.apellido2) AS estudiante_nombre2')
      ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
      ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email,
                de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 't.grado_mat=g.id')
      ->where('t.is_active=1')
      ->orderBy(self::$_order_by_defa);      
    $this->setUp();
  }

  
  public function getList(
    int|bool $estado=null, 
    string $select='*', 
    string|bool $order_by=null
  ): array|string {
    
    $DQL = $this->DQL;
    
    if (null !== $order_by) { $DQL->orderBy($order_by); }
    if ($select !== '*')    { $DQL->select($select); }
    if (1 !== $estado)      { $DQL->where('(t.is_active=0) OR (t.is_active IS NULL)'); }

    return $DQL->execute($this->write_log);
  }

  
  public function getListBySalon(
    int $salon_id, 
    string $orden='a1,a2,n', 
  ): array|string 
  {
    $DQL = $this->DQL;
    $DQL->andWhere('t.salon_id=?')->setParams([$salon_id]);
    
    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log);
  }

  
  public function getListExportMoodle(): array|string 
  {
    $DQL = (new OdaDql('Estudiante'))
      ->select("t.id, t.documento, t.nombres, t.apellido1, t.apellido2, g.abrev AS grado_abrev")
      ->where('t.is_active=1')
      ->leftJoin('Grado', 'g', 't.grado_mat=g.id')
      ->orderBy('t.grado_mat, t.salon_id, t.nombres, t.apellido1, t.apellido2');
    
    $estudiantes = $DQL->execute();

    $result = [];
    foreach ($estudiantes as $estud) 
    {
      $nomb = explode(' ',strtolower(trim($estud->nombres)));
      $ape1 = preg_replace('/[^-\.@_a-z0-9]/', '', strtolower(trim($estud->apellido1)));
      $ape2 = substr(strtolower(trim($estud->apellido2)), 0, 1);
      
      $data = date('ymdhis').rand(1, 1000);
      $usermail =  hash("xxh3", $data, options: ["seed" => rand(1, 1000)]);

      $username = $nomb[0].trim(substr($nomb[1],0,1)).'.'.$ape1.$ape2;
      $result[] = [
       'username' => $username, 
       'password' => trim($estud->documento), 
       'firstname' => ucwords(implode(' ', $nomb)), 
       'lastname' => ucwords(strtolower(trim(trim($estud->apellido1).' '.trim($estud->apellido2)))), 
       'email'     => trim($usermail).'@noemail.com',
       'idnumber'  => $estud->id,
       'cohort1'   => 'cohort_'.strtolower($estud->grado_abrev),
      ];
      
      // Actualiza Estudiantes
      $DQLUpdate = new OdaDql('Estudiante');
      $DQLUpdate->update(['email_instit' => $username, 'clave_instit' => $estud->documento ])
                ->where('t.id=?')
                ->setParams([$estud->id]);
      $DQLUpdate->execute();
    }
    return $result;
  }


  
  public function getListEstudiantes(
    string $orden='a1,a2,n', 
    int|bool $estado=null
  ): array|string {
    
    $DQL = $this->DQL;
    
    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    if (1 !== $estado) {
      $DQL->where('(t.is_active=0) OR (t.is_active IS NULL)');
    }

    return $DQL->execute($this->write_log);
  }


  public function getListSecretaria(
    string $orden='a1,a2,n', 
    int|bool $estado=null,
  ): array|string 
  {
    $DQL = $this->DQL;

    if (null !== $estado && 1 !== $estado) {
      $DQL->where('(t.is_active=0) OR (t.is_active IS NULL)');
    }

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }
    //OdaLog::debug("getListSecretaria - write_log: ".($this->write_log ? 'true' : 'false'));
    return $DQL->execute($this->write_log);
  }


  public function getListContabilidad(string $orden='a1,a2,n'): array|string {
    $DQL = $this->DQL;

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log);
  }


  public function getListSicologia(string $orden='a1,a2,n'): array|string {
    $DQL = $this->DQL;

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log);
  }


  public function getListEnfermeria(string $orden='a1,a2,n'): array|string {
    $DQL = $this->DQL;

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log);
  }


  public function getListPadres(
    int $user_id,
    string $orden='a1,a2,n', 
  ): array|string {
    $lista = (new EstudiantePadres)->getHijos($user_id);
    $filtro = implode(',', $lista);
    
    $DQL = $this->DQL;
    $DQL->andWhere("t.id IN ($filtro)");

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log)??[];
  }


  public function getListPadresRetirados(
    int $user_id,
    string $orden='a1,a2,n',
  ): array|string {
    $lista = (new EstudiantePadres)->getHijos($user_id);
    $filtro = implode(',', $lista);

    $DQL = $this->DQL;
    $DQL->where("t.is_active=1 or (t.is_active=0 and YEAR(t.fecha_ret)=".self::$_annio_actual.")")
        ->andWhere("t.id IN ($filtro)");

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log)??[];
  }


  public function getListPorProfesor(
    int $user_id,
    string $orden='a1,a2,n',
  ): array|string {  
    $CargaProfe = (new SalAsigProf)->getSalones_ByProfesor($user_id);
    $salones = [];
    foreach ($CargaProfe as $carga) {
      $salones[] = $carga->salon_id;
    }
    $filtro_in = implode(',', $salones);

    $DQL = $this->DQL;
    $DQL->andWhere("t.salon_id IN({$filtro_in})");

    if ($orden !== 'a1,a2,n') {
      $orden_nombres_apellidos = str_replace(
        ['n', 'a1', 'a2'],
        ['t.nombres', 't.apellido1', 't.apellido2'],
        $orden
      );
      $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
    }

    return $DQL->execute($this->write_log);
  }
  

  public function getListPorDirector(
    int $director_grupo_id,
    string $orden='a1,a2,n'
    ): array|string {
    // TODO :: NO SE USA AQUÍ :::: $director_grupo_id
    try {
      $Grupos = (new Usuario)->misGrupos();
      $salones = [];
      foreach ($Grupos as $salon) {
        $salones[] = $salon->id;
      }
      $filtro_in = implode(',', $salones);

      $DQL = $this->DQL;
      $DQL->andWhere("t.salon_id IN($filtro_in)");
      
      if ($orden !== 'a1,a2,n') {
        $orden_nombres_apellidos = str_replace(
          ['n', 'a1', 'a2'],
          ['t.nombres', 't.apellido1', 't.apellido2'],
          $orden
        );
        $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
      }

      return $DQL->execute($this->write_log);
    }
    
    catch (\Throwable $th) {
      OdaFlash::error($th, true);
      return [];
    }
  }

  
  public function getListPorCoordinador(
    int $coordinador_id, 
    string $orden='a1,a2,n'
  ): array|string {
    try {
      $Grupos = (new Salon)->getByCoordinador($coordinador_id);
      $salones = [];
      foreach ($Grupos as $salon) {
        $salones[] = $salon->id;
      }
      $filtro_in = implode(',', $salones);

      $DQL = $this->DQL;
      $DQL->andWhere("t.salon_id IN($filtro_in)");
      
      if ($orden !== 'a1,a2,n') {
        $orden_nombres_apellidos = str_replace(
          ['n', 'a1', 'a2'],
          ['t.nombres', 't.apellido1', 't.apellido2'],
          $orden
        );
        $DQL->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");
      }

      return $DQL->execute($this->write_log);
    }
    
    catch (\Throwable $th) {
      OdaFlash::error($th, true);
      return [];
    }
  }


  public function getSalonesCambiar(string $modulo): string {
    // TODO: automatizar el arreglo de salones siguientes
    $lnk_cambio = '';
    if ($this->is_active)
    {
      $salonesSig = [ // automatizarlo
        0 => [],
        1 => [1=>'01-A', 3=>'02-A'],
        2 => [3=>'02-A', 5=>'03-A', 6=>'03-B'],
        3 => [5=>'03-A', 6=>'03-B', 7=>'04-A', 24=>'04-B'],
        4 => [7=>'04-A', 24=>'04-B', 8=>'05-A', 26=>'05-B'],
        5 => [8=>'05-A', 26=>'05-B', 21=>'06-A', 25=>'06-B'],
        6 => [21=>'06-A', 25=>'06-B', 20=>'07-A', 28=>'07-B'],
        7 => [20=>'07-A', 28=>'07-B', 19=>'08-A', 31=>'08-B'],
        8 => [19=>'08-A', 31=>'08-B', 18=>'09-A', 34=>'09-B'],
        9 => [18=>'09-A', 34=>'09-B', 17=>'10-A', 35=>'10-B'],
        10 => [17=>'10-A', 35=>'10-B', 16=>'11-A', 36=>'11-B'],
        11 => [16=>'11-A', 36=>'11-B'],
        12 => [15=>'PV-A', 10=>'PK-A'],
        13 => [10=>'PK-A', 12=>'KD-A'],
        14 => [12=>'KD-A', 9=>'TN-A'],
        15 => [9=>'TN-A',  1=>'01-A'],
      ];
      if ( array_key_exists($this->grado_mat, $salonesSig) ) 
      {
        foreach ($salonesSig[$this->grado_mat] as $key_salon => $salon_nombre)
        {
          $lnk_cambio .= Html::link("$modulo/cambiar_salon_estudiante/$this->id/$key_salon/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
        }
      }
    }      
    return $lnk_cambio;
  }


  public function getNumEstudiantes_BySalon(int $salon_id): int {
    $DQL = new OdaDql('Estudiante');
    //$DQL->setFrom('sweb_estudiantes');

    $DQL->select('count(*) as total')
        ->groupBy('t.salon_id')
        ->where('t.is_active=1 AND t.salon_id=?')
        ->setParams([$salon_id]);
    $tot = $DQL->execute();

    return ($tot[0]->total ?? 0);
  }


}