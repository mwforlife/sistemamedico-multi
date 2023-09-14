<?php
require '../controller.php';
require '../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
}else{
return;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id <= 0) {
        echo "<div class='col-md-12 alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i>Ups! No se ha podido cargar el informe</div>";
        return;
    }
    $informe = $c->buscarinformecomite($id);
    if ($informe == null) {
        echo "<div class='col-md-12 alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i>Ups! No se ha podido cargar el informe</div>";
        return;
    }
    $diagnosticosinforme = $c->buscardiagnosticoscomite($informe->getDiagnosticos());
    $paciente = $c->buscarpaciente($informe->getPaciente());
    $fechanacimiento = $paciente->getFechanacimiento();
    $edad = $c->calcularEdad($fechanacimiento);
    $comite = $c->buscarcomiteIDvalores($informe->getComite());
    $sig = $c->buscarsignovital($informe->getPaciente());
    $med = $c->buscarmedidaantropometrica($informe->getPaciente());
    $pacientecomite = $c->buscarpacientecomiteval($informe->getPaciente(), $informe->getComite());
    $ecog = $c->buscarenecog($informe->getEcog());
    $histologico = $c->buscarenhistologico($informe->getHistologico());
    $invasiontumoral = $c->buscareninvaciontumoral($informe->getInvaciontumoral());
    $listaprofesionales = $c->buscarprofesionalescomite($comite->getId(), $empresa->getid());
    $profesionales ="";
    foreach ($listaprofesionales as $listaprofesional) {
        $nombreprofesional = $listaprofesional->getnombre();
        $profesionprofesional = $listaprofesional->getprofesion();
        $profesionales .= $nombreprofesional . " - " . $profesionprofesional . " /";
    }
    $sc = $c->calculateBSA($med->getPeso(), $med->getTalla());
    //PDF Inicio
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle("Informe Comite");
    $mpdf->SetAuthor("Oncoway");
    $mpdf->SetCreator("Oncoway");
    $mpdf->SetSubject("Informe Comite");
    $mpdf->SetKeywords("Oncoway, Informe, Comite");
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

    $contenido = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td width='70%' style='text-align: right;'>
            <h1>Informe Comite</h1>
        </td>
        <td width='50%' style='text-align: right;'>
            <h3> FOLIO: " . $comite->getFolio() . "</h3>
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
    $contenido .= "<hr>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Fecha de atención: " . date("d-m-Y", strtotime($comite->getFecha())) . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Centro de Atencion: ".$empresa->getRazonSocial()."</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Especialidad: " . $comite->getNombre() . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Profesional: " . $profesionales . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Medico Tratante: " . $pacientecomite->getProfesional() . "</h3>
            
        </td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    $contenido .= "<h3 style='text-decoration: underline; font-size: 18px; margin:0; margin-bottom:5px;'> Anamnesis</h3>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align:'> <h3 style='font-size:9pt'>Peso: " . $med->getPeso() . " kG,  Talla: " . $med->getTalla() . "CM, Superficie Corporal: " . $sc . " m2</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;  '>
            <h3 style='font-size:9pt'> ECOG: " . $ecog->getNombre() . "</h3>
            <h3 style='font-size:9pt'> Diagnostico: " . $diagnosticosinforme->getDiagnosticos() . "</h3>           
        </td>
    </tr>
    </table>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' >
    <tr>
        <td width='6%' style='text-align: justify; '>
            <h3 style='font-size:9pt'> TNM:</h3>
        </td>
        <td width='96%' style='text-align: justify; '>
        <h3 style='font-size:9pt'>Primario Clinico: " . $informe->getTnmprimario() . "</h3>
        </td>
        </tr>
        <tr>
        <td width='6%' style='text-align: justify; '>
            <h3 style='text-decoration: underline; font-size:13px;'> </h3>
        </td>
        <td width='96%' style='text-align: justify; '>
        <h3 style='font-size:9pt'> Regionales Clinico: " . $informe->getTnmregionales() . "</h3>
        <h3 style='font-size:9pt'>Distancia Clinico: " . $informe->getTnmdistancia() . "</h3>
        </td>
    </tr>
    </table>
    <hr style='margin:0; margin-top:10px; ' >
    <h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Anamnesis y Examen Fisico</h3>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $informe->getAnamesis() . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
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

    if ($informe->getCirugia() == 1) {
        $contenido .= "<h4 style='font-size:9pt;'> Cirugia </h4>";
    }
    if ($informe->getQuimioterapia() == 2) {
        $contenido .= "<h4 style='font-size:9pt;'> Quimioterapia </h4>";
    }
    if ($informe->getRadioterapia() == 3) {
        $contenido .= "<h4 style='font-size:9pt;'> Radioterapia </h4>";
    }
    if ($informe->getTratamientosoncologicos() == 4) {
        $contenido .= "<h4 style='font-size:9pt;'> Otros Tratamientos Oncologicos </h4>";
    }
    if ($informe->getSeguimientosintratamiento() == 5) {
        $contenido .= "<h4 style='font-size:9pt;'> Seguimiento sin tratamiento activo </h4>";
    }
    if ($informe->getCompletarestudios() == 6) {
        $contenido .= "<h4 style='font-size:9pt;'> Completar estudios </h4>";
    }
    if ($informe->getRevaluacionposterior() == 7) {
        $contenido .= "<h4 style='font-size:9pt;'> Revaluacion posterior </h4>";
    }
    if ($informe->getEstudioclinico() == 8) {
        $contenido .= "<h4 style='font-size:9pt;'> Estudio clínico </h4>";
    }


    $contenido .= "</td>";
    $contenido .= "<td width='60%' style='text-align: justify;'>";
    $contenido .= "<p style='font-size:9.5pt;'>" . $informe->getObservaciondesicion() . "</p>";
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
    $contenido .= "<h4> Consulta de:" . $informe->getConsultade() . "</h4>";

    if ($informe->getProgramacionquirurgica() == 2) {
        $contenido .= "<h4 style='font-size:9pt;'> Programacion quirurgica </h4>";
    }
    if ($informe->getTraslado() == 3) {
        $contenido .= "<h4 style='font-size:9pt;'> Traslado a otro centro </h4>";
    }
    if ($informe->getCiudadospaliativos() == 4) {
        $contenido .= "<h4 style='font-size:9pt;'> Pasa a Cuidados Paliativos </h4>";
    }
    if ($informe->getIngresohospitalario() == 5) {
        $contenido .= "<h4 style='font-size:9pt;'> Ingreso Hospitalario </h4>";
    }
    $contenido .= "</td>";
    $contenido .= "<td width='60%' style='text-align: justify;'>";
    $contenido .= "<p style='font-size:9.5pt;'>" . $informe->getObservacionplan() . "</p>";
    $contenido .= "</td>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin-bottom:0;'>
    <h3 style='font-size:18px; text-decoration:underline; margin-top:0;'> Resolución Comité</h3>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify;  '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify; font-size:9pt;'>
            <p style='font-size:9pt;'>" . $informe->getResolucion() . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";

    
    /***********Auditoria******************* */
    $titulo = "Generaracón de informe de comité";
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha generado un informe de Comité para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2();
    $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
    /**************************************** */

    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "Informe_" . $paciente->getRut()."_".date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');
} else {
    echo "<div class='col-md-12 alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i>Ups! No se ha podido cargar el informe</div>";
    return;
}
