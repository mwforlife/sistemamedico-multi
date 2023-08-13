<?php
require '../controller.php';
$c = new Controller();

session_start();
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
}else{
	return;
}
if(isset($_POST['idcomite'])){
    $idcomite = $_POST['idcomite'];
    if($idcomite<=0){
        echo "Seleccione un comite";
        return;
    }
    $listaprofesionales = $c->buscarprofesionalescomite($idcomite, $empresa->getId());
    $array = array();
    foreach($listaprofesionales as $listaprofesional){
        $idprofesional = $listaprofesional->getidcomite();
        $rutprofesional = $listaprofesional->getrut();
        $nombreprofesional = $listaprofesional->getnombre();
        $profesionprofesional = $listaprofesional->getprofesion();
        $array[] = array('_id'=>$idprofesional, '_rut'=>$rutprofesional, '_nombre'=>$nombreprofesional, '_profesion'=>$profesionprofesional);
    }
    $listaprofesionales = json_encode($array);
    echo $listaprofesionales;
    return;
}
else{
    echo "Seleccione un comite";
    return;
}