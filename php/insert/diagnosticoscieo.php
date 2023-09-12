<?php
require '../controller.php';
$c = new Controller();

/*tipo: 1
Codigo: 213ed
Nombre: 213qs d
Nombre1: wqee */

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

            $idUsuario = $_SESSION['USER_ID'];
            $titulo = "Registro de diagnostico CIEO";
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo diagnostico CIEO";
            $c->registrarAuditoria($_SESSION['USER_ID'], 1, $titulo, $evento);
        } else {
            echo "0";
        }
    } else {
        echo "Hay campos vacios";
    }
}else{
    echo "No se recibieron los datos";
}
