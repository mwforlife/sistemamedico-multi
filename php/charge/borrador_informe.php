<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['paciente']) && isset($_POST['comite'])){
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];

    $borrador = $c->listaborradorinforme($paciente, $comite);
    if($borrador!=null){
        $id = $borrador['id'];
        $tnm = $c->listartnmborrador($id);

        echo json_encode(array("status" => true, "informe" => $borrador, "tnm" => $tnm));
    }else{
        echo json_encode(array("status" => false, "message" => "No se encontró el borrador del informe"));
    }
}else{
    echo json_encode(array("status" => false, "message" => "No se recibieron los datos"));
}