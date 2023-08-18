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
        $horaFin = $d->getHoraFin();
        $intervalo = $d->getIntervalo();
        $horario[] = array(
            'id' => $d->getId(),
            'start' => $horaInicio,
            'end' => $horaFin
        );
    }
    echo json_encode($horario);
} else {
    echo "{}";
}