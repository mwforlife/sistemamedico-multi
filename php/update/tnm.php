<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['descripcion']) ){
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    //Pasar a mayusculas
    $descripcion = $c->escapeString($descripcion);
    $result = $c->actualizartnm($id, $descripcion);
    if($result==true) {
        echo json_encode(array("status"=>true, "message"=>"Registro actualizado correctamente"));
    } else {
        echo json_encode(array("status"=>false, "message"=>"Error al actualizar el registro"));
    }
} else {
    echo json_encode(array("status"=>false, "message"=>"Error en los datos enviados"));
}
