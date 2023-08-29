<?php
require '../controller.php';
$c = new Controller();
/*codigo: 8
descripcion: ESQUEMA 1
diagnostico: 1
librosedit: 2
id: 1*/
if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['descripcion']) && isset($_POST['diagnostico']) && isset($_POST['librosedit'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $diagnostico = $_POST['diagnostico'];
    $librosedit = $_POST['librosedit'];
    //Pasar a mayusculas
    $descripcion = strtoupper($descripcion);
    $codigo = strtoupper($codigo);
    $descripcion = $c->escapeString($descripcion);
    $codigo = $c->escapeString($codigo);
    $result = $c->actualizaresquema($id, $codigo, $descripcion, $diagnostico, $librosedit);
    if($result==true) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo "No se encontró La region";
}
