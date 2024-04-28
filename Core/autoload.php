<?php
/**
 * Esta funcion se encarga de cargar las clases que sean heredadas del controlador padre en funcion del 
 * nameespace del padre.
 *   Ejem.
 *   /Core/...
 *       {Controller_Home} extends baseController...
 *   /Helpers/...
 *       {class_helper} extends Messages...
 */
function ObtenerClase($nombre){

    /**
     * Si la clase que vamos a registrar tiene un namespace este estara concatenado al nombre de la clase,
     * Por lo tanto para poder instanciarlo es necesario convertirlo en una ruta legible para el sistema operativo.
     *
     * Al tener los modelos y controladores en una misma ruta (App) necesitamos diferencialos
     */
    $nombre = str_replace('\\','/',$nombre);
    $archivo = Path_App .'/' . $nombre . 'Controller.php';

    if(strpos($archivo,'Modelos')){
        $archivo = Path_App .'/' . $nombre . 'Model.php';
    }
    if(file_exists($archivo)){
        require_once $archivo;
    }
}

//Cargamos la clase para que sea registrada.
spl_autoload_register('ObtenerClase');
?>
