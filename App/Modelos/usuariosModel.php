<?php
namespace App\Modelos;

use App\Base\SQL;

class Usuarios extends SQL{


    protected static $table = 'usuarios';

    protected $primaryKey = 'UsId';
    
    public static function BuscarUsuario(string $user,$field = "UsEmail",string $campo = "UsPassword"):bool|array{
        $query = "SELECT $campo FROM " . self::$table . " WHERE $field = '$user'";
        $status = (new SQL)->Buscar($query);

        return $status;
       
    }
    public static function Add(array $usuario){
        $query = "INSERT INTO " . self::$table . " (UsTipoUsuario,UsNombre,UsApellidos,UsEmail,UsFechaNacimiento,UsPassword) 
                    VALUES (:UsTipoUsuario,:UsNombre,:UsApellidos,:UsEmail,:UsFechaNacimiento,:UsPassword)";
        
        $status = (new SQL)->Insertar($query,$usuario);
        return $status;
    }

}