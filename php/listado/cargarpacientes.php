<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['idcomite'])){
    $idcomite = $_POST['idcomite'];
    if($idcomite<=0){
        echo "Seleccione un comite";
        return;
    }
    $listapacientes = $c->buscarpacientescomite($idcomite);
    $array = array();
    foreach($listapacientes as $listapaciente){
        $id = $listapaciente->getregistro();
        $rut = $listapaciente->getrut();
        $nombre = $listapaciente->getnombre();
        $contacto = $listapaciente->getcontacto();
        $profesionalid = $listapaciente->getprofesionalid();
        $profesional = $listapaciente->getprofesional();
        $observaciones = $listapaciente->getobservaciones();
        $array[] = array('_id'=>$id, '_rut'=>$rut, '_nombre'=>$nombre, '_contacto'=>$contacto, '_profesionalid'=>$profesionalid, '_profesional'=>$profesional, '_observaciones'=>$observaciones);
    }
    $listapacientes = json_encode($array);
    echo $listapacientes;
}
else{
    echo "Seleccione un comite";
    return;
}