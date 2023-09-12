<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['action'])){
    if($_POST['action'] == 'reservar'){
        if(isset($_POST['idPaciente']) && isset($_POST['hora'])){
            $idPaciente = $_POST['idPaciente'];
            $paciente = $c->buscarpaciente($idPaciente);
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
                    /***********Auditoria******************* */
                    $titulo = "Reserva de hora";
                    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
                    $idUsuario = $_SESSION['USER_ID'];
                    $object = $c->buscarenUsuario1($idUsuario);
                    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva reserva para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "";
                    $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
                    /**************************************** */
                    
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