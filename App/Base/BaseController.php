<?php
namespace App\Base;

/*Controlador padre, el cual se va a encargar de comunicar el modelo y la vista
* Al instaciar la vista le estamos indicando al autoload que lo cargue y sera almacenado en la propiedad view el cual podra ser accesible desde el controlador.
*/
class Base{
    /**
     * @var object $modelo Instancia del modelo en funcion del controlador que se este utilizando.
     */
    protected $modelo;
    
    /**
     * @var object $vista Instancia de la vista en funcion del controlador que se este utilizando.
     */
    protected $vista;

    /**
     * Constructor de la clase.
     * Este método se llama automáticamente cuando se instancia un objeto de la clase.
    */
    public function __construct(){
        // Obtiene el nombre de la clase del objeto actual
        $NombreModelo = get_class($this);

        // Construye el nombre completo de la clase del modelo utilizando el espacio de nombres App\Modelos
        $NombreClase = "\\App\\Modelos\\{$NombreModelo}";
    
        // Instancia un objeto del modelo utilizando el nombre de la clase construido
        $this->modelo = new $NombreClase();

        // Instancia un objeto de la clase Vistas
        $this->vista = new Vistas();
}


}


?>