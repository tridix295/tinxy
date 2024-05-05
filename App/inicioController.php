<?php

use App\Base\Base;
use App\Base\Auth;
class inicio extends Base{

    public function __construct(){
        //Instanciamos el controlador base, el cual se encarga de invocar el modelo y la vista.
        parent::__construct();
        Auth::isLoged();
    }

    /**
     * Funcion principal del controlador, responder a http://[host]/
     */
    public function index(){
        //Obtenemos los datos limitandolo solo a 10 registros y se los enviamos a la vista.
        $datos = $this->modelo->limit(10)->obtener("array");
        $this->vista->ObtenerVista('index', $datos);
    }

    /**
     * Muestra la interfaz de administracion de libros.
     */
    public function Admin(){
        $this->vista->ObtenerVista('administrar');
    }

    /**
     * Obtiene los datos correspondientes a los libros.
     */
    public function obtenerDatos(){
        echo $this->modelo->Obtener();
    
    }
}
?>