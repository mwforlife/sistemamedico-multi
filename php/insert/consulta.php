<?php
session_start();
require '../controller.php';
$c = new Controller();
if (isset($_POST['paciente']) && isset($_POST['empresa']) && isset($_POST['medico']) && isset($_POST['reserva']) && isset($_POST['diagnosticoid']) && isset($_POST['diagnosticotext']) && isset($_POST['cieo10']) && isset($_POST['diagnosticocie10']) && isset($_POST['tipoatencion']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['ingreso']) && isset($_POST['receta']) && isset($_POST['reingreso']) && isset($_POST['anamnesis']) && isset($_POST['procedimientotext']) && isset($_POST['resolucion']) && isset($_POST['estadoatencion'])) {
    $paciente = $_POST['paciente'];
    $paciente = $c->escapeString($paciente);
    $empresa = $_POST['empresa'];
    $empresa = $c->escapeString($empresa);
    $medico = $_POST['medico'];
    $medico = $c->escapeString($medico);
    $reserva = $_POST['reserva'];
    $reservaid = $c->escapeString($reserva);
    $diagnosticoid = $_POST['diagnosticoid'];
    $diagnosticoid = $c->escapeString($diagnosticoid);
    $diagnosticotext = $_POST['diagnosticotext'];
    $diagnosticotext = $c->escapeString($diagnosticotext);
    $cieo10 = $_POST['cieo10'];
    $cieo10 = $c->escapeString($cieo10);
    $diagnosticocie10 = $_POST['diagnosticocie10'];
    $diagnosticocie10 = $c->escapeString($diagnosticocie10);
    $tipoatencion = $_POST['tipoatencion'];
    $tipoatencion = $c->escapeString($tipoatencion);
    $ecog = $_POST['ecog'];
    $ecog = $c->escapeString($ecog);
    $ecogtext = $_POST['ecogtext'];
    $ecogtext = $c->escapeString($ecogtext);
    $ingreso = $_POST['ingreso'];
    $ingreso = $c->escapeString($ingreso);
    $receta = $_POST['receta'];
    $receta = $c->escapeString($receta);
    $reingreso = $_POST['reingreso'];
    $reingreso = $c->escapeString($reingreso);
    $anamnesis = $_POST['anamnesis'];
    $anamnesis = $c->escapeString($anamnesis);
    $procedimientotext = $_POST['procedimientotext'];
    $procedimientotext = $c->escapeString($procedimientotext);
    $resolucion = $_POST['resolucion'];
    $resolucion = $c->escapeString($resolucion);
    $estadoatencion = $_POST['estadoatencion'];
    $estadoatencion = $c->escapeString($estadoatencion);

    /*$valid  = $c->validarconsulta($reserva);
    if($valid==true){
        echo json_encode(array('error' => true, 'message' => 'Ya existe una consulta para esta reserva'));
        return;
    }*/

    $modalidad = 1;
    if($estadoatencion != 5){
        $modalidad = 2;
    }

    $folio = $c->buscarultimofolio($empresa)+1;

    $response = $c->registrarconsulta($paciente,$medico, $empresa, $reserva, $folio,$diagnosticoid, $diagnosticotext, $cieo10, $diagnosticocie10,$tipoatencion, $ecog, $ecogtext, $ingreso, $receta, $reingreso, $anamnesis, $procedimientotext, $resolucion,$modalidad);

    if($response==true){
        $titulo = "Registro de consulta";
        
        
        /***********Auditoria******************* */
        $titulo = "Registro de Comité";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva consulta";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */

        $c->cambiarestadoreserva($reserva,$estadoatencion);
       
        echo json_encode(array('error' => false, 'message' => 'Consulta registrada correctamente'));
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error al registrar la consulta'));
    }

}else{
    echo json_encode(array('error' => true, 'message' => 'No se enviaron los datos correctamente'));
}
    