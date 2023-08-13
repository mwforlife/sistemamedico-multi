<?php
require '../controller.php';
$c = new Controller();

/*Codigo: sdfs
Nombre: fdsf*/

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['tipo']) && isset($_POST['diagnostico'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $tipo = $_POST['tipo'];
    $diagnostico = $_POST['diagnostico'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0 && strlen($tipo) > 0 && strlen($diagnostico) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $tipo = $c->escapeString($tipo);
        $tipo = strtoupper($tipo);
        $codigo = strtoupper($codigo);
        $nombre = strtoupper($nombre);
        $result = $c->registrartnm($codigo, $nombre, $diagnostico, $tipo);
        if($result==true){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        echo "Hay campos vacios";
    }
}else{
    echo "No se han enviado los parametros";
}
