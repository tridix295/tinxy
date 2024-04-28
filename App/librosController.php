<?php
use App\Base\Base;

class libros extends Base
{
    private $datos;

    public function __construct()
    {
        parent::__construct();
    }
    public function registrar()
    {
        // Verificamos si se recibieron los datos del formulario mediante POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Acceder a los datos del formulario enviados mediante POST
            $this->datos = [
                'titulo' => trim($_POST["titulo"]),
                'fecha' => trim($_POST["fecha"]),
                'genero' => trim($_POST["genero"]),
                'autor' => trim($_POST["autor"]),
                'isbn' => trim($_POST["isbn"]),
                'descripcion' => trim($_POST["descripcion"])
            ];


            // Manejar la carga de la imagen
            $imagen = $this->manejarImagen();

            // Agregar la imagen al array de datos
            $this->datos['imagen'] = $imagen;

            $request = $this->modelo->AgregarLibro($this->datos);

            header('Location: ' . URL . 'inicio/admin');

            }
    }

    public function buscar(int $id)
    {
        $joins = [['tabla' => 'autores', 'alias' => 'A', 'condicion' => 'A.id_autor = T.id_autor', 'tipo' => 'INNER'],
                    ['tabla' => 'generos', 'alias' => 'G', 'condicion' => 'G.id_genero = T.id_genero', 'tipo' => 'INNER']];
        $this->modelo->generarJoins($joins);
        $datos = $this->modelo->extraer('libros as T', '*', "T.tiid = $id");

        echo json_encode($datos);
    }
    public function generos()
    {
        echo json_encode($this->modelo->BuscarTodo("SELECT * FROM generos"));
    }

    /**
     * Función para editar un libro.
     *
     * Esta función maneja tanto la presentación del formulario de edición como el procesamiento
     * de los datos enviados mediante POST para actualizar la información del libro.
     *
     * @param int|null $id El ID del libro a editar, sino muestra nada mostrara un formulario.
     * @return void
     */
    public function editar($id = null)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->procesarFormulario();
        } else {
            if ($id !== null) {
                $this->mostrarFormularioEdicion($id);
            }
        }
    }

    /**
     * Muestra un formulario para editar un libre en funcion del id indicado
     * @param int $id ID del libro a editar.
     */
    public function mostrarFormularioEdicion(int $id){
        $datos = $this->modelo->editar($id);
        $this->vista->ObtenerVista('editar',$datos);
    }
    

    /**
     * Procesa los datos enviados mediante POST para actualizar la información del libro.
     *
     * Esta función obtiene los datos del formulario, procesa la imagen adjunta y
     * actualiza la información del libro en la base de datos.
     *
     * @return void
     */
    private function procesarFormulario()
    {
        $datos = $this->obtenerDatosFormulario();
        $imagen = $this->manejarImagen();
        $datos['imagen'] = $imagen;
        $this->modelo->ActualizarLibro($datos);
        header('Location: ' . URL . 'inicio/admin');
    }
    
    /**
     * Obtiene los datos enviados mediante POST y los limpia.
     *
     * Esta función obtiene los datos enviados mediante POST y los limpia utilizando
     * la función trim() para eliminar espacios en blanco al inicio y al final de cada valor.
     *
     * @return array Los datos del formulario limpios.
     */
    private function obtenerDatosFormulario()
    {
        return array_map('trim', [
            'id' => $_POST["id"],
            'titulo' => $_POST["titulo"],
            'fecha' => $_POST["fecha"],
            'genero' => $_POST["genero"],
            'autor' => $_POST["autor"],
            'isbn' => $_POST["isbn"],
            'descripcion' => $_POST["descripcion"]
        ]);
    }
    /**
     * Realiza un busqueda en funcion del parametro de busqueda indicado $_POST['busqueda']
     * @return  void
     */
    public function consultar(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Indicamos las tablas con las que se estara uniendo la consulta.
            $joins = [['tabla' => 'autores', 'alias' => 'A', 'condicion' => 'A.id_autor = T.id_autor', 'tipo' => 'INNER'],
                        ['tabla' => 'generos', 'alias' => 'G', 'condicion' => 'G.id_genero = T.id_genero', 'tipo' => 'INNER'] ];
            $this->modelo->generarJoins($joins);

            //Preparamos la consulta y buscamos todos los registros, de no encontrar nada devolvera un 404 o 200.
            $query = "SELECT * from libros AS T {$this->modelo->join} WHERE CONCAT(TITULO, Gnombre,Anombre, ISBN)  LIKE '%".$_POST['busqueda']."%'";
 
            $request = $this->modelo->BuscarTodo($query);
            if($request){
                $datos['200'] = $request;
            }else{
                $datos['404'] = "Sin registros para consultar";
            }
        }
        //Invocamos la vista y le enviamos los datos correspondientes.
        $this->vista->ObtenerVista('buscar',$datos);
    }
    public function eliminar()
    {
        // Verificar si se recibió una solicitud POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verificar si se recibieron datos en formato JSON
            $data = json_decode(file_get_contents("php://input"), true);
            
            // Verificar si se recibió el ID del registro
            if (isset($data['id'])) {
                $id = $data['id'];


                $status =  $this->modelo->Eliminar($id);
                if(!$status){
                    http_response_code(403);
                    echo json_encode(array("message" => "El registro no pudo ser eliminado"));
                    die();
                }
                //respuesta con status 200
                http_response_code(200);
                echo json_encode(array("message" => "Registro eliminado correctamente"));
            } else {
                // Si no se recibió el ID, responder con un status 400 (Bad Request)
                http_response_code(400);
                echo json_encode(array("message" => "No se recibió el ID del registro"));
            }
        } else {
            // Si no se recibió una solicitud POST, responder con un status 405 (Method Not Allowed)
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido"));
        }
    }

    /**
     * Maneja la carga y procesamiento de la imagen del libro.
     *
     * Esta función se encarga de manejar la carga de la imagen del libro, procesarla si es necesario
     * y retorna la ruta de la imagen procesada.
     *
     * @return string La ruta de la imagen procesada.
     */
    private function manejarImagen()
    {
        //Verificamos que la imagen se haya subido de manera correcta.
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
            $imagenPath = $_FILES["imagen"]["tmp_name"]; // Ruta temporal del archivo
            $nombreImagen = $_FILES["imagen"]["name"]; // Nombre original del archivo
            $imagenDestino = Path_App . "/Public/img/$nombreImagen";

            // Mover el archivo de la ruta temporal a la ruta de destino
            if (move_uploaded_file($imagenPath, $imagenDestino)) {
                return "/img/$nombreImagen";
            } else {
                // Si ocurre un error al mover el archivo, devolver la ruta de la imagen por defecto
                return "/img/default.png";
            }
        } else {
            // Si no se recibió ninguna imagen, devolver la ruta de la imagen por defecto
            return "/img/default.png";
        }
    }

}
?>