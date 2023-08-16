<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['fechas']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['start1']) && isset($_POST['end1']) && isset($_POST['intervalo2']) && isset($_POST['idUsuario']) && isset($_POST['idEmpresa'])) {
    $fechas = $_POST['fechas'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $start1 = $_POST['start1'];
    $end1 = $_POST['end1'];
    $intervalo2 = $_POST['intervalo2'];
    $idUsuario = $_POST['idUsuario'];
    $idEmpresa = $_POST['idEmpresa'];
    //Recorrer el arreglo de fechas
    foreach ($fechas as $fecha) {
        //Comprobar que la fecha no sea un dia anterior a la fecha actual
        $fechaActual = date("Y-m-d");
        if ($fecha >= $fechaActual) {
            if ($c->comprobardiasferiados($fecha)) {
                $mensaje .= "Fecha: $fecha es feriado;";
            } else {

                if ($start != "" && $end != "") {
                    $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $start, $end, $intervalo2, 1);
                }

                if ($start1 != "" && $end1 != "") {
                    $c->registrardisponibilidad($idUsuario, $idEmpresa, $fecha, $start1, $end1, $intervalo2, 1);
                }
            }
        }
    }
    echo json_encode(array("error" => false, "mensaje" => "Se registró correctamente"));

} else {
    echo json_encode(array("error" => true, "mensaje" => "No se recibieron los datos correctamente"));
}