<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class AuthController extends AdminController
{

  
  public function index(): void 
  {
    Redirect::toAction('login');
  }


  public function login(): void 
  {
    View::template('login');
    if((new User)->login()) 
    { 
      Redirect::to('index'); 
    }
  }


  public function logout(): void 
  {
    (new User)->logout();
    Redirect::toAction('login');
  }
  



}