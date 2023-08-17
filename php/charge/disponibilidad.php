<?php
require '../controller.php';
$controller = new Controller();

if (isset($_POST['usuario']) && isset($_POST['empresa'])) {
    $id = $_POST['usuario'];
    $empresa = $_POST['empresa'];
    $disponibilidad = $controller->buscardisponibilidad($id, $empresa);
    foreach ($disponibilidad as $d) {
        $fecha = $d->getFecha();
        $horaInicio = $d->getHoraInicio();
        $horaFin = $d->getHoraFin();
        $intervalo = $d->getIntervalo();
        echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#214fbe',borderColor:'#214fbe',description:'Horario de Atención a pacientes con una duración de " . $intervalo . " minutos'},";
    }
} else {
    echo "{}";
}