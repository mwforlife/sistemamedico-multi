<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $disponibilidad = $c->buscardisponibilidadid($id);

    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Disponibilidad";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado la disponibilidad de " . $disponibilidad->getFecha() . "en el horario de " . $disponibilidad->getHoraInicio() . " a " . $disponibilidad->getHoraFin() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
    
    $c->eliminardisponibilidad($id);
    $c->eliminarhorariodisponibilidad($id);
}