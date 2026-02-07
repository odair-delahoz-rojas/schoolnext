<?php
/**
 * Controller por defecto si no se usa el routes
 *
 */
class IndexController extends AppController
{
  const MODULOS = array(
        'admin' => 'admin',
        'docentes'  => 'docentes',
        'coordinadores' => 'docentes',
        'padres'  => 'padres',
        'secretarias' => 'secretaria',
        'matriculas'  => 'secretaria',
        'sicologos'=> 'sicologia',
        'psicologos'=> 'sicologia',
        'contables'=> 'contabilidad',
        'enfermeras'=> 'enfermeria',
  );
    
  public function index() 
  {
    $roll_usuario = strtolower(trim(Session::get('roll')));
    if (!$roll_usuario) 
    {  // SI NO TIENE ROLL ASIGNADO
      OdaLog::debug('NO TENÍA ROLL '.__METHOD__.', linea:'.__LINE__, __FILE__);
      if ( trim(Session::get('username')) == trim(Session::get('documento')) ) 
      {
        $roll_usuario = 'padres';
      } 
      else 
      {
        $roll_usuario = 'docentes';
      }
      // verificar que esto (save) esté funcionando !!!
      $usr = (new Usuario)->first('SELECT * FROM dm_user WHERE documento = ?', [Session::get('documento')] );
      $usr->roll = $roll_usuario;
      $usr->save();
    }

    if ( !array_key_exists($roll_usuario, self::MODULOS) ) 
    {
      $this->logout();
    }
    Session::set('modulo', self::MODULOS[$roll_usuario] );
    Redirect::to(Session::get('modulo'));
  }

  
  public function logout() 
  {
    Load::model('User')->logout();
    Redirect::toAction('login');
  }

  public function cambiarTheme() 
  {
    $new_modo = (Session::get('theme')=='dark') ? 'light' : 'dark' ;
    Session::set('theme', $new_modo);
    Redirect::toAction('index');
  }



}