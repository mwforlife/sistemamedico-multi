<?php
require '../controller.php';
$c = new Controller();
session_start();
$enterprise =0;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
} else {
	echo "No se ha seleccionado una empresa";
    return;
}
if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action== "buscarpacienterun"){
        if(isset($_POST['run'])){
            $run = $_POST['run'];
            $pacientes = $c->buscarpacienterut1($run,$enterprise);
            if($pacientes != null){
                echo json_encode(array("error"=>false,"mensaje"=>"Se encontraron pacientes con el rut ingresado","pacientes"=>$pacientes));
            }else{
                echo json_encode(array("error"=>false,"mensaje"=>"No se encontraron pacientes con el rut ingresado"));
            }
        }
    }

    if($action== "buscarpacientepasaporte"){
        if(isset($_POST['pasaporte'])){
            $pasaporte = $_POST['pasaporte'];
            $pacientes = $c->buscarpacienteidentificacion1($pasaporte);
            if($pacientes != null){
                echo json_encode(array("error"=>false,"mensaje"=>"Se encontraron pacientes con el pasaporte ingresado","pacientes"=>$pacientes));
            }else{
                echo json_encode(array("error"=>true,"mensaje"=>"No se encontraron pacientes con el pasaporte ingresado"));
            }
        }
    }

}else{
    echo json_encode(array("error"=>true,"mensaje"=>"No se ha ingresado una accion"));
}