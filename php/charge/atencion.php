<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $paciente = $c->buscaridpacientereserva($id);
    if($paciente!=null && $paciente>0){
        echo json_encode(array("error"=>false,"paciente"=>$paciente,"id"=>$id,"mensaje"=>"Se encontró el paciente"));
    }else{
        echo json_encode(array("error"=>true,"mensaje"=>"No se encontró el paciente"));
    }
}else{
    echo json_encode(array("error"=>true,"mensaje"=>"No se encontró el paciente"));
}