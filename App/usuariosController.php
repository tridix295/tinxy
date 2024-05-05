<?php

use App\Base\Base;
use App\Base\Auth;
class usuarios extends Base
{
    public function __construct(){
        parent::__construct();
        //Auth::isLoged();
    }
    public function index(){

    }
    public function logout(){
        Auth::logout();
    }
    
    public function edit(int $id){

        if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($id)){
            $usuario = $this->modelo->BuscarUsuario($id,'UsId','UsId,UsNombre,UsApellidos,UsEmail,UsFechaNacimiento,UsPassword');
            //var_dump($user);
            $this->vista->ObtenerVista('usuarios/edit',$usuario);
        }
        
    }

    public function admin(){
        $usuarios = $this->modelo->BuscarTodo("SELECT * FROM usuarios");
        $this->vista->ObtenerVista("usuarios/admin",$usuarios);
    }
    public function buscar(){
        var_dump($_REQUEST);
    }
}