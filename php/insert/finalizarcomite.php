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
if(isset($_POST['idcomite']) && isset($_POST['profesionales']) && isset($_POST['pacientes'])){
    $idcomite = $_POST['idcomite'];
    $profesionales = $_POST['profesionales'];
    $pacientes = $_POST['pacientes'];
    if($idcomite<=0){
        echo "Seleccione un comite";
        return;
    }
    if(count($profesionales)==0){
        echo "Seleccione al menos un profesional";
        return;
    }
    if(count($pacientes)==0){
        echo "Seleccione al menos un paciente";
        return;
    }
    //Validar Listado de profesionales
    $listaprofesionales = $c->buscarprofesionalescomite($idcomite,$empresa->getid());
    foreach($listaprofesionales as $listaprofesional){
        $idprofesional = $listaprofesional->getidcomite();
        $valid = false;
        foreach($profesionales as $profesional){
            $idprofesional2 = $profesional['_id'];
            if($idprofesional==$idprofesional2){
                $valid = true;
                break;
            }
        }
        if($valid==false){
            $c->eliminarprofesionalescomite($listaprofesional->getid());
        }
    }

    //Registrar Profesionales del Comite
    foreach($profesionales as $profesional){
        $idprofesional = $profesional['_id'];
        //convertir a int
        $idprofesional = intval($idprofesional);
        $rutprofesional = $profesional['_rut'];
        $nombreprofesional = $profesional['_nombre'];
        $profesionprofesional = $profesional['_profesion'];
        $valid = $c->validarprofesionalescomite($idcomite, $idprofesional);
        if($valid==false){
            $c->registrarprofesionalescomite($idcomite, $idprofesional);
        }
    }

    //Validar Listado de pacientes
    $listapacientes = $c->buscarpacientescomite($idcomite);
    foreach($listapacientes as $listapaciente){
        $idpaciente = $listapaciente->getregistro();
        $valid = false;
        foreach($pacientes as $paciente){
            $idpaciente2 = $paciente['_id'];
            if($idpaciente==$idpaciente2){
                $valid = true;
                break;
            }
        }
        if($valid==false){
            $c->eliminarpacientescomite($listapaciente->getid());
        }
    }

    //Registrar Pacientes del Comite
    foreach($pacientes as $paciente){
        $idpaciente = $paciente['_id'];
        $rutpaciente = $paciente['_rut'];
        $nombrepaciente = $paciente['_nombre'];
        $contactopaciente = $paciente['_contacto'];
        $profesionalidpaciente = $paciente['_profesionalid'];
        $profesionalpaciente = $paciente['_profesional'];
        $observacionespaciente = $paciente['_observaciones'];
        $valid = $c->validarpacientescomite($idcomite, $idpaciente);
        if($valid==false){
            $c->registrarpacientescomite($idcomite, $idpaciente, $profesionalidpaciente, $observacionespaciente);
        }else{
            $c->actualizarpacientescomite($idcomite, $profesionalidpaciente, $observacionespaciente);
        }
    }

    echo "1";
}else{
    echo "No se recibieron los datos";
}