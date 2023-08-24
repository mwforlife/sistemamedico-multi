<?php
require '../controller.php';
$c = new controller();
if(isset($_POST['nombre']) && isset($_POST['presentacion']) && isset($_POST['cantidad']) && isset($_POST['medida'])){
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    $cantidad = $_POST['cantidad'];
    $medida = $_POST['medida'];

    if(strlen($cantidad)==0){
        $cantidad = 0;
    }else if(!is_numeric($cantidad)){
        $cantidad = 0;
    }   



    if(strlen($nombre)==0){
        echo json_encode(array('error' => true, 'message' => 'El nombre no puede estar vacio'));
    }
    $via ="";
    $vias = $c->listarviasadministracion();
    foreach($vias as $v){
        if(isset($_POST['via'.$v->getId()])){ //Si esta seteado el checkbox 'via1
            $via .= $v->getNombre().";";
        }
    }

    $result = $c->registrarmedicamentos($nombre, $presentacion, $cantidad, $medida, $via);
    if($result==true){
        echo json_encode(array('error' => false, 'message' => 'Medicamento registrado correctamente'));
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error al registrar el medicamento'));
    }
}else{
    echo json_encode(array('error' => true, 'message' => 'Error al registrar el medicamento'));
}