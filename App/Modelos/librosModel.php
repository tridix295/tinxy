<?php
namespace App\Modelos;

use App\Base\SQL;

class libros extends SQL
{
    /**
     * @var string $tabla Tabla principal del modelo.
     */
    private $tabla = "libros";
    public function __construc()
    {
        //Instanciamos la clase SQL
        parent::__construc();
    }

    /**
     * Extrae registros de una tabla.
     *
     * @param string $tabla Nombre de la tabla.
     * @param string $campo Campos a seleccionar en la consulta.
     * @param string $condicion Condición opcional para filtrar los resultados.
     * @return array Arreglo con los resultados de la consulta.
     */
    public function extraer($tabla, $campo = "*", $condicion = "")
    {
        $query = "SELECT $campo FROM $tabla ";
        // Construcción de la condición WHERE
        $whereClause = empty($condicion) ? "" : " WHERE $condicion";

        //Si en la consulta existe algun join se lo agregamos.
        $query = !empty($this->join) ? $query . $this->join : $query;

        $query .= $whereClause;
        // Ejecución de la consulta y retorno de los resultados
        return $this->Buscar($query); 
    }


    /**
     * Elimina un registro de la base de datos.
     *
     * @param int $id Identificador del registro a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function Eliminar($id)
    {
        $query = "DELETE FROM " . $this->tabla . " WHERE tiid = $id";
        return $this->Delete($query);
    }

    /**
     * Funcion para registrar un libro
     * @param array $datos Corresponde a los datos del libro, como, titulo, isbn, etc.
     * @return int Devuelve el id del registro insertado
     */
    public function AgregarLibro(array $datos)
    {
        $datos["autor"] = $this->AgregarAutor($datos['autor']);

        $query = "INSERT INTO libros (titulo, fecha, id_genero, id_autor, isbn, comentarios, imagen) 
        VALUES (:titulo, :fecha, :genero, :autor, :isbn, :descripcion, :imagen)";

        return $this->Insertar($query, $datos);
       
    }

    /**
     * Funcion para agregar un autor.
     * @param string $buscar Nombre del autor
     * @return int Devulve el id del autor en caso de ser agregado o ya exista.
     */
    private function AgregarAutor(string $buscar){
        //Consultamos primero si el autor existe, de no ser asi lo agregamos.
        $autor = $this->extraer('autores', 'id_autor', "Anombre = '$buscar'");

        if (!$autor) {

            //Preparamos la consulta y lo agregamos en la BD
            $agregarAutor = "INSERT INTO autores VALUES(null,:nombre)";
            $autor['id_autor'] = $this->Insertar($agregarAutor, ['nombre' => $buscar]);
        }
        return $autor['id_autor'];
    }

    /**
     * Actualiza la información de un libro en la base de datos.
     *
     * @param array $datos Nuevos datos del libro.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function ActualizarLibro($datos)
    {
        //Validamos que el autor ingresado exista, de no ser asi lo agregamos.
        $datos["autor"] = $this->AgregarAutor($datos["autor"]);

        //Preparamos la consulta, donde a cada campo le coresponde la referencia :array_key
        $query = "UPDATE libros set titulo = :titulo,fecha = :fecha,id_genero = :genero,id_autor = :autor,
        isbn = :isbn,comentarios = :descripcion,imagen = :imagen WHERE tiid = " . $datos["id"];

        //Dentro de la solicitud entrante tenemos el id de registro, sin embargo al enviarlo junto con los datos preparados genera una incongruencia con los datos que debe hacer match.
        unset($datos["id"]);

        return $this->Actualizar($query, $datos);
    }

    public function Editar(int $id){
        $joins = [['tabla' => 'autores', 'alias' => 'A', 'condicion' => 'A.id_autor = T.id_autor', 'tipo' => 'INNER'],
        ['tabla' => 'generos', 'alias' => 'G', 'condicion' => 'G.id_genero = T.id_genero', 'tipo' => 'INNER']];
        $this->generarJoins($joins);

        $datos = $this->extraer("libros as T", "*","tiid = $id");
        return $datos;
        
    }

}

?>