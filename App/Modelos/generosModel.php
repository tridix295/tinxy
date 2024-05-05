<?php
namespace App\Modelos;
use App\Base\SQL;

class generos extends SQL {
    public function __construct() {
        parent::__construct();
    }

    public function Eliminar(int $id){
        $query = "DELETE FROM generos WHERE id_genero = $id";
        $a = $this->Delete($query); var_dump($a);
        return $a;
    }
}