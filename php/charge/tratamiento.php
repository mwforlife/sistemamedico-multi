<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id <= 0){
        echo json_encode(array('status' => false, 'message' => 'El id no puede ser menor o igual a 0'));
        return;
    }

    $receta = $c->recetasbyid($id);
    if($receta == null){
        echo json_encode(array('status' => false, 'message' => 'No se encontró la receta'));
        return;
    }

    echo json_encode(array('status' => true, 'tratamiento' => $receta['plantratamiento']));
}else{
    echo json_encode(array('status' => false, 'message' => 'No se recibió el id'));
}