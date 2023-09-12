<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['tipo']) && isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['Nombre1'])) {
    $tipo = $_POST['tipo'];
    $codigo = $_POST['Codigo'];
    $des1 = $_POST['Nombre'];
    $des2 = $_POST['Nombre1'];
    //Pasar a mayusculas
    $des1 = strtoupper($des1);
    $des2 = strtoupper($des2);
    $codigo = strtoupper($codigo);
    $des1 = $c->escapeString($des1);
    $des2 = $c->escapeString($des2);
    $codigo = $c->escapeString($codigo);

    if (strlen($codigo) > 0 && strlen($des1) > 0 && strlen($des2) > 0) {
        $result = $c->registrardiagnosticocieo($codigo, $des1, $des2, $tipo);
        if ($result == true) {
            echo "1";

           
        /***********Auditoria******************* */
        $titulo = "Registro de Diagnostico CIEO";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo diagnostico CIEO con el nombre de " . $des1 . " y codigo " . $codigo . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
        } else {
            echo "0";
        }
    } else {
        echo "Hay campos vacios";
    }
}else{
    echo "No se recibieron los datos";
}
