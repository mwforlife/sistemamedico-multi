<?php
require '../controller.php';
$c = new Controller();

/*Codigo: sdfs
Nombre: fdsf*/

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['empresa'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $empresa = $_POST['empresa'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0 && strlen($empresa) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $empresa = $c->escapeString($empresa);
        //Pasar a mayusculas
        $nombre = strtoupper($nombre);
        $codigo = strtoupper($codigo);
        $result = $c->registrarnombrecomite($codigo, $nombre, $empresa);
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
