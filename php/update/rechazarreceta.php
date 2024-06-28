<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['id']) && isset($_POST['motivo']) && isset($_POST['observacion'])) {
    $receta = $_POST['id'];
    $motivo = $_POST['motivo'];
    $observacion = $_POST['observacion'];
    $receta = $c->escapeString($receta);
    $receta = (int) $receta;
    $motivo = $c->escapeString($motivo);
    $observacion = $c->escapeString($observacion);

    if($receta <= 0){
        echo json_encode(array('error' => true, 'message' => 'El Identificador de la receta es incorrecto'));
        return;
    }

    if(strlen($motivo) <= 0){
        echo json_encode(array('error' => true, 'message' => 'El motivo es requerido'));
        return;
    }
    
} else {
    echo json_encode(array('error' => true, 'message' => 'No se pudo aprobar la receta'));
}