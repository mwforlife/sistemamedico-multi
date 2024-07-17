<?php
//imprimir error de debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../controller.php';
$c = new Controller();
session_start();

$idusiario = 0;
if(isset($_SESSION['USER_ID'])){
    $idusuario = $_SESSION['USER_ID'];
}else{
    echo json_encode(array('status' => false, 'message' => 'Ups! Hubo un error al obtener la información del usuario'));
    return;
}

if(isset($_POST['diagnosticoid']) && isset($_POST['diagnosticotext']) && isset($_POST['cieo10']) && isset($_POST['cieo10text']) && isset($_POST['tipoatencion']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['ingreso']) && isset($_POST['receta']) && isset($_POST['reingreso']) && isset($_POST['anamnesis']) && isset($_POST['estudiocomplementarios']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingresohospitalario']) && isset($_POST['observacionplan']) && isset($_POST['atpacienteid']) && isset($_POST['atempresaid']) && isset($_POST['atprofesionalid']) && isset($_POST['atreservaid']) && isset($_POST['modalidad'])){
    $diagnosticoid = $_POST['diagnosticoid'];
    $diagnosticotext = $_POST['diagnosticotext'];
    if($diagnosticoid<=0 || strlen($diagnosticotext)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe seleccionar un diagnostico'));
        return;
    }
    $cieo10 = $_POST['cieo10'];
    $cieo10text = $_POST['cieo10text'];
    $cieo10text = $c->escapeString($cieo10text);
    $cieo10text = mb_strtoupper($cieo10text, 'UTF-8');
    if($cieo10<=0 || strlen($cieo10text)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe seleccionar un CIE-10'));
        return;
    }
    $tipoatencion = $_POST['tipoatencion'];

    $ecog = $_POST['ecog'];
    $ecogtext = $_POST['ecogtext'];
    $ecogtext = $c->escapeString($ecogtext);
    $ecogtext = mb_strtoupper($ecogtext, 'UTF-8');
    if($ecog<=0 || strlen($ecogtext)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe seleccionar un ECOG'));
        return;
    }
    $ingreso = $_POST['ingreso'];
    if($ingreso<=0 || strlen($ingreso)==0){
        $ingreso = 0;
    }
    $receta = $_POST['receta'];
    if($receta<=0 || strlen($receta)==0){
        $receta = 0;
    }
    $reingreso = $_POST['reingreso'];
    if($reingreso<=0 || strlen($reingreso)==0){
        $reingreso = 0;
    }
    $anamnesis = $_POST['anamnesis'];
    $anamnesis = $c->escapeString($anamnesis);
    $anamnesis = mb_strtoupper($anamnesis, 'UTF-8');
    if(strlen($anamnesis)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe ingresar anamnesis'));
        return;
    }
    $estudiocomplementarios = $_POST['estudiocomplementarios'];
    $estudiocomplementarios = $c->escapeString($estudiocomplementarios);
    $estudiocomplementarios = mb_strtoupper($estudiocomplementarios, 'UTF-8');
    if(strlen($estudiocomplementarios)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe ingresar estudios complementarios'));
        return;
    }
    $cirugia = $_POST['cirugia'];
    if($cirugia<=0 || strlen($cirugia)==0){
        $cirugia = 0;
    }
    $quimioterapia = $_POST['quimioterapia'];
    if($quimioterapia<=0 || strlen($quimioterapia)==0){
        $quimioterapia = 0;
    }
    $radioterapia = $_POST['radioterapia'];
    if($radioterapia<=0 || strlen($radioterapia)==0){
        $radioterapia = 0;
    }
    $otros = $_POST['otros'];
    if($otros<=0 || strlen($otros)==0){
        $otros = 0;
    }
    $seguimiento = $_POST['seguimiento'];
    if($seguimiento<=0 || strlen($seguimiento)==0){
        $seguimiento = 0;
    }
    $completar = $_POST['completar'];
    if($completar<=0 || strlen($completar)==0){
        $completar = 0;
    }
    $revaluacion = $_POST['revaluacion'];
    if($revaluacion<=0 || strlen($revaluacion)==0){
        $revaluacion = 0;
    }
    $estudioclinicno = $_POST['estudioclinicno'];
    if($estudioclinicno<=0 || strlen($estudioclinicno)==0){
        $estudioclinicno = 0;
    }
    $observacionesdecision = $_POST['observacionesdecision'];
    $observacionesdecision = $c->escapeString($observacionesdecision);
    $observacionesdecision = mb_strtoupper($observacionesdecision, 'UTF-8');
    if(strlen($observacionesdecision)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe ingresar observaciones de decision'));
        return;
    }
    $consultade = $_POST['consultade'];
    if($consultade<=0 || strlen($consultade)==0){
        $consultade = 0;
    }
    $consultadetext = $_POST['consultadetext'];
    if(strlen($consultadetext)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe ingresar consultade text'));
        return;
    }
    $programacion = $_POST['programacion'];
    if($programacion<=0 || strlen($programacion)==0){
        $programacion = 0;
    }
    $traslado = $_POST['traslado'];
    $paliativos = $_POST['paliativos'];
    $ingresohospitalario = $_POST['ingresohospitalario'];
    if($ingresohospitalario<=0 || strlen($ingresohospitalario)==0){
        $ingresohospitalario = 0;
    }
    $observacionplan = $_POST['observacionplan'];
    $observacionplan = $c->escapeString($observacionplan);
    $observacionplan = mb_strtoupper($observacionplan, 'UTF-8');
    if(strlen($observacionplan)==0){
        echo json_encode(array('status' => false, 'message' => 'Debe ingresar observaciones del plan'));
        return;
    }
    $atpacienteid = $_POST['atpacienteid'];
    if($atpacienteid<=0){
        echo json_encode(array('status' => false, 'message' => 'Ups! Error al obtener la información del paciente'));
        return;
    }
    $atempresaid = $_POST['atempresaid'];
    if($atempresaid<=0){
        echo json_encode(array('status' => false, 'message' => 'Ups! Error al obtener la información del centro de atención'));
        return;
    }
    $atprofesionalid = $_POST['atprofesionalid'];
    if($atprofesionalid<=0){
        echo json_encode(array('status' => false, 'message' => 'Ups! Error al obtener la información del profesional'));
        return;
    }
    $atreservaid = $_POST['atreservaid'];
    if($atreservaid<=0){
        echo json_encode(array('status' => false, 'message' => 'Ups! Error al obtener la información de la reserva'));
        return;
    }

    $modalidad = $_POST['modalidad'];
    if($modalidad<=0){
        echo json_encode(array('status' => false, 'message' => 'Ups! Error al obtener la información de la modalidad'));
        return;
    }

    $folio = 0;
    if(isset($_POST['folio'])){
        $folio = $_POST['folio'];
    }

    if($folio<=0){
        $folio = $c->buscarultimofolio($atempresaid)+1;
    }

    $atencion = $c->registrarconsulta($atpacienteid,$atprofesionalid,$atempresaid,$atreservaid,$folio,$diagnosticoid,$diagnosticotext,$cieo10,$cieo10text,$tipoatencion,$ecog,$ecogtext,$ingreso,$receta,$reingreso,$anamnesis,$estudiocomplementarios,$cirugia,$quimioterapia,$radioterapia,$otros,$seguimiento,$completar,$revaluacion,$estudioclinicno,$observacionesdecision,$consultadetext,$consultade,$programacion,$traslado,$paliativos,$ingresohospitalario,$observacionplan,$modalidad);

    if($atencion==true){
        echo json_encode(array('status' => true, 'message' => 'Atención registrada correctamente'));
        $paciente = $c->buscarpaciente($atpacienteid);
        $medico = $c->buscarenUsuario($atprofesionalid, $atempresaid);
        $titulo = "Nueva atención registrada";
        $mensaje = "Se ha registrado una nueva atención para el paciente ".$paciente->getNombre()." ".$paciente->getApellido1().", con el médico ".$medico->getNombre()." ".$medico->getApellido1().".";
        $c->registrarAuditoria($atprofesionalid, $atempresaid,1,$titulo,$mensaje);
    }else{
        echo json_encode(array('status' => false, 'message' => 'Ups! Hubo un error al registrar la atención'));
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'Ups! Hubo un error al obtener la información de la atención'));
}