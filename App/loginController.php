<?php
use App\Base\Base;
use App\Base\Auth;
use Helpers\Helpers;
class login extends Base
{


    private $auth;

    public function __construct()
    {
        parent::__construct();
        Auth::isLoged();
        if(Auth::$logged){
            Auth::redireccionar('inicio');
        }

    }

    /**

    /**
     * Evento principal, el cual es llamado para mostrar la interfaz.
     */
    public function index()
    {
        $this->vista->ObtenerVista("auth/login");
    }

    public function event(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST["email"]) && !empty($_POST["clave"])){
            $user = [
                "email" => $_POST["email"],
                "password"=> $_POST["clave"]
            ];
            $this->Authenticate($user);
        }else{
            Helpers::setFlashMessage('warning','Usuario o clave incorrectas, intentelo nuevamente.');
            Auth::redireccionar('login');
        }

    }


    /**
     * Administra el evento de login, valida si un usuario se logueo y lo redirecciona al home o login segun
     * sea el caso.
     */
    private function Authenticate(array $user){

            //Validamos la informacion y lo redireccionamos a la vista correspondiente.
            Auth::validate($user)->redireccionar('inicio');

    }
}