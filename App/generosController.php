<?php
use App\Base\Base;
use App\Base\Auth;

class Generos extends Base{
    public function __construct(){
        parent::__construct();
        Auth::isLoged();
    }

    public function index(){
        $datos[200] = $this->modelo->BuscarTodo("SELECT * FROM generos");
        $this->vista->ObtenerVista("generos",$datos);
    }
    public function editar($id){
        
    }
    public function eliminarGenero($id){
        if(1 == 1){
           // $data = file_get_contents("php://input");
            $data['id'] = 10020;
            if(isset($data["id"])){
                $status = $this->modelo->Eliminar($data['id']);var_dump($status);
                if(!$status){  
                    echo json_encode(array("message" => "El registro no pudo ser eliminado ya que hay registros asociados"));
                }
            }

            
        }else{
            http_response_code(403);
        }
    }
}
?>