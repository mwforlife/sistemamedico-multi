<?php
require '../controller.php';
$c = new Controller();

/*Codigo: sdfs
Nombre: fdsf*/

if(isset($_POST['Codigo']) && isset($_POST['Nombre'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        //Pasar a mayusculas
        $nombre = strtoupper($nombre);
        $codigo = strtoupper($codigo);
        $result = $c->registrargenero($codigo, $nombre);
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
