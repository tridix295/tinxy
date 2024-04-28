<?php
namespace App\Modelos;
use App\Base\SQL;

/**
 * Modelo inicial responde a las peticiones de http://[host]/ o http://[host]/inicio 
 */
class inicio extends SQL{

    /**
     * @var string $tabla Corresponde a la tabla principal con la cual estara interactuando nuestro modelo.
     */
    private $tabla = "libros";


    public function __construc(){
        //Instanciamos nuestra base de datos _SQL
        parent::__construc();
    }

    /**
     * Funcion para obtener un registro de la tabla {$tabla}
     * @param string $formato Corresponde al formato en el cual devemos devolver los registros.
     */
    public function Obtener($formato = "json") {
        // Definimos los joins que estaremos usando en la consulta
        $joins = [
            ['tabla' => 'autores', 'alias' => 'A', 'condicion' => 'A.id_autor = T.id_autor', 'tipo' => 'INNER'],
            ['tabla' => 'generos', 'alias' => 'G', 'condicion' => 'G.id_genero = T.id_genero', 'tipo' => 'INNER']
        ];
    
        // Generar los joins
        $this->generarJoins($joins);
    
        // Definimos los formatos disponibles a partir de funciones anonimas, lo cual nos permite invocarlos de manera mas flexible.
        $formatos = [
            "json" => function ($x) {
                return json_encode($x);
            },
            "array" => function ($x) {
                return $x;
            }
        ];
    
        // Verificar si el formato solicitado está disponible, de no ser lanzamos una exepcion que finalizar el proceso.
        if (!array_key_exists($formato, $formatos)) {
            throw new \Exception("Formato no válido: $formato");
        }
    
        // Construir la consulta SQL con los joins
        $sql = "SELECT * FROM {$this->tabla} AS T {$this->join} ORDER BY TIID ASC";
    
        // Ejecutar la consulta y obtener los resultados
        $resultados = $this->BuscarTodo($sql);
    
        // Aplicar el formato solicitado a los resultados
        $resultadoFormateado = $formatos[$formato]($resultados);
    
        // Devolver los resultados formateados
        return $resultadoFormateado;
    }

}