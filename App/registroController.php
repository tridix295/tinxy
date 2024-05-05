<?php
use App\Base\Base;

use App\Base\Auth;
use App\Modelos\Usuarios;

    class registro extends Base{

        private static $view;

        public function __construct()
        {
            parent::__construct();
            Auth::isLoged();
            if(Auth::$logged){
                Auth::redireccionar('inicio');
            }
        }

        public function index(){
           $this->vista->ObtenerVista("auth/registro");
         
        }
    
        /**
        * Evento insert
        */
        public function add(){
            $this->store();
        }

        private function store(){
            
            if(isset($_SERVER['REQUEST_METHOD']) == 'POST'){
                $usuario = [
                    'usuario'=> $_POST['usuario'],
                    'apellidos'=> $_POST['apellidos'],
                    'email'=> $_POST['email'],
                    'nacimiento'=> $_POST['nacimiento'],
                    'clave'=> $_POST['clave'],
                ];

                Auth::registrar($usuario)->redireccionar('inicio');
            }

        }
    }
?>