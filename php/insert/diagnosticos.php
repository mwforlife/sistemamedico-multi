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
        $result = $c->registrardiagnostico($codigo, $des1, $des2, $tipo);
        if ($result == true) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "Hay campos vacios";
    }
}
