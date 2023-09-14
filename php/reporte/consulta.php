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

if(isset($_GET['c'])){
    $id = $_GET['c'];
    if(!is_numeric($id)){
        return;
    }
    $consulta = $c->buscarconsultaporid($id);
    $paciente = $c->buscarpaciente($consulta->getPaciente());
    $medico = $c->buscarenUsuario($consulta->getUsuario(), $consulta->getEmpresa());
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
            <h3> FOLIO: " . $consulta->getFolio() . "</h3>
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
            $consulta->getId() . "</h3>
        </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Fecha de atención: " . date("d-m-Y H:i", strtotime($consulta->getRegistro())) . "</h3>
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
            <h3 style='font-size:9pt'> Tipo de Atención: " . $consulta->getTipodeatencion() . "</h3>
            
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
            <p style='font-size:9pt; padding-top:10px;'>" . $consulta->getAnamesis() . "</p>
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
            <p style='font-size:9pt; padding-top:10px;'>" . $consulta->getEstudiocomplementarios() . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";

    //Hipotesis Diagnostica

    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Hipotesis Diagnostica</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'></p>
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
            <p style='font-size:9pt; padding-top:10px;'>" . $consulta->getDiagnosticotexto() . " - " . $consulta->getDiagnosticocie10texto() . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Tratamiento

    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Tratamiento</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $consulta->getPlantratamiento() . " </p><br/>
            ";
            
            if($ges=="Si"){
                $contenido .= "<h3>GES: Si</h3>";
            }else{
                $contenido .= "<h3>GES: No</h3>";
            }
            $contenido .= "
        </td>
    </tr>";
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Indicaciones

    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Indicaciones</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'></p>
        </td>
    </tr>";
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
}