<?php

/**
*   Ruta fisica de la aplicacion
*   Ejem.
*      define("Path_App","C:/wamp64/www/Proyecto"); -- Evitar espacios en los nombres
*/
define('Path_App','c:/biblioteca');

/**
*   Url de la aplicacion, sobre la cual accedemos desde el navegador.
*   define ("URL","http://localhost/");
*/
define ('URL','http://biblioteca/');

/**
* Datos con los cuales accedemos a la base de datos
* string DBNombre Nombre de la base de datos
* string DBServidor Servidor de la base datos
* int DBPuerto Puerto de la base sobre el cual estaremos ingresando
* string DBUsuario EL usuario que estaremos usando para realizar operaciones dentro
* la base de datos.
* string DBClave Clave del usuario
*/

define('DBNombre','tinxy');
define('DBServidor','localhost');
define('DBPuerto',3306);
define('DBUsuario','root');
define('DBClave','');
?>