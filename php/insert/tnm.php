<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['Nombre']) && isset($_POST['tipo'])){
    $nombre = $_POST['Nombre'];
    $tipo = $_POST['tipo'];
    if(strlen($nombre) > 0 && strlen($tipo)){
        $nombre = $c->escapeString($nombre);
        $tipo = $c->escapeString($tipo);
        $tipo = strtoupper($tipo);
        $result = $c->registrartnm($nombre,$tipo);
        if($result==true){
            echo json_encode(array("status"=>true, "message"=>"Registro exitoso de tnm"));
        }else{
            echo json_encode(array("status"=>false, "message"=>"Error en el registro de tnm"));
        }
    }else{
        echo json_encode(array("status"=>false, "message"=>"Parametros vacios"));
    }
}else{
    echo json_encode(array("status"=>false, "message"=>"Parametros no definidos"));
}
