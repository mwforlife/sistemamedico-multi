<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['id'])) {
    $receta = $_POST['id'];
    $receta = $c->escapeString($receta);
    $receta = (int) $receta;
    if($receta <= 0){
        echo json_encode(array('error' => true, 'message' => 'El Identificador de la receta es incorrecto'));
        return;
    }
    $result = $c->cambiaestadoReceta($receta, 3);
    if ($result) {
        echo json_encode(array('error' => false, 'message' => 'Receta aprobada'));
    } else {
        echo json_encode(array('error' => true, 'message' => 'No se pudo aprobar la receta'));
    }
} else {
    echo json_encode(array('error' => true, 'message' => 'No se pudo aprobar la receta'));
}