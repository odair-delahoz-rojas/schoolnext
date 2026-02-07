<?php

#[AllowDynamicProperties]
class User extends ActiveRecord
{
    protected $source = 'dm_user';
    
    public $before_delete = 'no_borrar_activos';
    public function no_borrar_activos() {
        if($this->is_active==1) {
            Flash::warning('No se puede borrar un registro activo');
            return 'cancel';
        }
    }

    public function after_delete() {
        Flash::valid("Se borró el registro $this->id");
    }

    public function before_create() { 
        $this->is_active = 1; 
    }

    public function before_save() {            
        $rs = $this->find_first("documento = $this->documento");
        if($rs) {
            Flash::warning('Ya existe un usuario registrado bajo esta cédula');
            return 'cancel';
        }                
    }

    /**
      * Devuelve TODOS los registros del modelo Salon sin paginación
      */
    public function getList() {
        return (new User)->find();
    }

   /**
      * Devuelve TODOS los registros del modelo Usuario para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuarios($page, $ppage=50) {
        return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');
    }

   /**
      * Devuelve los registros ACTIVOS del modelo Salon para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuariosActivos($page, $ppage=50) {
        return $this->paginate("page: $page", 'conditions: is_active=1' , "per_page: $ppage", 'order: id desc');
    }

   /**
      * Devuelve los registros INACTIVOS del modelo Salon para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuariosInactivos($page, $ppage=50) {
        return $this->paginate("page: $page", 'conditions: is_active=0' , "per_page: $ppage", 'order: id desc');
    }
    
   //=========
   public function __toString() {
    return $this->getNombreCompleto('a1 a2 n');
    }

    
    //=========
    public function getNombreCompleto2($orden='a1 a2, n', $sanear=true, $humanize=false) {
        if ($sanear) {
            $this->nombres   = OdaUtils::sanearString($this->nombres);
            $this->apellido1 = OdaUtils::sanearString($this->apellido1);
            $this->apellido2 = OdaUtils::sanearString($this->apellido2);
        }
        if ($humanize) {
            $this->nombres   = OdaUtils::nombrePersona($this->nombres);
            $this->apellido1 = OdaUtils::nombrePersona($this->apellido1);
            $this->apellido2 = OdaUtils::nombrePersona($this->apellido2);
        }
        
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }

    //=========
    public function getNombreCompleto($orden='a1 a2, n') {
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }


    public function login()
    {
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
      if ('santarosa'==INSTITUTION_KEY) 
      {
        $auth = AuthDolibarr::factory('curl');
      } 
      else 
      {
        $auth = Auth2Odair::factory('model');
      }
      
      $auth->setModel('User'); // Modelo que utilizará para consultar
      $auth->logout();
    }


    public function isLogged(): bool 
    {
      if ('santarosa'==INSTITUTION_KEY) 
      {
        return AuthDolibarr::factory('model')->isValid();
      }      
      return Auth2Odair::factory('model')->isValid();
    }

}
