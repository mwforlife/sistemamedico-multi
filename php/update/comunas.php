<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['descripcion']) && isset($_POST['provincia'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
	$provincia = $_POST['provincia'];
    //Pasar a mayusculas
    $descripcion = strtoupper($descripcion);
    $codigo = strtoupper($codigo);
    $descripcion = $c->escapeString($descripcion);
    $codigo = $c->escapeString($codigo);
    $result = $c->actualizarcomuna($id, $codigo, $descripcion, $provincia);
    if($result==true) {
        echo 1;
        $c->actualizarciudad($id, $codigo, $descripcion, $provincia);
    } else {
        echo 0;
    }
} else {
    echo "No se encontró la Comuna";
}
