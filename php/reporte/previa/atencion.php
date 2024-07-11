<?php
//imprimir error de debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../controller.php';
require '../../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
}else{
return;
}

$idusiario = 0;
if(isset($_SESSION['USER_ID'])){
    $idusuario = $_SESSION['USER_ID'];
}else{
    echo "Ups! Algo salió mal";
    return;
}

/*paciente: 1
empresa: 1
medico: 1
reserva: 38
diagnosticoid: 1
diagnosticotext: Cáncer Colorrectal
cieo10: 3
diagnosticocie10: Cólera
cieo10text: undefined
tipoatencion: Oncología   
ecog: 1
ecogtext: PRUEBA
ingreso: 0
receta: 1
reingreso: 1
anamnesis: A concisely coded CSS3 button set increases usability across the board, gives you a ton of options, and keeps all the code involved to an absolute minimum. Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
procedimientotext: A concisely coded CSS3 button set increases usability across the board, gives you a ton of options, and keeps all the code involved to an absolute minimum. Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
resolucion: A concisely coded CSS3 button set increases usability across the board, gives you a ton of options, and keeps all the code involved to an absolute minimum. Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
estadoatencion: 5
folio: 6*/

if(isset($_GET['paciente']) && isset($_GET['empresa']) && isset($_GET['medico']) && isset($_GET['reserva']) && isset($_GET['diagnosticoid']) && isset($_GET['diagnosticotext']) && isset($_GET['cieo10']) && isset($_GET['diagnosticocie10']) && isset($_GET['cieo10text']) && isset($_GET['tipoatencion']) && isset($_GET['ecog']) && isset($_GET['ecogtext']) && isset($_GET['ingreso']) && isset($_GET['receta']) && isset($_GET['reingreso']) && isset($_GET['anamnesis']) && isset($_GET['procedimientotext']) && isset($_GET['resolucion'])&& isset($_GET['folio'])){

    if(!is_numeric($_GET['paciente']) || !is_numeric($_GET['empresa']) || !is_numeric($_GET['medico']) || !is_numeric($_GET['reserva']) || !is_numeric($_GET['diagnosticoid']) || !is_numeric($_GET['cieo10'])  || !is_numeric($_GET['receta']) || !is_numeric($_GET['reingreso']) || !is_numeric($_GET['ingreso'])){
        echo "Ups! Algo salió mal";
        return;
    }

    $paciente = $_GET['paciente'];
    $empresa = $_GET['empresa'];
    $medico = $_GET['medico'];
    $reserva = $_GET['reserva'];
    $diagnosticoid = $_GET['diagnosticoid'];
    $diagnosticotext = $_GET['diagnosticotext'];
    $cieo10 = $_GET['cieo10'];
    $diagnosticocie10 = $_GET['diagnosticocie10'];
    $cieo10text = $_GET['cieo10text'];
    $tipoatencion = $_GET['tipoatencion'];
    $ecog = $_GET['ecog'];
    $ecogtext = $_GET['ecogtext'];
    $ingreso = $_GET['ingreso'];
    $receta = $_GET['receta'];
    $reingreso = $_GET['reingreso'];
    $anamnesis = $_GET['anamnesis'];
    $procedimientotext = $_GET['procedimientotext'];
    $resolucion = $_GET['resolucion'];
    $folio = $_GET['folio'];

    if($folio<=0){
        $folio = $c->buscarultimofolio($empresa)+1;
    }

    $paciente = $c->buscarpaciente($paciente);
    $medico = $c->buscarenUsuario($medico, $empresa);
    $empresa = $c->buscarEmpresa($empresa);
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

    $contenido .= "<h3 style='text-decoration: underline; font-size:18px; margin-top:0;'> Tratamiento</h3>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='100%' style='text-align: justify; '>
        </td>
    </tr>";
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
            <p style='font-size:9pt; padding-top:10px;'>" . $resolucion . "</p>
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