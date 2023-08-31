<?php
require '../controller.php';
$c = new Controller();
if (
    isset($_POST['paciente']) && isset($_POST['medico']) && isset($_POST['empresa']) && isset($_POST['consulta']) &&
    isset($_POST['estadio']) && isset($_POST['nivel']) && isset($_POST['ges']) && isset($_POST['peso']) &&
    isset($_POST['talla']) && isset($_POST['scorporal']) && isset($_POST['creatinina']) && isset($_POST['auc']) &&
    isset($_POST['fechaadmin']) && isset($_POST['examen']) && isset($_POST['ciclo']) && isset($_POST['anticipada']) &&
    isset($_POST['curativo']) && isset($_POST['paliativo']) && isset($_POST['adyuvante']) && isset($_POST['concomitante']) &&
    isset($_POST['neoadyuvante']) && isset($_POST['primera']) && isset($_POST['traemedicamentos']) && isset($_POST['diabetes']) &&
    isset($_POST['hipertension']) && isset($_POST['alergia']) && isset($_POST['alergiadetalle']) && isset($_POST['urgente']) &&
    isset($_POST['esquema']) && isset($_POST['medicamentoscheck']) && isset($_POST['premedicaciones']) &&
    isset($_POST['estimulador']) && isset($_POST['cantidades']) && isset($_POST['rango']) && isset($_POST['anamnesis']) &&
    isset($_POST['observaciones'])
) {
    // Capturar los datos del formulario
    $paciente = $_POST['paciente'];
    $medico = $_POST['medico'];
    $empresa = $_POST['empresa'];
    $consulta = $_POST['consulta'];
    $estadio = $_POST['estadio'];
    $nivel = $_POST['nivel'];
    $ges = $_POST['ges'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];
    $scorporal = $_POST['scorporal'];
    $creatinina = $_POST['creatinina'];
    $auc = $_POST['auc'];
    $fechaadmin = $_POST['fechaadmin'];
    $examen = $_POST['examen'];
    $ciclo = $_POST['ciclo'];
    $anticipada = $_POST['anticipada'];
    $curativo = $_POST['curativo'];
    $paliativo = $_POST['paliativo'];
    $adyuvante = $_POST['adyuvante'];
    $concomitante = $_POST['concomitante'];
    $neoadyuvante = $_POST['neoadyuvante'];
    $primera = $_POST['primera'];
    $traemedicamentos = $_POST['traemedicamentos'];
    $diabetes = $_POST['diabetes'];
    $hipertension = $_POST['hipertension'];
    $alergia = $_POST['alergia'];
    $alergiadetalle = $_POST['alergiadetalle'];
    $urgente = $_POST['urgente'];
    $esquema = $_POST['esquema'];

    $anamnesis = $_POST['anamnesis'];
    $observaciones = $_POST['observaciones'];


    // Capturar medicamentoscheck
    $medicamentoscheck = $_POST['medicamentoscheck'];

    // Capturar premedicaciones
    $premedicaciones = $_POST['premedicaciones'];

    // Capturar otros campos
    $estimulador = $_POST['estimulador'];
    $cantidades = $_POST['cantidades'];
    $rango = $_POST['rango'];

    // Validar datos
    if ($estadio == 0) {
        echo json_encode(array('error' => true, 'message' => 'Seleccione un estadio'));
        return;
    }

    if ($nivel == 0) {
        echo json_encode(array('error' => true, 'message' => 'Seleccione un nivel'));
        return;
    }

    if ($ges == 0) {
        echo json_encode(array('error' => true, 'message' => 'Seleccione un GES'));
        return;
    }

    if (empty($peso)) {
        echo json_encode(array('error' => true, 'message' => 'El peso no puede estar vacío'));
        return;
    }

    if (empty($talla)) {
        echo json_encode(array('error' => true, 'message' => 'La talla no puede estar vacía'));
        return;
    }

    if (empty($scorporal)) {
        echo json_encode(array('error' => true, 'message' => 'El S. Corporal no puede estar vacío'));
        return;
    }

    if (empty($creatinina)) {
        echo json_encode(array('error' => true, 'message' => 'La creatinina no puede estar vacía'));
        return;
    }

    if (empty($auc)) {
        echo json_encode(array('error' => true, 'message' => 'El AUC no puede estar vacío'));
        return;
    }

    if (empty($fechaadmin)) {
        echo json_encode(array('error' => true, 'message' => 'La fecha de administración no puede estar vacía'));
        return;
    }

    if (empty($examen)) {
        echo json_encode(array('error' => true, 'message' => 'El examen no puede estar vacío'));
        return;
    }

    if (empty($ciclo)) {
        echo json_encode(array('error' => true, 'message' => 'El ciclo no puede estar vacío'));
        return;
    }

    if (empty($anticipada)) {
        echo json_encode(array('error' => true, 'message' => 'La anticipada no puede estar vacía'));
        return;
    }

    if (empty($urgente)) {
        echo json_encode(array('error' => true, 'message' => 'Debe seleccionar si es urgente o no'));
        return;
    }

    // Validar alergia
    if ($alergia == 1 && empty($alergiadetalle)) {
        echo json_encode(array('error' => true, 'message' => 'Debe ingresar el detalle de la alergia'));
        return;
    }

    if ($esquema == 0) {
        echo json_encode(array('error' => true, 'message' => 'Seleccione un esquema'));
        return;
    }

    // Validar medicamentos
    if (empty($medicamentoscheck)) {
        echo json_encode(array('error' => true, 'message' => 'Debe seleccionar al menos un medicamento'));
        return;
    }

    // Validar premedicaciones
    if (empty($premedicaciones)) {
        echo json_encode(array('error' => true, 'message' => 'Debe seleccionar al menos una premedicación'));
        return;
    }

    // Validar estimulador
    if ($estimulador == 1) {
        if (empty($cantidades)) {
            echo json_encode(array('error' => true, 'message' => 'La cantidad no puede estar vacía'));
            return;
        }

        if (empty($rango)) {
            echo json_encode(array('error' => true, 'message' => 'El rango no puede estar vacío'));
            return;
        }
    }

    if (empty($anamnesis)) {
        echo json_encode(array('error' => true, 'message' => 'La anamnesis no puede estar vacía'));
        return;
    }

    if (empty($observaciones)) {
        echo json_encode(array('error' => true, 'message' => 'Las observaciones no pueden estar vacías'));
        return;
    }

    $fecha = date('Y-m-d');
    $folio = $c->buscarultimofolioreceta($empresa,$medico) + 1;

    // Llama a la función para registrar la receta
    $recetaId = $c->registrarReceta($paciente, $medico, $empresa, $consulta,$fecha,$folio, $estadio, $nivel, $ges, $peso, $talla, $scorporal, $creatinina, $auc, $fechaadmin, $examen, $ciclo, $anticipada, $curativo, $paliativo, $adyuvante, $concomitante, $neoadyuvante, $primera, $traemedicamentos, $diabetes, $hipertension, $alergia, $alergiadetalle, $urgente, $esquema, $anamnesis, $observaciones);


    if ($recetaId > 0) {    
        // Registrar premedicaciones
        $c->registrarPremedicaciones($recetaId, $premedicaciones);
    
        // Registrar medicamentos
        $c->registrarMedicamentosreceta($recetaId, $medicamentoscheck);
    
        // Registrar estimulador
        if($estimulador == 1){
            $c->registrarEstimulador($recetaId, $estimulador, $cantidades, $rango);
        }
        // Todas las inserciones se realizaron correctamente
        echo json_encode(array('error' => false, 'message' => 'Receta registrada exitosamente.'));
    } else {
        // Hubo un error al registrar la receta
        echo json_encode(array('error' => true, 'message' => 'Error al registrar la receta.'));
    }

} else {
    echo json_encode(array('error' => true, 'message' => 'No se enviaron los datos correctamente'));
    return;
}
