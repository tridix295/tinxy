<?php
namespace App\Base;

/**
 * Clase para invocar las vistas y/o interfaces de usuario
 */
class Vistas{
    /**
     * @var mixed $datos Variable donde se almacenaran los datos que se estaran usando en la vista en caso de ser necesario.
     */
    private $datos;

    /**
     * Funcion para obtener una vista
     * @param string $vista nombre del archivo que corresponde a la vista que se estara invocando
     * @param mixed $datos Datos que se pueden enviar a la interfaz, como por ejemplo datos del usuario.
     * @return void
     */
    public function ObtenerVista(string $vista, $datos = []):void {

        //Construimos la ruta de la vista
        $path = Path_App . "/Vistas/$vista.php";

        //Validamos que la vista exista, de no ser asi finalizara la ejecucion del codigo.
        if(!isset($path)){
            die('Vista no encontrada ' . $path);
        }

        //Incluimos la estructura de la interfaz {header}{vista}{footer}
        include_once Path_App . "/Vistas/Partials/header.php";
        include_once($path);
        include_once Path_App . "/Vistas/Partials/footer.php";
    }
}
?>