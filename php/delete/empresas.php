<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['id'])) {
    $empresa = $c->buscarEmpresa($_POST['id']);
    $result = $c->eliminarEmpresa($_POST['id']);
    if ($result == true) {
        echo 1;
        /***********Auditoria******************* */
        session_start();
        $titulo = "Eliminacion de Empresa";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado la empresa de " . $empresa->getRazonSocial() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
        /**************************************** */
    } else {
        echo 0;
    }

}