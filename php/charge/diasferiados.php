<?php
require '../controller.php';
$c = new Controller();
$Ano = date('Y');
$dias = $c->listardiasferiadosperiodos($Ano);
if(count($dias)>0){
    $status = array("error"=>false, "message"=>"Dias feriados encontrados");
    foreach($dias as $dia){
        $status["dias"][] = array("id"=>$dia->getId(), "periodo"=>$dia->getPeriodo(), "descripcion"=>$dia->getDescripcion(), "fecha"=>$dia->getFecha());
    }
    echo json_encode($status);
}else{
    $status = array("error"=>true, "message"=>"No se encontraron dias feriados");
    echo json_encode($status);
}