<?php
require '../controller.php';
$c = new Controller();

/*Codigo: sdfs
Nombre: fdsf*/

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['Region'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $tipo = $_POST['Region'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $tipo = $c->escapeString($tipo);
        $tipo = strtoupper($tipo);
        $codigo = strtoupper($codigo);
        $nombre = strtoupper($nombre);
        $result = $c->registrarprovincia($codigo, $nombre, $tipo);
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
