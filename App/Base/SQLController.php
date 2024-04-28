<?php
namespace App\Base;

/**
 * Clase SQL que extiende de Connexion_BD para interactuar con la base de datos mediante consultas SQL.
 */
class SQL extends Connexion_BD{
    /**
     * @var object $conexion Objeto de conexión a la base de datos.
     */
    private $conexion;

    /**
     * @var string $strquery Consulta SQL a ejecutar.
     */
    private $strquery;

    /**
     * @var array $arrvalues Array de valores para la consulta preparada.
     */
    private $arrvalues;

    /**
     * @var string $join Sentencia JOIN para unir tablas en las consultas.
     */
    public $join;

    /**
     * @var int|null $limit Límite de resultados para consultas SELECT.
     */
    protected $limit = null;

    /**
     * Constructor de la clase.
     * Establece la conexión a la base de datos al instanciar un objeto SQL.
     */
    public function __construct()
    {
        parent::__construct();
        //Obtenemos la conexion a la base de datos
        $this->conexion = $this->ObtenerConnect();
        if(!is_object($this->conexion)){
            //Para poder trabajar necesitamos la conexion, de no ser asi matamos la ejecucion del proceso.
            die('<script>alert("Error Al conectarse a la BD.")</script>');
        }
    }
    /**
     * Cierra la conexión a la base de datos.
    */
    public function CerrarConexion():void{
       // $this->conexion = null;
    }

    /**
     * Inserta un registro en la base de datos.
     *
     * @param string $query Consulta SQL preparada con marcadores de posición.
     * @param array $values Valores a insertar en la consulta preparada.
     * @return int ID del último registro insertado.
     */
    public function Insertar(string $query, array $values){
        $this->strquery = $query;
        $this->arrvalues = $values;

        $insert = $this->conexion->prepare($this->strquery);
        $resinsert = $insert->execute($this->arrvalues);
        if($resinsert){
            $lastinsert = $this->conexion->lastInsertId();
        }else{
            $lastinsert = 0;
        }

        // Retorna el ID del último registro insertado
        return $lastinsert;
    }

    /**
     * Agrega una sentencia JOIN a la consulta SQL.
     *
     * @param string $campo Campo de la tabla a unir.
     * @param string $valor Valor del campo a unir.
     * @param string $alias (Opcional) Alias para la tabla.
     * @return SQL Objeto SQL con la sentencia JOIN agregada.
     */
    public function Join($campo, $valor,$alias = ""):SQL{
        $this->join .= " JOIN $campo";
        if (!empty($alias)) {
            $this->join .= " AS $alias";
            $valor = "$alias.$valor";
        }
        $this->join .= " ON $valor";
        return $this;
    }

    /**
     * Genera sentencias JOIN múltiples para la consulta SQL.
     *
     * @param array $joins Arreglo de configuraciones de JOIN.
     * ['tabla' => '','tipo' => '', 'condicion' => '']
     */
    function generarJoins($joins) {
        $queryJoins = "";
        foreach ($joins as $join) {
            $tabla = $join['tabla'];
            $alias = isset($join['alias']) ? $join['alias'] : null;
            $tipo = isset($join['tipo']) ? $join['tipo'] : 'INNER';
            $condicion = isset($join['condicion']) ? "ON " . $join['condicion'] : '';
            
            $queryJoins .= "$tipo JOIN $tabla";
            if ($alias) {
                $queryJoins .= " AS $alias";
            }
            if ($condicion) {
                $queryJoins .= " $condicion";
            }
            $queryJoins .= " ";
        }
        $this->join = $queryJoins;
    }

    /**
     * Busca un solo registro en la base de datos.
     *
     * @param string $query Consulta SQL.
     * @return array|null Arreglo asociativo con los datos del registro encontrado.
     */
    public function Buscar(string $query){
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $result = $result->fetch(\PDO::FETCH_ASSOC);
        $this->CerrarConexion();
        return $result;
    }

    /**
     * Busca todos los registros que coincidan con la consulta SQL.
     *
     * @param string $query Consulta SQL.
     * @return array Arreglo multidimensional con los registros encontrados.
     */
    public function BuscarTodo(string $query):array{
        if($this->limit != null){
            $query .= " LIMIT ". $this->limit;
        }
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $result = $result->fetchAll(\PDO::FETCH_ASSOC);
        $this->CerrarConexion();
        return $result;
    }

    /**
     * Establece un límite para la cantidad de resultados en las consultas SELECT.
     *
     * @param int $limit Límite de resultados.
     * @return SQL Objeto SQL con el límite establecido.
     */
    public function limit(int $limit):SQL{
        $this->limit = $limit;
        return $this;
    }

    /**
     * Actualiza registros en la base de datos.
     *
     * @param string $query Consulta SQL preparada con marcadores de posición.
     * @param array $values Valores a actualizar en la consulta preparada.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function Actualizar(string $query, array $values){
        $this->strquery = $query;
        $this->arrvalues = $values;

        $update = $this->conexion->prepare($this->strquery);

        $update = $update->execute($this->arrvalues);
        $this->CerrarConexion();
        return $update;
    }

    /**
     * Elimina registros de la base de datos.
     *
     * @param string $query Consulta SQL.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function Delete(string $query):bool|\PDOStatement{

        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $this->CerrarConexion();
        return $result;
    }
}

?>