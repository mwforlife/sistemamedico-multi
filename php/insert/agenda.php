<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['fechas']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['start1']) && isset($_POST['end1']) && isset($_POST['intervalo2']) && isset($_POST['idUsuario']) && isset($_POST['idEmpresa'])) {
    $fechas = $_POST['fechas'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $start1 = $_POST['start1'];
    $end1 = $_POST['end1'];
    $intervalo2 = $_POST['intervalo2'];
    $idUsuario = $_POST['idUsuario'];
    $idEmpresa = $_POST['idEmpresa'];
    $errores = "";
    //Recorrer el arreglo de fechas
    foreach ($fechas as $fecha) {
        //Comprobar que la fecha no sea un dia anterior a la fecha actual
        $fechaActual = date("Y-m-d");
        $horaActual = date("H:i");
        if ($fecha >= $fechaActual) {
            if ($c->comprobardiasferiados($fecha)) {
                $mensaje .= "Fecha: $fecha es feriado;";
            } else {

                if ($start != "" && $end != "") {
                    $id = $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $start, $end, $intervalo2, 1);
                    $intervalo = new DateInterval('PT' . $intervalo2 . 'M'); // Crear intervalo en minutos
                    $startInterval = new DateTime($start);
                    $endInterval = new DateTime($end);

                    // Dividir el rango de tiempo en intervalos y registrar eventos
                    while ($startInterval < $endInterval) {
                        $endIntervalInterval = clone $startInterval;
                        $endIntervalInterval->add($intervalo);

                        $c->registrarhorario($idUsuario, $idEmpresa, $fecha, $startInterval->format('H:i'), $endIntervalInterval->format('H:i'), $intervalo2, $id, 1);

                        $startInterval = $endIntervalInterval;
                    }

                }

                if ($start1 != "" && $end1 != "") {
                    $id = $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $start1, $end1, $intervalo2, 1);
                    $intervalo = new DateInterval('PT' . $intervalo2 . 'M'); // Crear intervalo en minutos
                    $startInterval = new DateTime($start1);
                    $endInterval = new DateTime($end1);

                    // Dividir el rango de tiempo en intervalos y registrar eventos
                    while ($startInterval < $endInterval) {
                        $endIntervalInterval = clone $startInterval;
                        $endIntervalInterval->add($intervalo);

                        $c->registrarhorario($idUsuario, $idEmpresa, $fecha, $startInterval->format('H:i'), $endIntervalInterval->format('H:i'), $intervalo2, $id, 1);

                        $startInterval = $endIntervalInterval;
                    }
                }
            }
        }else{
            echo "Fecha: $fecha es anterior a la fecha actual ".$fechaActual. "Hora: $horaActual";
        }
    }
    echo json_encode(array("error" => false, "mensaje" => "Se registró correctamente"));
    
    /***********Auditoria******************* */
    $titulo = "Registro de disponibilidad";
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado nuevos horarios de disponibilidad";
    $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
    /**************************************** */

} else {
    echo json_encode(array("error" => true, "mensaje" => "No se recibieron los datos correctamente"));
}