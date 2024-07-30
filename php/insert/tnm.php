<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['Nombre']) && isset($_POST['diagnostico']) && isset($_POST['tipo'])){
    $nombre = $_POST['Nombre'];
    $diagnostico = $_POST['diagnostico'];
    $tipo = $_POST['tipo'];
    if(strlen($nombre) > 0 && strlen($diagnostico) > 0 && strlen($tipo) > 0){
        $nombre = $c->escapeString($nombre);
        $diagnostico = $c->escapeString($diagnostico);
        $tipo = $c->escapeString($tipo);
        $result = $c->registrartnm($nombre, $diagnostico, $tipo);
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
