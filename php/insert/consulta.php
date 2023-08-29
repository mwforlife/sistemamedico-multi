<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['paciente']) && isset($_POST['empresa']) && isset($_POST['medico']) && isset($_POST['reserva']) && isset($_POST['diagnosticoid']) && isset($_POST['diagnosticotext']) && isset($_POST['cieo10']) && isset($_POST['tipoatencion']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['ingreso']) && isset($_POST['receta']) && isset($_POST['reingreso']) && isset($_POST['anamnesis']) && isset($_POST['procedimientotext']) && isset($_POST['resolucion']) && isset($_POST['estadoatencion'])) {
    $paciente = $_POST['paciente'];
    $empresa = $_POST['empresa'];
    $medico = $_POST['medico'];
    $reserva = $_POST['reserva'];
    $diagnosticoid = $_POST['diagnosticoid'];
    $diagnosticotext = $_POST['diagnosticotext'];
    $cieo10 = $_POST['cieo10'];
    $tipoatencion = $_POST['tipoatencion'];
    $ecog = $_POST['ecog'];
    $ecogtext = $_POST['ecogtext'];
    $ingreso = $_POST['ingreso'];
    $receta = $_POST['receta'];
    $reingreso = $_POST['reingreso'];
    $anamnesis = $_POST['anamnesis'];
    $procedimientotext = $_POST['procedimientotext'];
    $resolucion = $_POST['resolucion'];
    $estadoatencion = $_POST['estadoatencion'];

    $valid  = $c->validarconsulta($reserva);
    if($valid==true){
        echo json_encode(array('error' => true, 'message' => 'Ya existe una consulta para esta reserva'));
        return;
    }

    $modalidad = 1;
    if($estadoatencion != 5){
        $modalidad = 2;
    }

    $folio = $c->buscarultimofolio($empresa)+1;

    $response = $c->registrarconsulta($paciente,$medico, $empresa, $reserva, $folio,$diagnosticoid, $diagnosticotext, $cieo10, $tipoatencion,$tipoatencion, $ecog, $ecogtext, $ingreso, $receta, $reingreso, $anamnesis, $procedimientotext, $resolucion,$modalidad);

    if($response==true){
        $c->cambiarestadoreserva($reserva,$estadoatencion);
    }

}else{
    echo json_encode(array('error' => true, 'message' => 'No se enviaron los datos correctamente'));
}
    