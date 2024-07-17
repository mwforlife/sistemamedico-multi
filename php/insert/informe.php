<?php
require '../controller.php';
$c = new Controller();
session_start();
/*paciente: 1
comite: 2
diagnostico: 5
diagnosticotext: Cáncer de colon
diagnosticocie10: 3
diagnosticocie10text: Cólera
fechabiopsia: 
reingreso: 0
ecog: 1
ecogtext: 1 - PRUEBA
histologico: 1
histologicotext: 1 - PRUEBA
invasiontumoral: 1
invasiontumoraltext: PRUEBA
mitotico: 1
tnm[0][t1]: 
tnm[0][t2]: 
tnm[0][t]: 5
tnm[0][ttext]: Tis
tnm[0][n1]: 
tnm[0][n]: 6
tnm[0][ntext]: Ne
tnm[0][m1]: 
tnm[0][m]: 7
tnm[0][mtext]: Mx
tnm[0][m2]: 
observaciontnm: 
anamnesis: asdasd sa
cirugia: 1
quimioterapia: 0
radioterapia: 0
otros: 0
seguimiento: 0
completar: 1
revaluacion: 0
estudioclinicno: 0
observacionesdecision: asdsa
consultade: 1
consultadetext: Cirugía
programacion: 0
traslado: 0
paliativos: 0
ingreso: 0
observacionplan: asdsa
resolucion: asdsadasdsad*/

if(isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['diagnostico']) && isset($_POST['diagnosticotext']) && isset($_POST['diagnosticocie10']) && isset($_POST['diagnosticocie10text']) && isset($_POST['reingreso']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['histologico']) && isset($_POST['histologicotext']) && isset($_POST['invasiontumoral']) && isset($_POST['invasiontumoraltext']) && isset($_POST['mitotico']) && isset($_POST['tnm']) && isset($_POST['observaciontnm']) && isset($_POST['anamnesis']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingreso']) && isset($_POST['observacionplan']) && isset($_POST['resolucion'])){
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];
    $diagnostico = $_POST['diagnostico'];
    $diagnosticotext = $_POST['diagnosticotext'];
    $diagnosticocie10 = $_POST['diagnosticocie10'];
    $diagnosticocie10text = $_POST['diagnosticocie10text'];
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
    if($mitotico <= 0){
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

    //Validar Observacion Plan
    if(strlen($observacionplan) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Observacion Plan"));
        return;
    }

    //Validar Resolucion
    if(strlen($resolucion) <= 0){
        echo json_encode(array("status"=> false, "message"=> "Ups! Debe ingresar una Resolucion"));
        return;
    }

    //Insertar Informe








}else{
    echo json_encode(array("status"=> false, "message"=> "Ups! No se han enviado los datos necesarios"));
}