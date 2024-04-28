<?php 
namespace App\Base;

class Connexion_BD {

    /**
     * @var object $Connexion variable que guardara la instancia de la conexion.
     */
    private $Connexion;

    /**
     * @var string $Usuario Usuario con los permisos necesarios para poder ingresar a la base de datos.
     */
    private $Usuario;

    /**
     * @var string $Clave Clave del usuario para ingresar a la base de datos.
     */
    private $Clave;

    /**
     * @var string $servidor Host del del servidor donde se aloja la base de datos.
     */
    private $Servidor;

    /**
     * @var int $Puerto Numero del puerto usado para poder conectarse a la base de datos, comunmente 3306 o 3307 
     */
    private $Puerto;

    /**
     * @var string $DBNombre Nombre de la base de datos a la cual nos estaremos conectando.
     */
    private $BDNombre;

    public function __construct()
    {
        //Seteamos la configuracion en funcion de los valores en Config.php
        $this->Usuario = DBUsuario;
        $this->Clave = DBClave;
        $this->Puerto = DBPuerto;
        $this->Servidor = DBServidor;
        $this->BDNombre = DBNombre;
    }

    private function Connectar(){

        //Establecemos la estructura de nuestra conexion a la base de datos.
        $Conexion = 'mysql:host=' . $this->Servidor . ';port=' . $this->Puerto . ';dbname=' . $this->BDNombre . ';';

        try {
            //Definimos la instancia de la conexion y le pasamos los parametros de la conexion al constructor.
            $this->Connexion = new \PDO($Conexion, $this->Usuario, $this->Clave);

            //Establecemos el reporte de errores de PDO y el manejo de exepciones, al estar usando espacios de nombres debemos agrear la referecia ´\' a llame a la clase desde la raiz de php.
            $this->Connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $th) {

            //En caso de fallar obtenemos el mensaje de la exepcion.
            $tiempo = date('Y-m-d H:i:s');
            $this->Connexion = '<---' . $tiempo . '---> Error al conectar =>'. $th->getMessage();
        }
    }

    /**
     * Funcion para generar una conexion con la base de datos.
     * @return object Connexion
     */
    public function ObtenerConnect(){
        $this->Connectar();
        return $this->Connexion;
    }
}

?>