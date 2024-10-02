<?php
require '../controller.php';
$c = new Controller();
session_start();
if(!isset($_SESSION['USER_ID'])){
    echo json_encode(array("status"=> false, "message"=> "Ups! se ha expirado la sesión"));
    return;
}

$empresa = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
    if($empresa == null){
        echo json_encode(array("status"=> false, "message"=> "Ups! No se ha podido obtener la información del centro de Salud"));
        return;
    }
}else{
    echo json_encode(array("status"=> false, "message"=> "Ups! No se ha podido obtener la información del centro de Salud"));
    return;

}

if(isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['diagnostico']) && isset($_POST['diagnosticotext']) && isset($_POST['diagnosticocie10']) && isset($_POST['diagnosticocie10text']) && isset($_POST['fechabiopsia']) && isset($_POST['reingreso']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['histologico']) && isset($_POST['histologicotext']) && isset($_POST['invasiontumoral']) && isset($_POST['invasiontumoraltext']) && isset($_POST['mitotico']) && isset($_POST['tnm']) && isset($_POST['observaciontnm']) && isset($_POST['anamnesis']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingreso']) && isset($_POST['observacionplan']) && isset($_POST['resolucion'])  && isset($_POST['peso']) && isset($_POST['talla'])){
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];
    $diagnostico = $_POST['diagnostico'];
    $diagnosticotext = $_POST['diagnosticotext'];
    $diagnosticocie10 = $_POST['diagnosticocie10'];
    $diagnosticocie10text = $_POST['diagnosticocie10text'];
    $fechabiopsia = $_POST['fechabiopsia'];
    $reingreso = $_POST['reingreso'];
    $ecog = $_POST['ecog'];
    $ecogtext = $_POST['ecogtext'];
    $histologico = $_POST['histologico'];
    $histologicotext = $_POST['histologicotext'];
    $invasiontumoral = $_POST['invasiontumoral'];
    $invasiontumoraltext = $_POST['invasiontumoraltext'];
    $mitotico = $_POST['mitotico'];
    $tnm = $_POST['tnm'];
    $observaciontnm = $_POST['observaciontnm'];
    $anamnesis = $_POST['anamnesis'];

    //Decision Tomada
    $cirugia = $_POST['cirugia'];
    $quimioterapia = $_POST['quimioterapia'];
    $radioterapia = $_POST['radioterapia'];
    $otros = $_POST['otros'];
    $seguimiento = $_POST['seguimiento'];
    $completar = $_POST['completar'];
    $revaluacion = $_POST['revaluacion'];
    $estudioclinicno = $_POST['estudioclinicno'];
    $observacionesdecision = $_POST['observacionesdecision'];

    //plan asistencial
    $consultade = $_POST['consultade'];
    $consultadetext = $_POST['consultadetext'];
    $programacion = $_POST['programacion'];
    $traslado = $_POST['traslado'];
    $paliativos = $_POST['paliativos'];
    $ingreso = $_POST['ingreso'];
    $observacionplan = $_POST['observacionplan'];
    $resolucion = $_POST['resolucion'];

    $peso = $_POST['peso'];
    $talla = $_POST['talla'];

    //Validar Diagnosticos
    if($diagnostico <= 0 || strlen($diagnosticotext) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un diagnóstico"));
        return;
    }

    if($diagnosticocie10 <= 0 || strlen($diagnosticocie10text) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un diagnóstico CIE10"));
        return;
    }

    //Validar ECOG
    if($ecog <= 0 || strlen($ecogtext) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un ECOG"));
        return;
    }

    //Validar Histologico
    if($histologico <= 0 || strlen($histologicotext) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un Histologico"));
        return;
    }

    //Validar Invasion Tumoral
    if($invasiontumoral <= 0 || strlen($invasiontumoraltext) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar una Invasion Tumoral"));
        return;
    }

    //Validar Mitotico
    if($mitotico < 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un Mitotico"));
        return;
    }

    //Validar TNM
    if(count($tnm) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar un TNM"));
        return;
    }

    //Validar Anamnesis
    if(strlen($anamnesis) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Anamnesis"));
        return;
    }

    //Desicion Tomada
    //Validar Cirugia
    if(strlen($cirugia) <= 0 || !is_numeric($cirugia)){
        $cirugia = 0;
    }

    //Validar Quimioterapia
    if(strlen($quimioterapia) <= 0 || !is_numeric($quimioterapia)){
        $quimioterapia = 0;
    }

    //Validar Radioterapia
    if(strlen($radioterapia) <= 0 || !is_numeric($radioterapia)){
        $radioterapia = 0;
    }

    //Validar Otros
    if(strlen($otros) <= 0 || !is_numeric($otros)){
        $otros = 0;
    }

    //Validar Seguimiento
    if(strlen($seguimiento) <= 0 || !is_numeric($seguimiento)){
        $seguimiento = 0;
    }

    //Validar Completar
    if(strlen($completar) <= 0 || !is_numeric($completar)){
        $completar = 0;
    }

    //Validar Revaluacion
    if(strlen($revaluacion) <= 0 || !is_numeric($revaluacion)){
        $revaluacion = 0;
    }

    //Validar Estudio Clinico
    if(strlen($estudioclinicno) <= 0 || !is_numeric($estudioclinicno)){
        $estudioclinicno = 0;
    }

    //Validar que se seleccionado al menos una opcion
    if($cirugia == 0 && $quimioterapia == 0 && $radioterapia == 0 && $otros == 0 && $seguimiento == 0 && $completar == 0 && $revaluacion == 0 && $estudioclinicno == 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar al menos una opción en Decision Tomada"));
        return;
    }

    //Validar Observaciones Decision
    if(strlen($observacionesdecision) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Observaciones Decision"));
        return;
    }

    //Plan Asistencial
    //Validar Consulta De
    if(strlen($consultade) <= 0 || !is_numeric($consultade)){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe seleccionar una Consulta De"));
        return;
    }

    //Validar Consulta De Text
    if(strlen($consultadetext) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Consulta De Text"));
        return;
    }

    //Validar Programacion
    if(strlen($programacion) <= 0 || !is_numeric($programacion)){
        $programacion = 0;
    }

    //Validar Traslado
    if(strlen($traslado) <= 0 || !is_numeric($traslado)){
        $traslado = 0;
    }

    //Validar Paliativos
    if(strlen($paliativos) <= 0 || !is_numeric($paliativos)){
        $paliativos = 0;
    }

    //Validar Ingreso
    if(strlen($ingreso) <= 0 || !is_numeric($ingreso)){
        $ingreso = 0;
    }

    //Validar Resolucion
    if(strlen($resolucion) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Resolucion"));
        return;
    }

    //Obtener Folio
    $folio = $c->buscarultimofolioinformecomite($empresa->getId())+1;

    //Registrar Informe
    $informe_id = $c->registrarinformecomite($folio, $paciente,$comite,$ecog,$histologico,$invasiontumoral,$mitotico,$observaciontnm,$anamnesis,$cirugia,$quimioterapia,$radioterapia,$otros,$seguimiento,$completar,$revaluacion,$estudioclinicno,$observacionesdecision,$consultadetext,$consultade,$programacion,$traslado,$paliativos,$ingreso,$observacionplan,$resolucion,$empresa->getId());

    if($informe_id>0){
        //Registrar Diagnosticos
        $c->registrarcomitediagnostico($informe_id,$diagnosticotext,$diagnostico,$diagnosticocie10text,$diagnosticocie10,$fechabiopsia,$reingreso);
        foreach ($tnm as $t) {
            $c->registrarcomitetnm($informe_id,$t['t1'],$t['t'],$t['ttext'], $t['n'],$t['ntext'],$t['m'],$t['mtext']);
        }
        $medidasant = $c->buscarmedidaantropometrica($paciente);
        if(strlen($peso) ==0 && strlen($talla) ==0){
        }else{
            if($medidasant != null){
                if($medidasant->getPeso() != $peso || $medidasant->getTalla() != $talla ){
                    $pcee = $medidasant->getPcee();
                    if(strlen($pcee) == 0){
                        $pcee = 'null';
                    }
                    $pe = $medidasant->getPe();
                    if(strlen($pe) == 0){
                        $pe = 'null';
                    }
                    $pt = $medidasant->getPt();
                    if(strlen($pt) == 0){
                        $pt = 'null';
                    }
                    $te = $medidasant->getTe();
                    if(strlen($te) == 0){
                        $te = 'null';
                    }
                    $imc = $medidasant->getImc();
                    if(strlen($imc) == 0){
                        $imc = 'null';
                    }
                    $claimg = $medidasant->getClasifimc();
                    if(strlen($claimg) == 0){
                        $claimg = 'null';
                    }
                    $pce = $medidasant->getPce();
                    if(strlen($pce) == 0){
                        $pce = 'null';
                    }
                    $clacintura = $medidasant->getClasificacioncintura();
                    if(strlen($clacintura) == 0){
                        $clacintura = 'null';
                    }



                    $c->registrarmedidas($paciente, $peso, $talla,$pcee,$pe,$pt, $te, $imc, $claimg,$pce,$clacintura);
                }
            }else{
                $c->registrarmedidas($paciente, $peso, $talla,'null','null','null', 'null', 'null', 'null','null','null');
            }
        }
        echo json_encode(array("status"=> true, "message"=> "Se ha registrado el informe correctamente"));
    }else{
        echo json_encode(array("status"=> false, "message"=> "Ups! No se ha podido registrar el informe"));
    }
}else{
    echo json_encode(array("status"=> false, "message"=> "Ups! No se han enviado los datos necesarios"));
}