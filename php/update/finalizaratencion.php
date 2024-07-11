<?php
session_start();
if(!isset($_SESSION['USER_ID'])){
    echo json_encode(array('status' => false, 'message' => 'Error al finalizar la atención'));
    return;
}

$usuario = $_SESSION['USER_ID'];
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->actualizaratencion($id,5,"Atención finalizada");

    if($result==true){
        echo json_encode(array('status' => true, 'message' => 'Atención finalizada'));
        $c->registrarhistorialestado($id,5,"Atención finalizada",$usuario);
        $c->finalizaratencion($id);
    }else{
        echo json_encode(array('status' => false, 'message' => 'Error al finalizar la atención'));
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'Error al finalizar la atención'));
}