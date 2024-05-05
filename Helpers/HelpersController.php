<?php
namespace Helpers;

use Helpers\sessionClient;
class Helpers{

    use sessionClient;

    /**
     * Funcion para divir una url en sus diferentes componentes, para esto como regla definimos que el primer elemento
     * sera el controlador, el segundo el metodo, y cualquier elemento delante de este correspondra como parametro
     * @param string $url Peticcion http (url)
     * @return mixed Devolvemos los componentes formateados para trabajar bajo el modelo MVC (controlador, modelo, parametros)
     */
    public static function dividirURL(string $url): array{

        //Convertimos todos los caracteres en minusculas, esto para evitar problemas de mayusculas y minusculas.
        $url = strtolower($url);

        /*
        * Dividimos la url en sus componentes, cuyo resultados sera un array
        * Ejem. http://www.bugbountyhunter.com/hackevents/report/873
        * [0] -> hackevents
        * [1] -> report
        * [2] -> 873
        */
        $partes = explode('/',$url);

        //Divimos las partes en lo que nos interesa.
        $controller = isset($partes[0]) ? $partes[0] : $url;
        $method = isset($partes[1]) ? $partes[1] : 'index';
        
        /*Cualquier elemento a partir del indice 3 corresponde a un parametro, por lo que borramos primero los dos elementos
        * (controlador y modelo) para despues convertir el array en un string separando coda elemeto con una ´,´
        * ejem. (873,24,35)
        */
        $parametros = isset($partes[2]) ? implode(',',array_slice($partes,2)) : null;

        //Por ultimo construimos el array que vamos a devolver
        $request = [
            "controlador" => $controller,
            "metodo" => $method,
            "parametros" => $parametros
        ];
        return $request;
    }
    public static function getCsrf()
    {
        return bin2hex(random_bytes(32));
    }
    public static function setFlashMessage ($key, $mensaje) {
        self::getInstance();
        self::setSession(["flash_Message" => [
                $key => $mensaje
        ]]);
    }

    public static function getFlashMessage () {
        $mensaje = self::getElementSession("flash_Message");
    
        // Elimina el mensaje flash después de leerlo
        self::destroySession(["flash_Message"]);
        return $mensaje;
    }

    public static function show_header(){
        self::getInstance();
        $usuario['UsId'] = self::getElementSession("UsId");
        $usuario["UsTipoUsuario"] = self::getElementSession("UsTipoUsuario");
        $usuario["UsNombre"] = self::getElementSession("UsNombre");

        if(!empty($usuario['UsId'])){
            include Path_App . "/Vistas/Partials/fields_admin.php";
        }else{
            echo '<ul class="nav nav-pills">
                <li class="nav-item"><a href="/login" class="nav-link" aria-current="page">Iniciar sesion</a></li>
                <li class="nav-item"><a href="/registro" class="nav-link" aria-current="page">Registrate</a></li>
                </ul>';
        }
    }
}
