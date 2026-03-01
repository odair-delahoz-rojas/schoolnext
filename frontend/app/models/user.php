<?php

#[AllowDynamicProperties]
class User extends ActiveRecord
{
  protected $source = 'dm_user';

  public function login(): bool {
    $auth = ('santarosa'==INSTITUTION_KEY) ? AuthDolibarr::factory('curl') : Auth2Odair::factory('model');            
    $auth->setModel('User'); // Modelo que utilizará para consultar
    $auth->setFields(['id', 'username', 'password', 'nombres', 'apellido1', 'apellido2', 'roll', 'documento', 'usuario_instit', 'clave_instit', 'theme']);
    $auth->setLogin('username');
    $auth->setPass('password');
    $auth->setAlgos('sha1');
    $auth->setKey('usuario_logged');
    
    $DoliK = new DoliConst();
    $institucion = $DoliK->getValue('MAIN_INFO_SOCIETE_NOM') ?? '<Nombre del Instituto>';
    $annio_inicial = $DoliK->getValue('SCHOOLNEXTCORE_ANNIO_INICIAL') ?? 2000;
    $annio_actual = $DoliK->getValue('SCHOOLNEXTACADEMICO_ANNIO_ACTUAL') ?? 2000;
      
    // ========================
    $periodo_actual = PeriodoD::getPeriodoActual();
    Session::set('max_periodos', PeriodoD::getNumPeriodos());
    Session::set('institucion', $institucion );
    Session::set('ip', OdaUtils::getIp() );
    Session::set('annio_inicial', (int)$annio_inicial);
    Session::set('annio', (int)$annio_actual);
    Session::set('periodo', $periodo_actual);

    $rango_nota_inferior = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_INFERIOR') ?? 1;
    $rango_nota_perdida  = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_PERDIDA') ?? 1;
    $rango_nota_superior = $DoliK->getValue('SCHOOLNEXTACADEMICO_LIMITE_NOTA_SUPERIOR') ?? 1;
    Session::set('rango_nota_inferior', (int)$rango_nota_inferior);
    Session::set('rango_nota_perdida', (int)$rango_nota_perdida);
    Session::set('rango_nota_superior', (int)$rango_nota_superior);
      
    // ========================
    $PeriodoActual = (new PeriodoD())->get($periodo_actual);
    Session::set('fecha_inicio', $PeriodoActual->fecha_inicio ?? '');
    Session::set('fecha_fin',    $PeriodoActual->fecha_fin ?? '');
    Session::set('f_ini_notas',  $PeriodoActual->f_ini_notas ?? '');
    Session::set('f_fin_notas',  $PeriodoActual->f_fin_notas ?? '');
    Session::set('f_open_day',   $PeriodoActual->f_open_day ?? '');
    Session::set('es_director',  false);
    
    if ($auth->identify()) {
      Session::set('es_director',  (new Salon)->isDirector( (int)Session::get('id') ) );
      Session::set('foto', "uploads/users/".Session::get('documento').".png");
      return true; 
    }      
    
    if ($auth->getError()) {
      OdaFlash::warning($auth->getError());
    }
    
    return false;
  }


  public function logout(): void {
    $auth = ('santarosa'==INSTITUTION_KEY) ? $auth = AuthDolibarr::factory('curl'): $auth = Auth2Odair::factory('model');
    $auth->setModel('User');
    $auth->logout();
  }


  public function isLogged(): bool {
    if ('santarosa'==INSTITUTION_KEY) return AuthDolibarr::factory('model')->isValid();
    return Auth2Odair::factory('model')->isValid();
  }



}