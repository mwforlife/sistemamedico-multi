<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id <= 0){
        echo json_encode(array('status' => false, 'message' => 'El id no puede ser menor o igual a 0'));
        return;
    }

    $receta = $c->buscarconsultaporid($id);
    if($receta == null){
        echo json_encode(array('status' => false, 'message' => 'No se encontró la receta'));
        return;
    }

    $plantratamiento = "<ol>";
    if($receta->getCirugia() == 1){
        $plantratamiento .= "<li>Cirugía</li>";
    }
    if($receta->getQuimioterapia() == 2){
        $plantratamiento .= "<li>Quimioterapia</li>";
    }
    if($receta->getRadioterapia() == 3){
        $plantratamiento .= "<li>Radioterapia</li>";
    }
    if($receta->getTratamientosoncologicos() == 4){
        $plantratamiento .= "<li>Tratamientos Oncológicos</li>";
    }
    if($receta->getSeguimientosintratamiento() == 5){
        $plantratamiento .= "<li>Seguimientos Intra-Tratamiento</li>";
    }
    if($receta->getCompletarestudios() == 6){
        $plantratamiento .= "<li>Completar Estudios</li>";
    }
    if($receta->getRevaluacionposterior() == 7){
        $plantratamiento .= "<li>Revaluación Posterior</li>";
    }
    if($receta->getEstudioclinico() == 8){
        $plantratamiento .= "<li>Estudio Clínico</li>";
    }
    $plantratamiento .= "</ol>";


    echo json_encode(array('status' => true, 'tratamiento' => $plantratamiento  ));
}else{
    echo json_encode(array('status' => false, 'message' => 'No se recibió el id'));
}