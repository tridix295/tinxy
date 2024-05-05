<?php
namespace App\Base;

use Helpers\hash;
use App\Modelos\Usuarios;
use Helpers\sessionClient;
use Helpers\Helpers;

/**
 * clase para administrar los procesos de autenticacion.
 */
class Auth{
    /**
     * Inicializar el administrador de sesiones.
    */
    use sessionClient;

    public static $logged = false;


    public static function registrar(Array $request){
        self::store($request);
        return new self();
    }

    public static function logout(){

        self::killSession(session_id());
        self::redireccionar('inicio');
    }

    /**
     * Indica si el usuario se encuentra logueado.
     * @return bool
     */
    public static function login():bool {
        return self::$logged;
    }

    private static function store(array $request){
        
        //Obtenemos la clave del usuario en caso de que encuentre algun registro con el correo dado.
        $user = Usuarios::BuscarUsuario($request["email"], "UsTipoUsuario,UsId");
        //Si no encuentra ningun registro crea el usuario.
        if(!$user){
            
            $pass = hash::generatePasswordHash($request['clave']);
            $user = Usuarios::Add([
            'UsTipoUsuario' => 0,
            'UsNombre' => $request['usuario'], 
            'UsApellidos' => $request['apellidos'],
            'UsEmail' => $request['email'],
            'UsFechaNacimiento' => $request['nacimiento'],
            'UsPassword' => $pass]);

            $user = Usuarios::BuscarUsuario($request['email'],'UsTipoUsuario,UsPassword,UsNombre,UsId');
            unset($user['UsPassword']);
            self::setSession($user);
            Helpers::setFlashMessage('success','El usuario se registro de manera correcta.');
            return new self();
        }else{

            Helpers::setFlashMessage('warning','El usuario no se pudo registrar, intente nuevamente.');
            self::redireccionar('registro');
            exit();
        }
    }

    /**
     * Valida si encuentra una session activa, de ser asi no lo deja ingresar al login o registro.
    */
    public static function isLoged(){

        self::$logged = self::getElementSession('UsId');
        if(!self::$logged && strpos($_SERVER['REQUEST_URI'],'login') === false && strpos($_SERVER['REQUEST_URI'],'registro') === false){
           self::redireccionar('login');
        }
    }

    
    /**
     * Valida si un usuario puede autenticarse o no de manera satisfactoria.
     * @param string $pass Contrase�a digitada.
     * @return auth
    */
    public  static function validate(array $usuario){

        $user = Usuarios::BuscarUsuario($usuario['email'],'UsTipoUsuario,UsPassword,UsNombre,UsId');
        
        if($user){
            $pass = hash::verifyPasswordHash($usuario['password'],$user['UsPassword']);
            if($pass){
                unset($user['UsPassword']);
                Helpers::setFlashMessage('success',"Bienvenido {$user['UsNombre']}");
                self::setSession($user);
            }

        }else{
            Helpers::setFlashMessage('warning','Usuario o clave incorrectas, intentelo nuevamente.');
            self::redireccionar('login');
            exit();
        }
        return new self();
    }

    /**
     * Almacena la sesion de un usuario especifico.
     * @param string $tipo tipo de usuario
     * @param string $Id Id del usuario
    */
    private static function guard($tipo,$Id) {
        self::setSession(["UsId" => $Id, 'UsTipo' => $tipo]);
        self::$logged = true;
    }

    /**
     * Redirecciona un usuario a una vista en especifico.
     * @param string Vista
    */
    public static function redireccionar( string $view = 'login')
    {
        header("Location: /$view");
    }
}