<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../controller.php';
require '../../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    echo "No se ha iniciado una sesión";
    return;
}

if (
    isset($_GET['paciente']) && isset($_GET['medico']) && isset($_GET['empresa']) && isset($_GET['consulta']) &&
    isset($_GET['estadio']) && isset($_GET['nivel']) && isset($_GET['ges']) && isset($_GET['peso']) &&
    isset($_GET['talla']) && isset($_GET['scorporal']) && isset($_GET['creatinina']) && isset($_GET['auc']) &&
    isset($_GET['fechaadmin']) && isset($_GET['examen']) && isset($_GET['ciclo']) && isset($_GET['anticipada']) &&
    isset($_GET['curativo']) && isset($_GET['paliativo']) && isset($_GET['adyuvante']) && isset($_GET['concomitante']) &&
    isset($_GET['neoadyuvante']) && isset($_GET['primera']) && isset($_GET['traemedicamentos']) && isset($_GET['diabetes']) &&
    isset($_GET['hipertension']) && isset($_GET['alergia']) && isset($_GET['otrocor']) && isset($_GET['alergiadetalle']) && isset($_GET['otrcormo']) && isset($_GET['urgente']) &&
    isset($_GET['esquema']) && isset($_GET['medicamentoscheck']) && isset($_GET['premedicaciones']) &&
    isset($_GET['estimulador']) && isset($_GET['cantidades']) && isset($_GET['rango']) && isset($_GET['anamnesis']) &&
    isset($_GET['observaciones'])
) {
    // Capturar los datos del formulario
    $paciente = $_GET['paciente'];
    $pacienteobject = $c->buscarpaciente($paciente);
    $medico = $_GET['medico'];
    $empresa = $_GET['empresa'];
    $consulta = $_GET['consulta'];
    $estadio = $_GET['estadio'];
    $nivel = $_GET['nivel'];
    $ges = $_GET['ges'];
    $peso = $_GET['peso'];
    $talla = $_GET['talla'];
    $scorporal = $_GET['scorporal'];
    $creatinina = $_GET['creatinina'];
    $auc = $_GET['auc'];
    $fechaadmin = $_GET['fechaadmin'];
    $examen = $_GET['examen'];
    $ciclo = $_GET['ciclo'];
    $anticipada = $_GET['anticipada'];
    $curativo = $_GET['curativo'];
    $paliativo = $_GET['paliativo'];
    $adyuvante = $_GET['adyuvante'];
    $concomitante = $_GET['concomitante'];
    $neoadyuvante = $_GET['neoadyuvante'];
    $primera = $_GET['primera'];
    $traemedicamentos = $_GET['traemedicamentos'];
    $diabetes = $_GET['diabetes'];
    $hipertension = $_GET['hipertension'];
    $alergia = $_GET['alergia'];
    $otrocor = $_GET['otrocor'];
    $alergiadetalle = $_GET['alergiadetalle'];
    $otrcormo = $_GET['otrcormo'];
    $urgente = $_GET['urgente'];
    $esquema = $_GET['esquema'];

    $anamnesis = $_GET['anamnesis'];
    $observaciones = $_GET['observaciones'];


    // Capturar medicamentoscheck
    $medicamentoscheck = $_GET['medicamentoscheck'];

    // Capturar premedicaciones
    $premedicaciones = $_GET['premedicaciones'];

    // Capturar otros campos
    $estimulador = $_GET['estimulador'];
    $cantidades = $_GET['cantidades'];
    $rango = $_GET['rango'];

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

    // Validar otro cor
    if ($otrocor == 1 && empty($otrcormo)) {
        echo json_encode(array('error' => true, 'message' => 'Debe ingresar el detalle de otro cor'));
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
    if(isset($_GET['folio'])){
        if($_GET['folio']!="" && $_GET['folio']>0){
            $folio = $_GET['folio'];
        }
    }

    
    $idUsuario = $_SESSION['USER_ID'];
    $consulta = $c->buscarconsultaporid($consulta);
    $paciente = $c->buscarpaciente($paciente);
    $sexo = $c->buscarenGenero($paciente->getGenero());
    $sexo = $sexo->getNombre();
    $contacto = $c->listardatosubicacion($paciente->getId());
    $medico = $c->buscarenUsuario($idUsuario, $empresa);
    $empresa = $c->buscarEmpresa1($empresa);
    $edad = $c->calcularEdad($paciente->getFechaNacimiento());
    $especialidad = $c->buscarespecialidad($medico->getProfesion());
    $inscripcion = $c->listarinscripcionprevision($paciente->getId());
    $noficha = "";
    if ($inscripcion != null) {
        $noficha = $inscripcion->getFicha();
    }
    $ges = "No";
    if ($c->esges($paciente->getId()) == true) {
        $ges = "Si";
    }

    //PDF Inicio
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle("Receta Medica");
    $mpdf->SetAuthor("Oncoway");
    $mpdf->SetCreator("Oncoway");
    $mpdf->SetSubject("Consutla Medica");
    $mpdf->SetKeywords("Oncoway, Receta, Medica");
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
        <td width='30%' style='text-align: left;'>
            <img src='../../../images/hospital.png' width='100px' height='75px'>
        </td>
        <td width='40%' style='text-align: right;'>
            <h1>Receta Medica</h1>
        </td>
        <td width='30%' style='text-align: right;'>
            
        </td>
    </tr>
    <tr>
    <td width='30%' style='text-align: left;'>
        
    </td>
    <td width='40%' style='text-align: right;'>
        
    </td>
    <td width='30%' style='text-align: right;'>
    <h3 style='font-size:9pt'> Centro de Atencion: " . $empresa->getRazonSocial() . "</h3>
    <h3 style='font-size:9pt'> FOLIO: " . $folio . "</h3>
        <h3 style='font-size:9pt'> Fecha de extensión: " . $fecha . "</h3>
    </td>
    </tr>
    </table>";
    $contenido .= "<hr>";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' >
    <tr>
        <td width='35%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Paciente: " . $paciente->getNombre() . " " . $paciente->getApellido1() . "</h3>
        </td>
        <td width='30%' style='text-align: left;'>
            <h3 style='font-size:9pt'> Edad: " . $edad . "</h3>
        </td>
        <td width='35%' style='text-align: center;'>
            <h3 style='font-size:9pt'> RUN: " . $paciente->getRUT() . "</h3>
        </td>
    </tr>
    <tr>
        <td width='35%' style='text-align: left;'>
        <h3 style='font-size:9pt'> Sexo: " . $sexo . "</h3>
        </td>
        <td width='30%' style='text-align: left;'>
        <h3 style='font-size:9pt'> N° Ficha: " . $noficha . "</h3>
        </td>
        <td width='35%' style='text-align: center;'>
        <h3 style='font-size:9pt'> Telefono: " . $paciente->getFonomovil() . "</h3>
        </td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin-top:10px; ' >";

    //Informacion Medico
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align: justify;'>
            
        </td>
    </tr>
    <tr>
        <td width='50%' style='text-align: justify;'>
            <h3 style='font-size:12pt'> Especialidad: " . $especialidad->getNombre() . "</h3>
        </td>
        <td width='50%' style='text-align: right;'>";
        if($anticipada==1){
            $contenido .= "<h3 style='font-size:12pt'>Anticipada: Si</h3>";
        }
    $contenido .="</td>
    </tr>
    <tr>
        <td width='50%' style='text-align: justify;'>
            <h3 style='font-size:12pt'> Medico: " . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</h3>
        </td>
        <td width='50%' style='text-align: right;'>";
            if($urgente==1){
                $contenido .= "<h3 style='font-size:12pt'>Urgente: Si</h3>";
            }
        $contenido .="</td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin-top:10px; ' >";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Diagnostico: " . $consulta->getDiagnosticotexto() . "</h3>
        </td>
    </tr>";
    $esquema = $c->buscarenesquema($esquema);
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
        <h3 style='font-size:9pt'> Esquema / Protocolo: " . $esquema->getNombre() . "</h3>
        </td>
    </tr>
    
    <tr>
    <td width='100%' style='text-align: justify;'>";
    $contenido .= "<h3 style='font-size:9pt; font-weight:bold; margin-top:0px;'>N° de Cliclo: " . $ciclo . "</h3>
    </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
        <h3 style='font-size:9pt'> Fecha de Tratamiento: " . date("d-m-Y", strtotime($fechaadmin)) . "</h3>
        </td>
    </tr>
    </table>";

    //Informacion Receta
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>";
    $contenido .= "<tr>";
    if ($ges == 1) {
        $contenido .= "
         <td width='' style='text-align: justify;'>
             <h3 style='font-size:9pt'> GES: Si</h3>
         </td>";
    } else {
        $contenido .= "
         <td width='' style='text-align: justify;'>
             <h3 style='font-size:9pt'> GES: No</h3>
         </td>";
    }

    $contenido .= "<td width='' style='text-align: justify;'>
             <h3 style='font-size:9pt'> Peso: " . $peso . " Kg</h3>
         </td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                 <h3 style='font-size:9pt'> Talla: " . $talla . " cm</h3>
             </td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                     <h3 style='font-size:9pt'> Superficie Corporal: " . $scorporal . " m<sup>2<sup></h3>
                 </td>";
    $contenido .= "</tr>";
    $contenido .= "<tr>";
    $contenido .= "<td width='' style='text-align: justify;'>";
    switch ($estadio) {
        case 1:
            $contenido .= "<h3 style='font-size:9pt'> Estadio: I</h3>";
            break;
        case 2:
            $contenido .= "<h3 style='font-size:9pt'> Estadio: II</h3>";
            break;
        case 3:
            $contenido .= "<h3 style='font-size:9pt'> Estadio: III</h3>";
            break;
        case 4:
            $contenido .= "<h3 style='font-size:9pt'> Estadio: IV</h3>";
            break;
    }
    $contenido .= "</td>";
    $contenido .= "<td width='' style='text-align: justify;'>";
    switch ($nivel) {
        case 1:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: A</h3>";
            break;
        case 2:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: A1</h3>";
            break;
        case 3:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: A2</h3>";
            break;
        case 4:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: A3</h3>";
            break;
        case 5:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: B</h3>";
            break;
        case 6:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: B1</h3>";
            break;
        case 7:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: B2</h3>";
            break;
        case 8:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: B3</h3>";
            break;
        case 9:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: C</h3>";
            break;
        case 10:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: C1</h3>";
            break;
        case 11:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: C2</h3>";
            break;
        case 12:
            $contenido .= "<h3 style='font-size:9pt'> Nivel: C3</h3>";
            break;
    }
    $contenido .= "</td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                                    <h3 style='font-size:9pt'> Creatinina: " . $creatinina . "</h3>
                                </td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                                                <h3 style='font-size:9pt'> AUC: " . $auc . "</h3>
                                            </td>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "<h2 style='font-size:10pt; margin-top:10px; margin-bottom:0px; text-decoration:underline;'>Intención de Tratar</h2>";

    $contenido .= "<div style='width:100%;margin-top:2px;display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;'>";
    if ($adyuvante == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Adyuvante,</label>";
    }
    if ($concomitante == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Concomitante,</label>";
    }
    if ($curativo == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Curativo,</label>";
    }

    if ($paliativo == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Paliativo,</label>";
    }

    if ($neoadyuvante == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Neoadyuvante,</label>";
    }

    $contenido .= "</div>";
    
    $contenido .= "<h2 style='font-size:10pt; margin-top:10px; margin-bottom:0px; text-decoration:underline;'>Comorbilidades</h2>";
    $contenido .= "<div style='width:100%;margin-top:2px;display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;'>";
    if ($diabetes == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Diabetes,</label>";
    }

    if ($hipertension == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Hipertensión,</label>";
    }


    if ($alergia == 1) {
        $contenido .= "<p style='margin:2px;'><label style='font-size:9pt'>Alergias: Si.</label>";
        $contenido .= "<br/>- " . $alergiadetalle . "</p>";
    }
    if ($otrocor == 1) {
        $contenido .= "<p style='margin:2px;'><label style='font-size:9pt'>Otras Cormobilidades.</label>";
        $contenido .= "<br/>- " . $otrcormo . "</p>";
    }

    $contenido .= "</div>";

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";


//Seccion Premedicaciones
$premedicamentos = json_decode($premedicaciones, true);
if (count($premedicamentos) > 0) {
    $contenido .= "<h2 style='font-size:12pt; margin-top:10px;'>PREMEDICACIÓN</h2>";
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='20%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'> Medicamentos</h3>
        </td>
        <td width='10%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'> Dosis (mg)</h3>
        </td>
        <td width='20%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'> Vía de administración</h3>
        </td>
        <td width='50%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'> Observación
        </td>
    </tr>";
    foreach ($premedicamentos as $premedicacion) {
        $premedic = $c->buscarpremedicacion($premedicacion['premedicacion']);
        $contenido .= "<tr >";
        $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
                    " . $premedic->getNombre() . "
                    </td>";
                        $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
                        " . $premedicacion['dosis']."
                    </td>";
                        $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>";
                        if ($premedicacion['oral'] == 1) {
                            $contenido .= "Oral";
                        }
                        if ($premedicacion['ev'] == 1) {
                            $contenido .= "EV";
                        }
                        if ($premedicacion['sc'] == 1) {
                            $contenido .= "SC";
                        }
                        $contenido .= "</td>";
                        $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
                        " . $premedicacion['observacion'] . "
                    </td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</table>";
    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
}

$medicamentoscheck = json_decode($medicamentoscheck, true);

    //Seccion Medicamentos
    if (count($medicamentoscheck) > 0) {
        $contenido .= "<h2 style='font-size:12pt; margin-top:10px;'>CITOSTATICOS</h2>";
        //Seccion Firma Medico a la derecha
        $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='25%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'> Medicamentos</h3>
            </td>
            <td width='10%' style='padding: 1px; text-align: left;'>
                <h3 style='font-size:9pt'>Porcentaje</h3>
            </td>>
            </td>
            <td width='10%' style='padding: 1px; text-align: left;'>
                <h3 style='font-size:9pt'>Dosis (mg)</h3>
            </td>
        <td width='10%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'>Vía de administración</h3>
        </td>
        <td width='10%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'>Observación</h3>
        </td>
    </tr>";
        foreach ($medicamentoscheck as $medicamento) {
            $contenido .= "<tr>";
            $medic = $c->buscarmedicamento($medicamento['medicamento']);
            $contenido .= "<td style='padding: 1px; text-align: left;'>
            " . $medic->getNombre() . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $medicamento['porcentaje'] . " %
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $medicamento['medida'] . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>";
            if ($medicamento['oral'] == 1) {
                $contenido .= "Oral";
            }
            if ($medicamento['ev'] == 1) {
                $contenido .= "EV";
            }
            if ($medicamento['sc'] == 1) {
                $contenido .= "SC";
            }
            if ($medicamento['it'] == 1) {
                $contenido .= "IT";
            }
            if ($medicamento['biccad'] == 1) {
                $contenido .= "BICCAD";
            }
            $contenido .= "</td>";
            $contenido .= "<td style='text-align: left;'>
            " . $medicamento['observacion'] . "
        </td>";
            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
    }

    
    //SEssion Estimulador
    if ($estimulador == 1) {
        $contenido .= "<h2 style='font-size:12pt; margin-top:10px;'>ESTIMULADORES</h2>";
        //Seccion Firma Medico a la derecha
        $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; '>";
        $contenido .= "<tr>
        <td width='25%' style='text-align: left;'>
            <h3 style='font-size:9pt'> Medicamento</h3>
        </td>
        <td width='25%' style='text-align: left;'>
            <h3 style='font-size:9pt'> Cantidad</h3>
        </td>
        <td width='50%' style='text-align: left;'>
            <h3 style='font-size:9pt'> Rango de dias</h3>
        </td>
        </tr>";
            $contenido .= "<tr>";
            $contenido .= "<td style='text-align: left;'>FILGRASTIM</td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>" . $cantidades . "</td>";
            $contenido .= "<td style='text-align: left;'>" . $rango . "</td>";
            $contenido .= "</tr>";
        $contenido .= "</table>";
    }

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Seccion Observaciones
    //Anamnesis
    $contenido .= "<h2 style='font-size:12pt; margin-top:10px;'>OBSERVACIONES GENERALES</h2>";
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border-collapse: collapse; padding:5px;'>
    <tr>
    <td><h3 style='font-size:9pt'>Anamnesis</h3></td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;padding:5px;'>
             " . $anamnesis . "
        </td>
    </tr>
    </table>";

    $contenido .= "<br/>";
    //Observacion
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border-collapse: collapse; padding:5px;'>
    <tr>
    <td><h3 style='font-size:9pt'>Observaciones</h3></td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;padding:5px;'>
            " . $observaciones. "
        </td>
        </tr>
    </table>";




    $contenido .= "<br/><br/><br/><br/><br/>";

    //Seccion Firma Medico a la derecha
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt; '>
    <tr>
        <td width='50%' style='text-align: right;'>
            <p style='font-size:9pt; padding-top:10px; width:300px; border-top:1px solid;'>" . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . " <br/> " . $medico->getRut() . "</p>
        </td>
    </tr>";
    $contenido .= "</table>";

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";




    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "Receta_" . $paciente->getRut() . "_" . date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');

}else{
    echo json_encode(array('error' => true, 'message' => 'Faltan datos'));
    return;
}