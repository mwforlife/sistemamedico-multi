<?php
require '../controller.php';
$c = new Controller();
session_start();

if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(array('status' => false, 'message' => 'No ha iniciado sesión'));
    return;
}

/*action: reservar
idPaciente: 29
hora: ["160","161","162"]*/

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'reservar') {
        if (isset($_POST['idPaciente']) && isset($_POST['hora'])) {
            $idPaciente = $_POST['idPaciente'];
            $paciente = $c->buscarpaciente($idPaciente);
            $hora = $_POST['hora'];
            $horas = json_decode($hora);
            if ($paciente == null) {
                echo json_encode(array('status' => false, 'message' => 'Paciente no encontrado'));
                exit();
            }

            if ($idPaciente > 0 && count($horas) > 0) {
                $errores = "";
                $success = "";
                $validarhora = false;
                foreach ($horas as $hora) {
                    $val = $c->validarreservahorario($hora);
                    if ($val == true) {
                        $validarhora = true;
                        $errores .= "La hora " . $c->horarionombre($hora) . " ya se encuentra reservada. ";
                    }
                    
                }

                if ($validarhora == true) {
                    echo json_encode(array('status' => false, 'message' => $errores));
                }

                $idreserva  = $c->registrarreserva($idPaciente);
                if ($idreserva > 0) {
                    foreach ($horas as $hora) {
                        $c->registrarhoraatencion($idreserva, $hora);
                        $c->cambiarestadohorario($hora, 2);
                        $id = $c->buscariddisponibilidad($hora);
                        $response = $c->comprobarhorariosdisponibles($id);
                        if ($response == false) {
                            $c->cambiarestadodisponibilidad($id, 2);
                        }
                    }
                    
                    /***********Auditoria******************* */
                    $titulo = "Reserva de hora";
                    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
                    $idUsuario = $_SESSION['USER_ID'];
                    $object = $c->buscarenUsuario1($idUsuario);
                    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva reserva para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "";
                    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
                    /**************************************** */
                    $success .= "Reserva registrada correctamente para la hora con id " . $hora . ". ";
                } else {
                    $errores .= "Error al registrar la reserva para la hora con id " . $hora . ". ";
                }

                if($errores == "" && $success != ""){
                    echo json_encode(array('status' => true, 'message' => $success));
                }else if($success != "" && $errores != ""){
                    echo json_encode(array('status' => true, 'message' => $success . $errores));
                }else{
                    echo json_encode(array('status' => false, 'message' => $errores));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Datos incorrectos'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Los datos enviados no son correctos'));
        }
    }
} else {
    echo json_encode(array('status' => false, 'message' => 'Acción no permitida'));
}