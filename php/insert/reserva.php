<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['action'])){
    if($_POST['action'] == 'reservar'){
        if(isset($_POST['idPaciente']) && isset($_POST['hora'])){
            $idPaciente = $_POST['idPaciente'];
            $hora = $_POST['hora'];
            if($idPaciente > 0 && $hora > 0){
                $val = $c->validarreservahorario($hora);
                if($val == true){
                    echo json_encode(array('error' => false, 'message' => 'El horario Seleccionado ya no se encuentra disponible'));
                    exit();
                }
                $result = $c->registrarreserva($idPaciente, $hora);
                if($result==true){
                    $c->cambiarestadohorario($hora, 2);
                    $id = $c->buscariddisponibilidad($hora);
                    $response = $c->comprobarhorariosdisponibles($id);
                    if($response == false){
                        $c->cambiarestadodisponibilidad($id, 2);
                    }
                    echo json_encode(array('error' => false, 'message' => 'Reserva registrada correctamente'));
                }else{
                    echo json_encode(array('error' => false, 'message' => 'Error al registrar la reserva'));
                }
            }else{
                echo json_encode(array('error' => false, 'message' => 'Datos incorrectos'));
            }
        }else{
            echo json_encode(array('error' => false, 'message' => 'Datos incorrectos'));
        }
    }
}else{
    echo json_encode(array('error' => false, 'message' => 'Datos incorrectos'));
}