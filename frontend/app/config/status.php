<?php

return [
   'php' => [
      'upload_max_filesize'   => ini_get('upload_max_filesize'),
      'post_max_size'         => ini_get('post_max_size'),
      'register_globals'      => ini_get('register_globals'),
      'session_auto_start'    => ini_get('session.auto_start'),
      'mbstring'              => extension_loaded('mbstring'), 
      'utf8_decode'           => function_exists('utf8_decode'),
      'exec'                  => function_exists('exec'),
   ],
];