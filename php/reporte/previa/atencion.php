<?php
//imprimir error de debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../controller.php';
require '../../plugins/vendor/autoload.php';
$c = new Controller();
session_start();

$idusiario = 0;
if(isset($_SESSION['USER_ID'])){
    $idusuario = $_SESSION['USER_ID'];
}else{
    echo "<div class='alert alert-danger' role='alert'>Ups! Error con la sesión</div>";
    return;
}

if(isset($_GET['diagnosticoid']) && isset($_GET['diagnosticotext']) && isset($_GET['cieo10']) && isset($_GET['cieo10text']) && isset($_GET['tipoatencion']) && isset($_GET['ecog']) && isset($_GET['ecogtext']) && isset($_GET['ingreso']) && isset($_GET['receta']) && isset($_GET['reingreso']) && isset($_GET['anamnesis']) && isset($_GET['estudiocomplementarios']) && isset($_GET['cirugia']) && isset($_GET['quimioterapia']) && isset($_GET['radioterapia']) && isset($_GET['otros']) && isset($_GET['seguimiento']) && isset($_GET['completar']) && isset($_GET['revaluacion']) && isset($_GET['estudioclinicno']) && isset($_GET['observacionesdecision']) && isset($_GET['consultade']) && isset($_GET['consultadetext']) && isset($_GET['programacion']) && isset($_GET['traslado']) && isset($_GET['paliativos']) && isset($_GET['ingresohospitalario']) && isset($_GET['observacionplan']) && isset($_GET['atpacienteid']) && isset($_GET['atempresaid']) && isset($_GET['atprofesionalid']) && isset($_GET['atreservaid'])){
    $diagnosticoid = $_GET['diagnosticoid'];
    $diagnosticotext = $_GET['diagnosticotext'];
    if($diagnosticoid<=0 || strlen($diagnosticotext)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe seleccionar un diagnostico principal</div>";
        return;
    }
    $cieo10 = $_GET['cieo10'];
    $cieo10text = $_GET['cieo10text'];
    if($cieo10<=0 || strlen($cieo10text)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe seleccionar un diagnostico CIE10</div>";
        return;
    }
    $tipoatencion = $_GET['tipoatencion'];

    $ecog = $_GET['ecog'];
    $ecogtext = $_GET['ecogtext'];
    if($ecog<=0 || strlen($ecogtext)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe seleccionar un ECOG</div>";
        return;
    }
    $ingreso = $_GET['ingreso'];
    if($ingreso<=0 || strlen($ingreso)==0){
        $ingreso = 0;
    }
    $receta = $_GET['receta'];
    if($receta<=0 || strlen($receta)==0){
        $receta = 0;
    }
    $reingreso = $_GET['reingreso'];
    if($reingreso<=0 || strlen($reingreso)==0){
        $reingreso = 0;
    }
    $anamnesis = $_GET['anamnesis'];
    if(strlen($anamnesis)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe ingresar una anamnesis</div>";
        return;
    }
    $estudiocomplementarios = $_GET['estudiocomplementarios'];
    if(strlen($estudiocomplementarios)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe ingresar estudios complementarios</div>";
        return;
    }
    $cirugia = $_GET['cirugia'];
    if($cirugia<=0 || strlen($cirugia)==0){
        $cirugia = 0;
    }
    $quimioterapia = $_GET['quimioterapia'];
    if($quimioterapia<=0 || strlen($quimioterapia)==0){
        $quimioterapia = 0;
    }
    $radioterapia = $_GET['radioterapia'];
    if($radioterapia<=0 || strlen($radioterapia)==0){
        $radioterapia = 0;
    }
    $otros = $_GET['otros'];
    if($otros<=0 || strlen($otros)==0){
        $otros = 0;
    }
    $seguimiento = $_GET['seguimiento'];
    if($seguimiento<=0 || strlen($seguimiento)==0){
        $seguimiento = 0;
    }
    $completar = $_GET['completar'];
    if($completar<=0 || strlen($completar)==0){
        $completar = 0;
    }
    $revaluacion = $_GET['revaluacion'];
    if($revaluacion<=0 || strlen($revaluacion)==0){
        $revaluacion = 0;
    }
    $estudioclinicno = $_GET['estudioclinicno'];
    if($estudioclinicno<=0 || strlen($estudioclinicno)==0){
        $estudioclinicno = 0;
    }
    $observacionesdecision = $_GET['observacionesdecision'];
    if(strlen($observacionesdecision)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe ingresar observaciones de decision</div>";
        return;
    }
    $consultade = $_GET['consultade'];
    if($consultade<=0 || strlen($consultade)==0){
        $consultade = 0;
    }
    $consultadetext = $_GET['consultadetext'];
    if(strlen($consultadetext)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe ingresar observaciones de decision</div>";
        return;
    }
    $programacion = $_GET['programacion'];
    if($programacion<=0 || strlen($programacion)==0){
        $programacion = 0;
    }
    $traslado = $_GET['traslado'];
    $paliativos = $_GET['paliativos'];
    $ingresohospitalario = $_GET['ingresohospitalario'];
    if($ingresohospitalario!=5 || strlen($ingresohospitalario)==0){
        $ingresohospitalario = 0;
    }
    $observacionplan = $_GET['observacionplan'];
    if(strlen($observacionplan)==0){
        echo "<div class='alert alert-danger' role='alert'>Debe ingresar observaciones de plan</div>";
        return;
    }
    $atpacienteid = $_GET['atpacienteid'];
    if($atpacienteid<=0){
        echo "<div class='alert alert-danger' role='alert'>Ups! Error con el paciente</div>";
        return;
    }
    $atempresaid = $_GET['atempresaid'];
    if($atempresaid<=0){
        echo "<div class='alert alert-danger' role='alert'>Ups! Error al obtener la información del centro de atención</div>";
        return;
    }
    $atprofesionalid = $_GET['atprofesionalid'];
    if($atprofesionalid<=0){
        echo "<div class='alert alert-danger' role='alert'>Ups! Error al obtener la información del medico</div>";
        return;
    }
    $atreservaid = $_GET['atreservaid'];
    if($atreservaid<=0){
        echo "<div class='alert alert-danger' role='alert'>Ups! Error al obtener la información de la Consulta</div>";
        return;
    }

    $folio = 0;
    if(isset($_GET['folio'])){
        $folio = $_GET['folio'];
    }

    if($folio<=0){
        $folio = $c->buscarultimofolio($atempresaid)+1;
    }

    $paciente = $c->buscarpaciente($atpacienteid);
    $medico = $c->buscarenUsuario($atprofesionalid, $atempresaid);
    $empresa = $c->buscarEmpresa($atempresaid);
    $edad = $c->calcularEdad($paciente->getFechaNacimiento());
    $especialidad = $c->buscarespecialidad($medico->getProfesion());
    $ges = "No";
    if($c->esges($paciente->getId())==true){
        $ges = "Si";
    }
    //PDF Inicio
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle("Consulta Medica");
    $mpdf->SetAuthor("Oncoway");
    $mpdf->SetCreator("Oncoway");
    $mpdf->SetSubject("Consutla Medica");
    $mpdf->SetKeywords("Oncoway, Consulta, Medica");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetWatermarkText('Oncoway');
    //$mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    //$mpdf->SetHTMLHeader('<div style="text-align: right; font-weight: bold; font-size: 9pt; font-family: sans-serif;">{DATE j-m-Y}</div>');
    $mpdf->SetHTMLFooter('
    <div style="text-align: center; font-weight: bold; font-size: 9pt; font-family: sans-serif;">Oncoway</div>
    <div style="text-align: right; font-weight: bold; font-size: 9pt; font-family: sans-serif;">{PAGENO}/{nbpg}</div>
    ');

    //Encabezado E informacion paciente
    $contenido = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td width='70%' style='text-align: right;'>
            <h1>Consulta Medica</h1>
        </td>
        <td width='50%' style='text-align: right;'>
            <h3> FOLIO: " . $folio  . "</h3>
        </td>
    </tr>
    </table>";
    $contenido .= "<hr>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' >
    <tr>
        <td width='40%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Paciente: " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "</h3>
        </td>
        <td width='40%' style='text-align: left;'>
            <h3 style='font-size:9pt'> Edad: " . $edad . "</h3>
        </td>
        <td width='20%' style='text-align: left;'>
            <h3 style='font-size:9pt'> RUN: " . $paciente->getRUT() . "</h3>
        </td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";

    //Informacion Medico
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Atención N°: " . 
            $folio . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Fecha de atención: " . date("d-m-Y H:i") . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Centro de Atencion: ".$empresa->getRazonSocial()."</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Especialidad: " . $especialidad->getNombre() . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Medico: " . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</h3>
            
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Tipo de Atención: " . $tipoatencion . "</h3>
            
        </td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";

    //Informacion COnsulta
    //Anamnesis y Examen Fisico
    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Anamnesis y Examen Fisico</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $anamnesis . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";

    //Estudios Complementarios
    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Estudios Complementarios</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $procedimientotext . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";



    //Diagnostico Principal

    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Diagnostico Principal</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $diagnosticotext ."-".$diagnosticocie10 . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Tratamiento
    
    $contenido .= "<hr style='margin:0; margin-top:10px;'>";
    $contenido.="<h3 style='text-decoration: underline;font-size:18px; margin-top:0;'> Decision Tomada y Plan</h3>";
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border: 1px solid black;'>
    <tr style='padding-top:10px;'>
        <td width='30%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> Decision Tomada</h3>
        </td>
        <td width='70%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> Observacion</h3>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='40%' style='text-align: justify;'>";

    if ($cirugia == 1) {
        $contenido .= "<h4 style='font-size:9pt;'> Cirugia </h4>";
    }
    if ($quimioterapia == 2) {
        $contenido .= "<h4 style='font-size:9pt;'> Quimioterapia </h4>";
    }
    if ($radioterapia == 3) {
        $contenido .= "<h4 style='font-size:9pt;'> Radioterapia </h4>";
    }
    if ($otros == 4) {
        $contenido .= "<h4 style='font-size:9pt;'> Otros Tratamientos Oncologicos </h4>";
    }
    if ($seguimiento == 5) {
        $contenido .= "<h4 style='font-size:9pt;'> Seguimiento sin tratamiento activo </h4>";
    }
    if ($completar == 6) {
        $contenido .= "<h4 style='font-size:9pt;'> Completar estudios </h4>";
    }
    if ($revaluacion == 7) {
        $contenido .= "<h4 style='font-size:9pt;'> Revaluacion posterior </h4>";
    }
    if ($estudioclinicno == 8) {
        $contenido .= "<h4 style='font-size:9pt;'> Estudio clínico </h4>";
    }


    $contenido .= "</td>";
    $contenido .= "<td width='60%' style='text-align: justify;'>";
    $contenido .= "<p style='font-size:9.5pt;'>" . $observacionesdecision . "</p>";
    $contenido .= "</td>";
    $contenido .= "</tr>
    </table>";
    $contenido .= "<br>";
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border: 1px solid black;'>
    <tr>
        <td width='30%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'>Plan Asistencial</h3>
        </td>
        <td width='70%' style='text-align: justify; border-bottom: 1px solid black;font-size:9pt;'>
            <h3 style='font-size:9pt;'> Observacion</h3>
        </td>
        
    </tr>";

    $contenido .= "<tr>
        <td width='40%' style='text-align: justify; font-size:9.5pt;'>";
    $contenido .= "<h4> Consulta de:";
    if ($consultade == 1) {
        $contenido .= " Cirugia </h4>";
    }else if ($consultade == 2) {
        $contenido .= " Quimioterapia </h4>";    }


    if ($programacion == 2) {
        $contenido .= "<h4 style='font-size:9pt;'> Programacion quirurgica </h4>";
    }
    if ($traslado == 3) {
        $contenido .= "<h4 style='font-size:9pt;'> Traslado a otro centro </h4>";
    }
    if ($paliativos == 4) {
        $contenido .= "<h4 style='font-size:9pt;'> Pasa a Cuidados Paliativos </h4>";
    }
    if ($ingresohospitalario == 5) {
        $contenido .= "<h4 style='font-size:9pt;'> Ingreso Hospitalario </h4>";
    }
    $contenido .= "</td>";
    $contenido .= "<td width='60%' style='text-align: justify;'>";
    $contenido .= "<p style='font-size:9.5pt;'>" . $observacionplan . "</p>";
    $contenido .= "</td>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    


    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    $contenido .= "<br/><br/><br/><br/><br/>";

    //Seccion Firma Medico a la derecha
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='50%' style='text-align: right;'>
            <p style='font-size:9pt; padding-top:10px; width:300px; border-top:1px solid;'>" . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . " <br/> " . $medico->getRut(). "</p>
        </td>
    </tr>";
    $contenido .= "</table>";

    
    /***********Auditoria******************* */
    $titulo = "Generaracón de informe de consulta";
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha generado un informe de consulta para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2();
    $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
    /**************************************** */

    
    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "Consulta_" . $paciente->getRut()."_".date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');
}else{
    echo "Ups! Algo salió mal";
    return;
}