<?php

namespace Helpers;

use Helpers\Helpers;

trait sessionClient
{


    //Tiempo de vida de la sesion
    private static $expire = 3600;

    //Instancia de nuestos objecto
    private static $instance;

    protected static $session_id;

    public function __construct(){
                //Comprobamos si la sesion ya esta activa
                if (session_id() === '') {
                    //Definimos el tiempo de vida para las sesiones y cookies
                    ini_set('session.gc.maxlifetime', self::$expire);
                    session_set_cookie_params(self::$expire);
        
                    //Iniciamos la sesionn
                    session_start();
                    session_regenerate_id(true);
                    self::$session_id = session_id();
                }else{
                    self::$session_id = session_id();
                }
    }
    /**
     * Configuracion inicial para trabajar con sessiones.
     * @return sessionClient
     */

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getSessionId(){
        return self::$session_id;
    }

    /**
     * Funcion para obtener un elemento especifico de la sesion del usuario
     * @param string $element Elemento a bucar dentro de la session.
     * @return string|bool
     */
    protected static function getElementSession(string $element, array $array = null) {
        // Inicia la sesión si no está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        // Define el array a buscar
        if ($array === null) {
            $array = $_SESSION;
        }
    
        // Verifica si el elemento existe en el array actual
        if (isset($array[$element])) {
            return $array[$element];
        }
    
        // Busca recursivamente en arrays multidimensionales
        foreach ($array as $value) {
            if (is_array($value)) {
                $result = self::getElementSession($element, $value);
                if ($result !== null) {
                    return $result;
                }
            }
        }
    
        // Si el elemento no se encuentra, devuelve null
        return null;
    }
    

    /**
     * A partir de un parametro array los almacena en una sesion.
     * @param mixed $session valores a almacenar en la sesion => ['UsId' => 1, 'UsTipo' => 1]
     * @return void
     */
    protected static function setSession(Array $session): void{
        $user = self::getInstance()->getSessionId();
        foreach($session as $index => $value){
            if(!isset($_SESSION[$index])){
                $_SESSION[$user][$index] = $value;
            }
        }
    }
    
    /**
     * Funcion para generar un token CSRF
     * @return string
     */
    private function generateCsrfToken()
    {
        return Helpers::getCsrf();
    }
    /**
     * Funcion para generar un token y ser almacenada en una sesion de manera persistente.
     * @return $this
     */
    protected function createToken()
    {
        $_SESSION['csrf_token'] = $this->generateCsrfToken();
        $_SESSION['enlapsed_time'] = time();
        return $this;
    }
    protected static function killSession(string $session_id) {
        // Inicia la sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Asigna el ID de sesión proporcionado
        session_id($session_id);
    
        // Destruye la sesión
        session_destroy();
    }
    
    /**
     * Funcion para destruir una o varios elementos dentro de la session.
     * @param mixed $elements Elementos/indices a eliminar de la sesion.
     */
    protected static function destroySession(array $elements = []) {
        // Inicia la sesión si no está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        // Elimina los elementos proporcionados
        foreach ($elements as $element) {
            self::unsetElementSession($element, $_SESSION);
        }
    }
    
    protected static function unsetElementSession(string $element, array &$array) {
        // Verifica si el elemento existe en el array actual
        if (isset($array[$element])) {
            unset($array[$element]);
            return;
        }
    
        // Busca recursivamente en arrays multidimensionales
        foreach ($array as &$value) {
            if (is_array($value)) {
                self::unsetElementSession($element, $value);
            }
        }
    }

    /**
     * Valida si un token es valido o no y destruye al sesion al finalizar.
     * @param string $token Token a validar segun los datos almacenados en la sesion del usuario.
     * @return bool
     */
    protected function validateToken(string $token):bool
    {

        $status = hash_equals($this->getElementSession('csrf_token'), $token);
        $this->destroySession(['csrf_token']);

        return $status;
    }

    /**
     * Funcion para regenerar una sesion cuando esta ya ah expirado.
     * @return void
     */
    protected function regenerateSession()
    {
        if ($this->getElementSession('enlapsed_time') and (time() - $this->getElementSession('enlapsed_time')) > $this->expire) {
            session_regenerate_id(true);
            $_SESSION['enlapsed_time'] = time();
        }
    }
}