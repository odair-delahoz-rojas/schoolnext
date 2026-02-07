<?php
trait TraitValidar { 
  
  public function validar($input_post) 
  {
    Session::set('error_validacion', '');
    $validador = new Validate($input_post, self::$_rules_validators);
    if (!$validador->exec()) {
      $errors = '<br>';
      foreach ($validador->getMessages() as $key1 => $error1) 
      {
        foreach ($error1 as $key => $error)
        {
          $errors .= "<strong>".self::$_labels[$key1]."</strong>: $error, <u>recibido</u>: '". substr($input_post[$key1], 15) ."'<br>";
        }
      }
      Session::set('error_validacion', $errors);
      return false;
    }
    return true;
  }



}