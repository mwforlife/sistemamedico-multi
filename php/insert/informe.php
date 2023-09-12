<?php
require '../controller.php';
$c = new Controller();
session_start();
// Verificar si se enviaron los datos por POST
if (isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['diagnostico']) && isset($_POST['diagnosticotext']) && isset($_POST['diagnosticocieomor']) && isset($_POST['diagnosticocieomortext']) && isset($_POST['diagnosticocieotop']) && isset($_POST['diagnosticocieotoptext']) && isset($_POST['diagnosticocie10']) && isset($_POST['diagnosticocie10text']) && isset($_POST['fechabiopsia']) && isset($_POST['reingreso']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['histologico']) && isset($_POST['histologicotext']) && isset($_POST['invasiontumoral']) && isset($_POST['invasiontumoraltext']) && isset($_POST['mitotico']) && isset($_POST['primarioclinico']) && isset($_POST['primarioclinicotext']) && isset($_POST['observacionprimario']) && isset($_POST['regionalesclinico']) && isset($_POST['regionalesclinicotext']) && isset($_POST['observacionregional']) && isset($_POST['distanciaclinico']) && isset($_POST['distanciaclinicotext']) && isset($_POST['observaciondistancia']) && isset($_POST['anamnesis']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingreso']) && isset($_POST['observacionplan']) && isset($_POST['resolucion'])) {

    // Recibir los datos en variables PHP
    $paciente = $_POST['paciente'];
    $paciente = $c->escapeString($paciente);
    $pacienteobject = $c->buscarpaciente($paciente);
    $comite = $_POST['comite'];
    $diagnostico = $_POST['diagnostico'];
    $diagnostico = $c->escapeString($diagnostico);
    $diagnosticotext = $_POST['diagnosticotext'];
    $diagnosticotext = $c->escapeString($diagnosticotext);
    $diagnosticocieomor = $_POST['diagnosticocieomor'];

    $diagnosticocieomortext = $_POST['diagnosticocieomortext'];
    $diagnosticocieotop = $_POST['diagnosticocieotop'];
    $diagnosticocieotoptext = $_POST['diagnosticocieotoptext'];
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
    $primarioclinico = $_POST['primarioclinico'];
    $primarioclinicotext = $_POST['primarioclinicotext'];
    $observacionprimario = $_POST['observacionprimario'];
    $regionalesclinico = $_POST['regionalesclinico'];
    $regionalesclinicotext = $_POST['regionalesclinicotext'];
    $observacionregional = $_POST['observacionregional'];
    $distanciaclinico = $_POST['distanciaclinico'];
    $distanciaclinicotext = $_POST['distanciaclinicotext'];
    $observaciondistancia = $_POST['observaciondistancia'];
    $anamnesis = $_POST['anamnesis'];
    $cirugia = $_POST['cirugia'];
    $quimioterapia = $_POST['quimioterapia'];
    $radioterapia = $_POST['radioterapia'];
    $otros = $_POST['otros'];
    $seguimiento = $_POST['seguimiento'];
    $completar = $_POST['completar'];
    $revaluacion = $_POST['revaluacion'];
    $estudioclinicno = $_POST['estudioclinicno'];
    $observacionesdecision = $_POST['observacionesdecision'];
    $consultade = $_POST['consultade'];
    $consultadetext = $_POST['consultadetext'];
    $programacion = $_POST['programacion'];
    $traslado = $_POST['traslado'];
    $paliativos = $_POST['paliativos'];
    $ingreso = $_POST['ingreso'];
    $observacionplan = $_POST['observacionplan'];
    $resolucion = $_POST['resolucion'];

    if($diagnostico<=0 || strlen($diagnosticotext)==0){
        echo "Debe seleccionar un diagnóstico válido";
        return;
    }
    if(($diagnosticocieomor<=0 || strlen($diagnosticocieomortext)==0) || ($diagnosticocieotop<=0 || strlen($diagnosticocieotoptext)==0) || ($diagnosticocie10<=0 || strlen($diagnosticocie10text)==0)){
        echo "Debe seleccionar al menos un diagnóstico CIEO O CIE10 válido";
        return;
    }

    if(strlen($fechabiopsia)==0){
        echo "Debe seleccionar una fecha de biopsia válida";
        return;
    }

    //Registrar diagnostico Paciente en comite
    $idregistro = $c->registrarcomitediagnostico($diagnosticotext,$diagnostico,$diagnosticocieotoptext, $diagnosticocieotop,$diagnosticocieomortext, $diagnosticocieomor, $diagnosticocie10text, $diagnosticocie10, $fechabiopsia, $reingreso);

    //Registrar Informe Paciente en comite
    $result = $c->registrarinformecomite($paciente, $idregistro, $comite, $ecog, $histologico, $invasiontumoral, $mitotico, $primarioclinicotext, $primarioclinico, $observacionprimario, $regionalesclinicotext, $regionalesclinico, $observacionregional, $distanciaclinicotext, $distanciaclinico, $observaciondistancia, $anamnesis, $cirugia, $quimioterapia, $radioterapia, $otros, $seguimiento, $completar, $revaluacion, $estudioclinicno, $observacionesdecision,$consultadetext,$consultade, $programacion, $traslado, $paliativos, $ingreso, $observacionplan, $resolucion);

    if($result==true){
        echo 1;
        /***********Auditoria******************* */
        $titulo = "Registro de Informe Comité";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo informe de comité para el paciente " . $pacienteobject->getNombre() . " " . $pacienteobject->getApellido1() . " " . $pacienteobject->getApellido2() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo "Error al registrar informe";
    } 
} else {
    echo "Error: Faltan datos enviados por POST.";
}
?>
