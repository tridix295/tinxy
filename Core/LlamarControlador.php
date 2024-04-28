<?php
/**
 * Script principal para el procesamiento y cargue de los controladores en funcion de la
 * peticion http 
*/
require_once Path_App . '/Core/autoload.php';


use Helpers\Helpers;

//Obtenemos la url que nos llegue en la solicitud http, sino llega nada el valor por defecto sera ´inicio´
$url = $_GET['url'] ?? 'inicio';

//Dividimos la url en sus componentes.
$url = Helpers::dividirURL($url);

//Construimos la ruta del controlador y lo cargamos en caso de ser encontrado.
$controladorPath = Path_App . '/App/' . $url['controlador'] . 'Controller.php' ;

if(!file_exists($controladorPath)){
    die("Controlador no encontrado $controladorPath");
}

require_once $controladorPath;

// Por defecto el mismo nombre del controlador correspondera a la clase, por tanto necesitamos verificar que se cumpla esto.
if(!class_exists($url['controlador'])){
    die("La clase no esta definida: " . $url['controlador'] );
}

//En este punto entendemos que el controlador esta bien estructurado, por lo tanto lo instanaciamos y llamamos al metodo que se este invocando.
$controlador = new $url['controlador'];
$metodo = $url['metodo'];

if(!method_exists($controlador,$metodo)){
    die("El metodo $metodo no esta definido en el controlado $controladorPath");
}

//Por ultimo invocamos al metodo con los parametros en casso de existir
$parametros = $url['parametros'];
$controlador->$metodo($parametros);
?>