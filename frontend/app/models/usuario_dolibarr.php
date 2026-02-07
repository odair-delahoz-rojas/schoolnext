<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

 /*
  rowid Primaria	int(11)
  login varchar(50)
	employee	tinyint(4)
	login Índice	varchar(50)
	gender	varchar(10)
	civility	varchar(6)
	lastname	varchar(50)
	firstname	varchar(50)
	address	varchar(255)
	town	varchar(50)
	fk_state	int(11)
	fk_country	int(11)
	statut	tinyint(4)
	photo	varchar(255)
 */

include "usuario/usuario_doli_trait_props.php";

#[AllowDynamicProperties]
class UsuarioDolibarr extends LiteRecord {

  use UsuarioDoliTraitProps;

  public function __construct() 
  {
    parent::__construct();
    self::$table = PREFIJO_TABLAS_DOLIBARR.'users';
    self::$pk = 'rowid';
  }


  public function getUserGroups(int $user_id)
  { 
    $DQL = new OdaDql('UsuarioDolibarr');
    $DQL->setFrom(PREFIJO_TABLAS_DOLIBARR.'usergroup');
    $DQL->select('t.nom')
        ->where('t.rowid IN 
        (SELECT gu.fk_usergroup 
         FROM '.PREFIJO_TABLAS_DOLIBARR.'usergroup_user AS gu 
         WHERE gu.fk_user = ?)')
      ->setParams([$user_id]);
    return $DQL->execute();
  }

  // TODO: en desarrollo
  public function getDocentes()
  {
    $DQL = new OdaDql('UsuarioDolibarr');
    $DQL->setFrom(PREFIJO_TABLAS_DOLIBARR.'usergroup');
    $DQL->select("t.*")
      ->concat(['t.firstname', 't.lastname'], 'usuario_nombre')
      ->concat(['t.firstname', 't.lastname'], 'nombre')
      ->where('t.login<>t.documento')
      ->orderBy('t.??????'); // ?????
    return $DQL->execute();
  }

  public function login()
  {
  $auth = AuthDolibarr::factory('curl');
  $auth->setModel('UsuarioDolibarr'); // Modelo que utilizará para consultar
  $auth->setFields(['id', 'username', 'password', 'nombres', 'apellido1', 'apellido2', 'roll', 'documento', 'usuario_instit', 'clave_instit', 'theme']);
  $auth->setLogin('username');
  $auth->setPass('password');
  $auth->setAlgos('sha1');
  $auth->setKey('usuario_logged');
            
  $DoliK = new DoliConst();
  $institucion = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '<Nombre del Instituto>';
  $annio_inicial = $DoliK->getValue('SCHOOLNEXTCORE_ANNIO_INICIAL') ?? 2000;
  $annio_actual = $DoliK->getValue('SCHOOLNEXTACADEMICO_ANNIO_ACTUAL') ?? 2000;
  $periodo_actual = $DoliK->getValue('SCHOOLNEXTACADEMICO_PERIODO_ACTUAL') ?? 1;
  
  Session::set('institucion', $institucion );
  Session::set('ip', OdaUtils::getIp() );
  Session::set('annio_inicial', (int)$annio_inicial);
  Session::set('annio', (int)$annio_actual);
  Session::set('periodo', (int)$periodo_actual);      
  $rango_nota_inferior = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_INFERIOR') ?? 1;
  $rango_nota_perdida  = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_PERDIDA') ?? 1;
  $rango_nota_superior = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_SUPERIOR') ?? 1;
  Session::set('rango_nota_inferior', (int)$rango_nota_inferior);
  Session::set('rango_nota_perdida', (int)$rango_nota_perdida);
  Session::set('rango_nota_superior', (int)$rango_nota_superior);
      
  // ========================
  $PeriodoD = new PeriodoD();
  $max_periodos = $PeriodoD::getNumPeriodos();
  Session::set('max_periodos', $max_periodos);
  $PeriodoActual = (new PeriodoD())->get($periodo_actual);

  // ========================
  Session::set('fecha_inicio', $PeriodoActual->fecha_inicio ?? '');
  Session::set('fecha_fin',    $PeriodoActual->fecha_fin ?? '');
  Session::set('f_ini_notas',  $PeriodoActual->f_ini_notas ?? '');
  Session::set('f_fin_notas',  $PeriodoActual->f_fin_notas ?? '');
  Session::set('f_open_day',   $PeriodoActual->f_open_day ?? '');
  Session::set('es_director',  false);
  if ($auth->identify()) 
  {
    Session::set('es_director',  (new Salon)->isDirector( (int)Session::get('id') ) );
    Session::set('foto', "uploads/users/".Session::get('documento').".png");
    return true; 
  }      
  if ($auth->getError()) 
  { 
    OdaFlash::warning($auth->getError());
  }
  return false;
  }



  public function logout() 
  {
    $auth = AuthDolibarr::factory('curl');
    $auth->setModel('UsuarioDolibarr');
    $auth->logout();
  }


  public function isLogged(): bool 
  {
    return AuthDolibarr::factory('model')->isValid();
  }

}