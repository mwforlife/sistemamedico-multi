<?php
require '../controller.php';
$c = new controller();

if(isset($_POST['nombreedit']) && isset($_POST['presentacionedit']) && isset($_POST['cantidadedit']) && isset($_POST['medidasedit']) && isset($_POST['idmedicamento'])){
    $nombre = $_POST['nombreedit'];
    $presentacion = $_POST['presentacionedit'];
    $cantidad = $_POST['cantidadedit'];
    $medida = $_POST['medidasedit'];
    $id = $_POST['idmedicamento'];
    if(strlen($cantidad)==0){
        $cantidad = 0;
    }else if(!is_numeric($cantidad)){
        $cantidad = 0;
    }   



    if(strlen($nombre)==0){
        echo json_encode(array('error' => true, 'message' => 'El nombre no puede estar vacio'));
    }

    $vias = "";
    $viasad = $c->listarviasadministracion();
    foreach ($viasad as $via) {
        if (isset($_POST['viaedit' . $via->getId()])) {
           $vias .= $via->getNombre() . ";";
        }
    }

    $object = $c->actualizarmedicamento($id, $nombre, $presentacion, $cantidad, $medida, $vias);
    if ($object ==true) {
        echo json_encode(array('error' => false, 'message' => 'Medicamento actualizado correctamente'));
    } else {
        echo json_encode(array('error' => true, 'message' => 'Error al actualizar el medicamento'));
    }
}else{
    echo json_encode(array('error' => true, 'message' => 'Error al actualizar el medicamento'));
}