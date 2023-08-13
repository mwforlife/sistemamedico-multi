<?php
require '../controller.php';
$c = new Controller();

/*id: 1
codigo: 8000/0
completa: Neoplasia benigna
abreviada: Neoplasia benigna*/

if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['completa']) && isset($_POST['abreviada']) && isset($_POST['tipo'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $completa = $_POST['completa'];
    $abreviada = $_POST['abreviada'];
    $tipo = $_POST['tipo'];
    //Pasar a mayusculas
    $completa = strtoupper($completa);
    $abreviada = strtoupper($abreviada);
    $codigo = strtoupper($codigo);
    $completa = $c->escapeString($completa);
    $abreviada = $c->escapeString($abreviada);
    $codigo = $c->escapeString($codigo);
    $result = $c->actualizarDiagnosticocieo($id, $codigo, $completa, $abreviada, $tipo);
    if($result==true) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo "No se encontró el diagnóstico";
}
