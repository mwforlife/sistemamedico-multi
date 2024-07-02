<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['idreceta']) && isset($_POST['motivo']) && isset($_POST['observacion'])) {
    $receta = $_POST['idreceta'];
    $motivo = $_POST['motivo'];
    $observacion = $_POST['observacion'];
    $receta = $c->escapeString($receta);
    $receta = (int) $receta;
    $motivo = $c->escapeString($motivo);
    $observacion = $c->escapeString($observacion);

    $motivo = $c->escapeString($motivo);
    $observacion = $c->escapeString($observacion);

    if($receta <= 0){
        echo json_encode(array('status' => false, 'message' => 'El Identificador de la receta es incorrecto'));
        return;
    }

    if(strlen($motivo) <= 0){
        echo json_encode(array('status' => false, 'message' => 'El motivo es requerido'));
        return;
    }

    if(strlen($observacion) <= 0){
        echo json_encode(array('status' => false, 'message' => 'La observación es requerida'));
        return;
    }   

    $result = $c->registrarrechazoreceta($receta, $motivo, $observacion);
    if ($result) {
        $c->cambiaestadoReceta($receta, 4);
        echo json_encode(array('status' => true, 'message' => 'Receta rechazada'));
    } else {
        echo json_encode(array('status' => false, 'message' => 'No se pudo rechazar la receta'));
    }
    
} else {
    echo json_encode(array('status' => false, 'message' => 'No se pudo aprobar la receta'));
}