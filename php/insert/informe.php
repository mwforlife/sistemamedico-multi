<?php
require '../controller.php';
$c = new Controller();
// Verificar si se enviaron los datos por POST
if (isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['diagnostico']) && isset($_POST['diagnosticotext']) && isset($_POST['diagnosticocieomor']) && isset($_POST['diagnosticocieomortext']) && isset($_POST['diagnosticocieotop']) && isset($_POST['diagnosticocieotoptext']) && isset($_POST['diagnosticocie10']) && isset($_POST['diagnosticocie10text']) && isset($_POST['fechabiopsia']) && isset($_POST['reingreso']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['histologico']) && isset($_POST['histologicotext']) && isset($_POST['invasiontumoral']) && isset($_POST['invasiontumoraltext']) && isset($_POST['mitotico']) && isset($_POST['primarioclinico']) && isset($_POST['primarioclinicotext']) && isset($_POST['observacionprimario']) && isset($_POST['regionalesclinico']) && isset($_POST['regionalesclinicotext']) && isset($_POST['observacionregional']) && isset($_POST['distanciaclinico']) && isset($_POST['distanciaclinicotext']) && isset($_POST['observaciondistancia']) && isset($_POST['anamnesis']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingreso']) && isset($_POST['observacionplan']) && isset($_POST['resolucion'])) {

    // Recibir los datos en variables PHP
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];
    $diagnostico = $_POST['diagnostico'];
    $diagnosticotext = $_POST['diagnosticotext'];
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
    }else{
        echo "Error al registrar informe";
    }
    
    /*
    echo "<br>Datos en forma de lista:<br>";
    foreach ($_POST as $key => $value) {
        echo "$key: $value<br>";
    } */   
} else {
    // Si alguna variable no fue enviada, puedes manejar el error aquí.
    echo "Error: Faltan datos enviados por POST.";
}
?>
