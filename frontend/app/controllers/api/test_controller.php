<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/asignaturas/all
  */
class TestController extends RestController
{

  public function get_test1() 
  {
    View::select(null, null);
    echo '<p>resultado '.rand(100, 200).'</p>';
  }
  


}