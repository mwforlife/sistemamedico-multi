<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['descripcion'])  && isset($_POST['diagnostico'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $diagnostico = $_POST['diagnostico'];
    //Pasar a mayusculas
    $descripcion = strtoupper($descripcion);
    $codigo = strtoupper($codigo);
    $descripcion = $c->escapeString($descripcion);
    $codigo = $c->escapeString($codigo);
    $result = $c->actualizartnm($id, $codigo, $descripcion, $diagnostico);
    if($result==true) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo "No se encontró el Registro";
}
