<?php
require '../controller.php';
$c = new Controller();
// Validación de autenticación y autorización
session_start();
if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(array("error" => true, "mensaje" => "Acceso no autorizado"));
    exit;
}

// Validación de Empresa
if (!isset($_SESSION['CURRENT_ENTERPRISE'])) {
    echo json_encode(array("error" => true, "mensaje" => "No se ha seleccionado una empresa"));
    exit;
}

function generarFechas($periodo, $diasSeleccionados) {
    $fechas = array();

    // Convertir el período en un objeto DateTime
    $fechaInicio = new DateTime($periodo . "-01");
    $ultimoDia = $fechaInicio->format("t");

    // Iterar por cada día del mes
    for ($dia = 1; $dia <= $ultimoDia; $dia++) {
        $fechaActual = new DateTime($periodo . "-" . $dia);

        // Obtener el número de día de la semana (0 para Domingo, 6 para Sábado)
        $numeroDia = $fechaActual->format("w");

        // Si el número de día coincide con los días seleccionados, agregar la fecha al arreglo
        if (in_array($numeroDia, $diasSeleccionados)) {
            $fechas[] = $fechaActual->format("Y-m-d");
        }
    }

    return $fechas;
}

if(isset($_POST['datosHorario'])) {
    $datosHorario = $_POST['datosHorario'];

    $periodo = $datosHorario['periodo'];
    $diasSeleccionados = $datosHorario['diasSeleccionados'];
    $horaInicioMatutina = $datosHorario['horaInicioMatutina'];
    $horaFinMatutina = $datosHorario['horaFinMatutina'];
    $horaInicioTarde = $datosHorario['horaInicioTarde'];
    $horaFinTarde = $datosHorario['horaFinTarde'];
    $intervalo = $datosHorario['intervalo'];
    $idUsuario = $datosHorario['idUsuario'];
    $idEmpresa = $datosHorario['idEmpresa'];

    // Generar las fechas correspondientes según los días seleccionados
    $fechas = generarFechas($periodo, $diasSeleccionados);
    $mensaje = "";
    // Loop a través de las fechas y registrar los horarios
    foreach ($fechas as $fecha) {
        //Comprobar que la fecha no sea un dia anterior a la fecha actual
        $fechaActual = date("Y-m-d");
        if($fecha >= $fechaActual){
            if($c->comprobardiasferiados($fecha)){
                $mensaje .= "Fecha: $fecha es feriado \n";
            }else{
                
                if(!empty($horaInicioMatutina) && !empty($horaFinMatutina)){
                    $id = $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $horaInicioMatutina, $horaFinMatutina, $intervalo, 1);
                    $intervalo = new DateInterval('PT' . $intervalo . 'M'); // Crear intervalo en minutos
                    $startInterval = new DateTime($horaInicioMatutina);
                    $endInterval = new DateTime($horaFinMatutina);

                    // Dividir el rango de tiempo en intervalos y registrar eventos
                    while ($startInterval < $endInterval) {
                        $endIntervalInterval = clone $startInterval;
                        $endIntervalInterval->add($intervalo);

                        $c->registrarhorario($idUsuario, $idEmpresa, $fecha, $startInterval->format('H:i'), $endIntervalInterval->format('H:i'), $intervalo, $id, 1);

                        $startInterval = $endIntervalInterval;
                    }
                }

                if (!empty($horaInicioTarde) && !empty($horaFinTarde)) {
                    $id = $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $horaInicioTarde, $horaFinTarde, $intervalo, 1);
                    $intervalo = new DateInterval('PT' . $intervalo . 'M'); // Crear intervalo en minutos
                    $startInterval = new DateTime($horaInicioTarde);
                    $endInterval = new DateTime($horaFinTarde);

                    // Dividir el rango de tiempo en intervalos y registrar eventos
                    while ($startInterval < $endInterval) {
                        $endIntervalInterval = clone $startInterval;
                        $endIntervalInterval->add($intervalo);

                        $c->registrarhorario($idUsuario, $idEmpresa, $fecha, $startInterval->format('H:i'), $endIntervalInterval->format('H:i'), $intervalo, $id, 1);

                        $startInterval = $endIntervalInterval;
                    }
                }
            }
        }
    }
    $mensaje = "Horario Registrado correctamente";
    echo json_encode(array("error" => false, "mensaje" => $mensaje));
} else {
    echo json_encode(array("error" => true, "mensaje" => "Datos no recibidos correctamente"));
}
