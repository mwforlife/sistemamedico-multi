<?php
require '../controller.php';
$controller = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $disponibilidad = $controller->buscarhorariodisponibilidad($id);
    $horario = array();
    foreach ($disponibilidad as $d) {
        $fecha = $d->getFecha();
        $horaInicio = $d->getHoraInicio();
        //Formato de hora 00:00
        $horaInicio = date("H:i", strtotime($horaInicio));
        $horaFin = $d->getHoraFin();
        //Formato de hora 00:00
        $horaFin = date("H:i", strtotime($horaFin));
        $intervalo = $d->getIntervalo();
        $horario[] = array(
            'id' => $d->getId(),
            'start' => $horaInicio,
            'end' => $horaFin,
            'estado' => $d->getEstado()
        );
    }
    echo json_encode($horario);
} else {
    echo "{}";
}