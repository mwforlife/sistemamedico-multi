<?php
require '../../controller.php';
require '../../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
$userid = 0;
if(isset($_SESSION['USER_ID'])){
    $userid = $_SESSION['USER_ID'];
}else{
    echo json_encode(array("status" => false, "status_code" => 500, "message" => "No se ha iniciado sesión"));
    exit();
}
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
}else{
    echo json_encode(array("status" => false, "status_code" => 500, "message" => "No se ha seleccionado una empresa"));
    exit();
}
if(isset($_GET['informe'])){
    $informe = json_decode($_GET['informe']);
    $paciente = $informe->paciente;
    $comite = $informe->comite;
    $diagnostico = $informe->diagnostico;
    $diagnosticotext = $informe->diagnosticotext;
    $diagnosticocie10 = $informe->diagnosticocie10;
    $diagnosticocie10text = $informe->diagnosticocie10text;
    $fechabiopsia = $informe->fechabiopsia;
    $reingreso = $informe->reingreso;
    $ecog = $informe->ecog;
    $ecogtext = $informe->ecogtext;
    $histologico = $informe->histologico;
    $histologicotext = $informe->histologicotext;
    $invasiontumoral = $informe->invasiontumoral;
    $invasiontumoraltext = $informe->invasiontumoraltext;
    $mitotico = $informe->mitotico;
    $tnm = $informe->tnm;
    $observaciontnm = $informe->observaciontnm;
    $anamnesis = $informe->anamnesis;
    $cirugia = $informe->cirugia;
    $quimioterapia = $informe->quimioterapia;
    $radioterapia = $informe->radioterapia;
    $otros = $informe->otros;
    $seguimiento = $informe->seguimiento;
    $completar = $informe->completar;
    $revaluacion = $informe->revaluacion;
    $estudioclinicno = $informe->estudioclinicno;
    $observacionesdecision = $informe->observacionesdecision;
    $consultade = $informe->consultade;
    $consultadetext = $informe->consultadetext;
    $programacion = $informe->programacion;
    $traslado = $informe->traslado;
    $paliativos = $informe->paliativos;
    $ingreso = $informe->ingreso;
    $observacionplan = $informe->observacionplan;
    $resolucion = $informe->resolucion;

    $paciente = $c->buscarpaciente($paciente);
    $fechanacimiento = $paciente->getFechanacimiento();
    $edad = $c->calcularEdad($fechanacimiento);
    $comite = $c->buscarcomiteIDvalores($comite);
    $sig = $c->buscarsignovital($paciente->getId());
    $med = $c->buscarmedidaantropometrica($paciente->getId());
    $pacientecomite = $c->buscarpacientecomiteval($paciente->getId(), $comite->getId());
    $listaprofesionales = $c->buscarprofesionalescomite($comite->getId(), $empresa->getid());
    $profesionales ="";
    foreach ($listaprofesionales as $listaprofesional) {
        $nombreprofesional = $listaprofesional->getnombre();
        $profesionprofesional = $listaprofesional->getprofesion();
        $profesionales .= $nombreprofesional . " - " . $profesionprofesional . " /";
    }

    $contenido = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td width='70%' style='text-align: right;'>
            <h1>Informe Comite</h1>
        </td>
        <td width='50%' style='text-align: right;'>
            <h3> FOLIO: - </h3>
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
            <h3 style='font-size:9pt'> Centro de Atencion: " . $empresa->getRazonSocial() . "</h3>
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
            <h3 style='font-size:9pt'> ECOG: " . $ecogtext . "</h3>
            <h3 style='font-size:9pt'> Diagnostico: " . $diagnosticotext . "</h3>           
        </td>
    </tr>
    </table>";

    //TNM
    $contenido .= "<hr style='margin:0; margin-top:10px; '>";
    $contenido .= "<h3 style='text-decoration: underline; font-size: 18px; margin:0; margin-bottom:5px;'> TNM</h3>";
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border: 1px solid black;'>
    <tr>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> _T</h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> _T</h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> T </h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> _N</h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> N</h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> _M</h3>
        </td>
        <td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> M</h3>
        </td>
        <td width='30%' style='text-align: justify; border-bottom: 1px solid black;'>
            <h3 style='font-size:9pt;'> M_</h3>
        </td>
        </tr>";
        foreach ($tnm as $tn) {
            $contenido .= "<tr>";
            $contenido .= "<td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->t1 . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->t2 . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='15%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->ttext . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->n1 . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='15%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->ntext . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->m1 . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='15%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->mtext . "</h4>";
            $contenido .= "</td>";
            $contenido .= "<td width='10%' style='text-align: justify; border-bottom: 1px solid black;'>";
            $contenido .= "<h4 style='font-size:9pt;'>" . $tn->m2 . "</h4>";
            $contenido .= "</td>";
            $contenido .= "</tr>";
        }
    $contenido .= "</table>";

    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
            <h3 style='font-size:9pt;'> Observaciones: </h3>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt;'>" . $observaciontnm . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";

    //Fin TNM
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
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

    $contenido .= "<hr style='margin:0; margin-top:10px;'>";
    $contenido .= "<h3 style='text-decoration: underline;font-size:18px; margin-top:0;'> Decision Tomada y Plan</h3>";
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
    $contenido .= "<h4> Consulta de:" . $consultadetext . "</h4>";

    if ($programacion == 2) {
        $contenido .= "<h4 style='font-size:9pt;'> Programacion quirurgica </h4>";
    }
    if ($traslado == 3) {
        $contenido .= "<h4 style='font-size:9pt;'> Traslado a otro centro </h4>";
    }
    if ($paliativos == 4) {
        $contenido .= "<h4 style='font-size:9pt;'> Pasa a Cuidados Paliativos </h4>";
    }
    if ($ingreso == 5) {
        $contenido .= "<h4 style='font-size:9pt;'> Ingreso Hospitalario </h4>";
    }
    $contenido .= "</td>";
    $contenido .= "<td width='60%' style='text-align: justify;'>";
    $contenido .= "<p style='font-size:9.5pt;'>" . $observacionplan . "</p>";
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
            <p style='font-size:9pt;'>" . $resolucion . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";


    //PDF Inicio
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle("Vista Previa Informe Comite ".$paciente->getNombre()." ".$paciente->getApellido1()." ".$paciente->getApellido2());
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
    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "Informe_" . $paciente->getRut() . "_" . date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');



}else{
    echo json_encode(array("status" => false, "status_code" => 500, "message" => "No se ha enviado suficientes datos para generar el informe"));
}