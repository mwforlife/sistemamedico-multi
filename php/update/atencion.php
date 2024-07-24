<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(array("status" => false, "message" => "No se ha iniciado sesión"));
    return;
} else {
    $valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        echo  json_encode(array("status" => false, "message" => "Sesión no válida"));
        return;
    }
}
$usuario = $_SESSION['USER_ID'];
if(isset($_POST['id']) && isset($_POST['estado']) && isset($_POST['observacion'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $observacion = $_POST['observacion'];

    if($id <= 0){
        echo json_encode(array('status' => false, 'message' => 'El id no puede ser menor o igual a 0'));
        return;
    }

    if($estado == null || $estado == ''){
        echo json_encode(array('status' => false, 'message' => 'El estado no puede estar vacío'));
        return;
    }

    if($estado==6){
        $atencion = $c->buscaratencion($id);
        if($atencion == null){
            echo json_encode(array('status' => false, 'message' => 'No se encontró la atención'));
            return;
        }
        $horarios = $c->buscarhorarioatencion($id);
        foreach($horarios as $horario){
            $c->cambiarestadohorario($horario['horario'], 1);
            $c->cambiarestadohorarioatencion($horario['horario'], 2);
            $dis = $c->buscariddisponibilidad($horario['horario']);
            $c->cambiarestadodisponibilidad($dis, 1);
        }
    }
    if($estado==3){
        $c->registrarinicioespera($id);
    }
    $result = $c->actualizaratencion($id, $estado, $observacion);
    if($result == true){
        $c->registrarhistorialestado($id, $estado, $observacion, $usuario);
        echo json_encode(array('status' => true, 'message' => 'Atención actualizada correctamente'));
    }else{
        echo json_encode(array('status' => false, 'message' => 'Error al actualizar la atención'));
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'Datos incorrectos'));
}