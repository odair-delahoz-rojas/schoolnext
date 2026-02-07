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
  private string $tabla_estudiante = '';

  public function __construct()
  {
    parent::__construct();
    self::$table = Config::get('tablas.estudiante');
    self::$pk = 'id';
    self::$_order_by_defa = 't.apellido1,t.apellido2,t.nombres';
    $this->tabla_estudiante = Config::get('tablas.estudiante');
    
    $this->DQL = (new OdaDql('Estudiante'))
      ->select('t.*, s.nombre AS salon_nombre, g.nombre AS grado_nombre')
      ->select('de.madre, de.madre_id, de.madre_tel_1, de.madre_email,
                de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
      ->leftJoin('salon', 's', 't.salon_id=s.id')
      ->leftJoin('grado', 'g', 't.grado_mat=g.id')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->where('t.is_active=1')
      ->orderBy(self::$_order_by_defa);

    $this->setUp();
  }

  /**
   * @deprecated usa _getList()
   */
  public function getList(
    int|bool $estado=null, 
    string $select='*', 
    string|bool $order_by=null
  ): array|string 
  {
    $DQL = $this->DQL;
    $DQL->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'estudiante_nombre')
        ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre');        
    if (!is_null(self::$_order_by_defa))
    {
      $DQL->orderBy(self::$_order_by_defa); 
    }
    if (!is_null($estado))
    {
      $DQL->where('t.salon_id<>0 AND t.is_active=?')->setParams([$estado]);
    }
    return $DQL->execute(true);
  }



  public function getListBySalon(
    int $salon_id,
    string $orden='a1,a2,n', 
  ): array|string 
  {
    $DQL = $this->DQL;
    
    $orden_nombres_apellidos = str_replace(
      ['n', 'a1', 'a2'],
      ['t.nombres', 't.apellido1', 't.apellido2'],
      $orden
    );
    $DQL->concat(explode(',', $orden_nombres_apellidos), 'estudiante_nombre')
        ->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");

    $DQL->andWhere('t.salon_id=?')
        ->setParams([$salon_id]);

    return $DQL->execute() ?? [];
  }

  
  public function getListByGrado(
    int $grado_id,
    string $orden='a1,a2,n', 
  ): array|string 
  {
    $DQL = $this->DQL;
    
    $orden_nombres_apellidos = str_replace(
      ['n', 'a1', 'a2'],
      ['t.nombres', 't.apellido1', 't.apellido2'],
      $orden
    );
    $DQL->concat(explode(',', $orden_nombres_apellidos), 'estudiante_nombre')
        ->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");

    $DQL->andWhere('t.grado_mat=?')
        ->setParams([$grado_id]);

    return $DQL->execute() ?? [];
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
       'username'  => $username, 
       'password'  => trim($estud->documento), 
       'firstname' => ucwords(implode(' ', $nomb)), 
       'lastname'  => ucwords(strtolower(trim(trim($estud->apellido1).' '.trim($estud->apellido2)))), 
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
  ): array|string 
  {
    $DQL = $this->DQL;
    
    $orden_nombres_apellidos = str_replace(
      ['n', 'a1', 'a2'],
      ['t.nombres', 't.apellido1', 't.apellido2'],
      $orden
    );
    $DQL->concat(explode(',', $orden_nombres_apellidos), 'estudiante_nombre')
        ->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");

    $DQL->leftJoin('datosestud', 'de', 't.id=de.estudiante_id');
        

    return $DQL->execute();
  }

  /**
   * @deprecated usa _getStudentListByCriteria
   */
  public function getListActivosByModulo(
    Modulo $modulo = Modulo::Docen, 
    string $orden='a1,a2,n', 
    array|string $where = null
  ): array|string 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => $modulo,
        'orden' => $orden,
        'where' => $where,
        'estado' => 1
    ]);
  }

  public function getListSecretaria(
    string $orden='a1,a2,n', 
    int|bool $estado=null
  ): array|string 
  {
    $DQL = $this->DQL;
    
    if ($estado !== null) {
      $DQL->where($estado ? 't.is_active=1' : '(t.is_active=0 OR t.is_active IS NULL)');
    }

    $orden_nombres_apellidos = str_replace(
      ['n', 'a1', 'a2'],
      ['t.nombres', 't.apellido1', 't.apellido2'],
      $orden
    );
    $DQL->concat(explode(',', $orden_nombres_apellidos), 'estudiante_nombre')
        ->orderBy("g.orden,s.nombre,{$orden_nombres_apellidos}");

    $DQL->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, 
          de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id');

    return $DQL->execute(true) ?? [];
  }

  public function getListContabilidad(string $orden='a1,a2,n'): array|string {
    return $this->getListSecretaria($orden);
  }

  public function getListSicologia(string $orden='a1,a2,n'): array|string {
    return $this->getListSecretaria($orden);
  }

  public function getListEnfermeria(string $orden='a1,a2,n'): array|string {
    return $this->getListSecretaria($orden);
  }

  public function getListPadres(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => Modulo::Padre,
        'user_id' => $user_id,
        'orden' => $orden,
        'order_by' => "g.orden,s.nombre,{$orden}",
    ]) ?? [];
  }

  public function getListPadresRetirados(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => Modulo::Padre,
        'user_id' => $user_id,
        'orden' => $orden,
        'order_by' => "g.orden,s.nombre,{$orden}",
        'filtro_especial' => 'padres_retirados'
    ]) ?? [];
  }

  public function getListPorProfesor(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => Modulo::Docen,
        'user_id' => $user_id,
        'orden' => $orden,
        'order_by' => $orden,
    ]);
  }
  
  public function getListPorDirector(int $director_grupo_id, string $orden='a1,a2,n') 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => Modulo::DirGrupo,
        'user_id' => $director_grupo_id,
        'orden' => $orden,
        'order_by' => $orden,
    ]);
  }
  
  public function getListPorCoordinador(int $coordinador_id, string $orden='a1,a2,n') 
  {
    return $this->_getStudentListByCriteria([
        'modulo' => Modulo::Coord,
        'user_id' => $coordinador_id,
        'orden' => $orden,
        'order_by' => $orden,
    ]);
  }

  public function getSalonesCambiar(string $modulo): string 
  {
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
          $lnk_cambio .= Html::link("{$modulo}/cambiar_salon_estudiante/{$this->id}/{$key_salon}/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
        }
      }
    }      
    return $lnk_cambio;
  }

  public function getNumEstudiantes_BySalon(int $salon_id): int 
  {
    $DQL = new OdaDql('Estudiante');
    $DQL->setFrom('sweb_estudiantes');
    $DQL->select('count(*) as total')
        ->groupBy('t.salon_id')
        ->where('t.is_active=1 AND t.salon_id=?')
        ->setParams([$salon_id])
        ->setLimit(1);
    $tot = $DQL->execute();

    return ($tot[0]->total ?? 0);
  }
}