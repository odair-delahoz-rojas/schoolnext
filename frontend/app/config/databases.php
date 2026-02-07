<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de conexión a la base de datos
 */

return [
    //Conexión a Mysql (para el antiguo active_record)
    'default' => [
      'dsn'      => 'mysql:host=127.0.0.1;dbname=windsor1_schoolnext;charset=utf8',
      'username' => 'root',
      'password' => '',
      'params'   => [
        //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //UTF8 en PHP < 5.3.6
         \PDO::ATTR_PERSISTENT => \true, //conexión persistente
         \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION
      ],
    ],

    // Conexión a Mysql (LITERECORD)
    'development' => [
      'host'     => 'localhost', // ip o nombre del host de la base de datos
      'username' => 'root', // usuario con permisos en la base de datos [no es recomendable usar el usuario root]
      'password' => '', // clave del usuario de la base de datos
      'name'     => 'windsor1_schoolnext', //  nombre de la base de datos
      'type'     => 'mysql',  // tipo de motor de base de datos (mysql, pgsql, oracle o sqlite)
      'charset'  => 'utf8', // Conjunto de caracteres de conexión, por ejemplo 'utf8'
      //'dsn' => '', // Cadena de conexión a la base de datos
      //'pdo' => 'On', // activar conexiones PDO (On/Off); descomentar para usar
    ],

    'windsor' => [
      'host'     => 'localhost', //  ip o nombre del host de la base de datos
      'username' => 'windsor1_schoolnext', // usuario con permisos en la base de datos [no es recomendable usar el usuario root]
      'password' => 'uVqvgKRNW@ay', //  clave del usuario de la base de datos
      'name'     => 'windsor1_schoolnext', // nombre de la base de datos
      'type'     => 'mysql', // tipo de motor de base de datos (mysql, pgsql o sqlite)
      'charset'  => 'utf8', // Conjunto de caracteres de conexión, por ejemplo 'utf8'
      //'dsn' => '', // cadena de conexión a la base de datos
      //'pdo' => 'On',  //  activar conexiones PDO (OnOff); descomentar para usar
    ],
    
    'santarosa' => [
      'host'     => 'localhost', //  ip o nombre del host de la base de datos
      'username' => 'u113041793_nextsantarosa', // usuario con permisos en la base de datos [no es recomendable usar el usuario root]
      'password' => 'n@MJH9+m', //  clave del usuario de la base de datos
      'name'     => 'u113041793_nextsantarosa', // nombre de la base de datos
      'type'     => 'mysql', // tipo de motor de base de datos (mysql, pgsql o sqlite)
      'charset'  => 'utf8', // Conjunto de caracteres de conexión, por ejemplo 'utf8'
      //'dsn' => '', // cadena de conexión a la base de datos
      //'pdo' => 'On',  //  activar conexiones PDO (OnOff); descomentar para usar
    ],
];

/**
 * Ejemplo de SQLite
 */
/*'development' => [
    'type' => 'sqlite',
    'dsn' => 'temp/data.sq3',
    'pdo' => 'On',
] */
