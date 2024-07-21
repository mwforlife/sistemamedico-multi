<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../controller.php';
require '../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
$empresa = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($enterprise);
} else {
    echo "Ups! Hubo un problema con su sesión, por favor vuelva a iniciar sesión";
    return;
}

if (!isset($_SESSION['USER_ID'])) {
    echo "No se ha iniciado una sesión";
    return;
}

if (isset($_GET['r'])) {
    $id = $_GET['r'];
    if (!is_numeric($id)) {
        return;
    }
    $idUsuario = $_SESSION['USER_ID'];
    $receta = $c->buscarrecetabyID($id);
    $consulta = $c->buscarconsultaporid($receta->getConsulta());
    $paciente = $c->buscarpaciente($receta->getPaciente());
    $sexo = $c->buscarenGenero($paciente->getGenero());
    $sexo = $sexo->getNombre();
    $contacto = $c->listardatosubicacion($receta->getPaciente());
    $medico = $c->buscarenUsuario($receta->getUsuario(), $receta->getEmpresa());
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

    //Encabezado E informacion paciente
    $contenido = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td width='30%' style='text-align: left;'>
            <img src='../../images/hospital.png' width='100px' height='75px'>
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
    <h3 style='font-size:9pt'> FOLIO: " . $receta->getFolio() . "</h3>
        <h3 style='font-size:9pt'> Fecha de extensión: " . $receta->getFecha() . "</h3>
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
    if ($receta->getAnticipada() == 1) {
        $contenido .= "<h3 style='font-size:12pt'>Anticipada: Si</h3>";
    }
    $contenido .= "</td>
    </tr>
    <tr>
        <td width='50%' style='text-align: justify;'>
            <h3 style='font-size:12pt'> Medico: " . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</h3>
        </td>
        <td width='50%' style='text-align: right;'>";
    if ($receta->getUrgente() == 1) {
        $contenido .= "<h3 style='font-size:12pt'>Urgente: Si</h3>";
    }
    $contenido .= "</td>
    </tr>
    </table>";
    $contenido .= "<hr style='margin-top:10px; ' >";
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>
    <tr>
        <td width='100%' style='text-align: justify;'>
            <h3 style='font-size:9pt'> Diagnostico: " . $consulta->getDiagnosticotexto() . "</h3>
        </td>
    </tr>";
    $esquema = $c->buscarenesquema($receta->getEsquema());
    $contenido .= "<tr>
        <td width='100%' style='text-align: justify;'>
        <h3 style='font-size:9pt'> Esquema / Protocolo: " . $esquema->getNombre() . "</h3>
        </td>
    </tr>
    
    <tr>
    <td width='100%' style='text-align: justify;'>";
    $contenido .= "<h3 style='font-size:9pt; font-weight:bold; margin-top:0px;'>N° de Cliclo: " . $receta->getNciclo() . "</h3>
    </td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;'>
        <h3 style='font-size:9pt'> Fecha de Tratamiento: " . date("d-m-Y", strtotime($receta->getFechaAdministracion())) . "</h3>
        </td>
    </tr>
    </table>";
    //Informacion Receta
    $contenido .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:9pt'>";
    $contenido .= "<tr>";
    if ($receta->getGes() == 1) {
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
             <h3 style='font-size:9pt'> Peso: " . $receta->getPeso() . " Kg</h3>
         </td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                 <h3 style='font-size:9pt'> Talla: " . $receta->getTalla() . " cm</h3>
             </td>";
    $contenido .= "<td width='' style='text-align: justify;'>
                     <h3 style='font-size:9pt'> Superficie Corporal: " . $receta->getScorporal() . " m2</h3>
                 </td>";
    $contenido .= "</tr>";
    $contenido .= "<tr>";
    $contenido .= "<td width='' style='text-align: justify;'>";
    switch ($receta->getEstadio()) {
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
    switch ($receta->getNivel()) {
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
    if ($receta->getCarboplatino() == 1) {
        $contenido .= "<td width='' style='text-align: justify;'>
                                    <h3 style='font-size:9pt'> Creatinina: " . $receta->getCreatinina() . "</h3>
                                </td>";
        $contenido .= "<td width='' style='text-align: justify;'>
                                                <h3 style='font-size:9pt'> AUC: " . $receta->getAuc() . "</h3>
                                            </td>";
    }

    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "<h2 style='font-size:10pt; margin-top:10px; margin-bottom:0px; text-decoration:underline;'>Intención de Tratar</h2>";

    $contenido .= "<div style='width:100%;margin-top:2px;display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;'>";
    if ($receta->getAdyuvante() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Adyuvante,</label>";
    }
    if ($receta->getConcomitante() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Concomitante,</label>";
    }
    if ($receta->getCurativo() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Curativo,</label>";
    }

    if ($receta->getPaliativo() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Paliativo,</label>";
    }

    if ($receta->getNoeAdyuvante() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> NeoAdyuvante,</label>";
    }

    $contenido .= "</div>";

    $contenido .= "<h2 style='font-size:10pt; margin-top:10px; margin-bottom:0px; text-decoration:underline;'>Comorbilidades</h2>";
    $contenido .= "<div style='width:100%;margin-top:2px;display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;'>";
    if ($receta->getDiabetes() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Diabetes,</label>";
    }

    if ($receta->getHipertension() == 1) {
        $contenido .= "<label style='font-size:9pt; padding-left:15px;'> Hipertensión,</label>";
    }


    if ($receta->getAlergias() == 1) {
        $contenido .= "<p style='margin:2px;'><label style='font-size:9pt'>Alergias: Si.</label>";
        $contenido .= "<br/>- " . $receta->getDetalleAlergias() . "</p>";
    }
    if ($receta->getOtroCor() == 1) {
        $contenido .= "<p style='margin:2px;'><label style='font-size:9pt'>Otras Cormobilidades.</label>";
        $contenido .= "<br/>- " . $receta->getOtroCorMo() . "</p>";
    }

    $contenido .= "</div>";

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Seccion Medicamentos
    $premedicamentos = $c->listarpremedicacionesreceta($receta->getId());
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
            $contenido .= "<tr >";
            $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
            " . $premedicacion->getPremedicacion() . "
        </td>";
            $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
            " . $premedicacion->getDosis() . "
        </td>";
            $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>";
            if ($premedicacion->getOral() == 1) {
                $contenido .= "Oral";
            }
            if ($premedicacion->getEv() == 1) {
                $contenido .= "EV";
            }
            if ($premedicacion->getSc() == 1) {
                $contenido .= "SC";
            }
            $contenido .= "</td>";
            $contenido .= "<td width='10%' style='padding: 1px; text-align: left;'>
            " . $premedicacion->getObservacion() . "
        </td>";
            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
        $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    }
    //Seccion Medicamentos
    $medicamentos = $c->listarMedicamentosreceta($receta->getId());
    if (count($medicamentos) > 0) {
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
                <h3 style='font-size:9pt'>Dosis(mg) Esquema</h3>
            </td>
            <td width='10%' style='padding: 1px; text-align: left;'>
                <h3 style='font-size:9pt'>Total Dosis (mg)</h3>
            </td>
        <td width='10%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'>Vía de administración</h3>
        </td>
        <td width='10%' style='padding: 1px; text-align: left;'>
            <h3 style='font-size:9pt'>Observación</h3>
        </td>
    </tr>";
        foreach ($medicamentos as $medicamento) {
            $contenido .= "<tr>";
            $contenido .= "<td style='padding: 1px; text-align: left;'>
            " . $medicamento->getMedicamento() . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $medicamento->getPorcentaje() . " %
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $medicamento->getDosis() . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $medicamento->getDosistotal() . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>";
            if ($medicamento->getOral() == 1) {
                $contenido .= "Oral";
            }
            if ($medicamento->getEv() == 1) {
                $contenido .= "EV";
            }
            if ($medicamento->getSc() == 1) {
                $contenido .= "SC";
            }
            if ($medicamento->getIt() == 1) {
                $contenido .= "IT";
            }
            if ($medicamento->getBiccad() == 1) {
                $contenido .= "BICCAD";
            }
            $contenido .= "</td>";
            $contenido .= "<td style='text-align: left;'>
            " . $medicamento->getObservacion() . "
        </td>";
            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
    }

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //SEssion Estimulador
    $estimuladores = $c->listarEstimuladoresreceta($receta->getId());
    if (count($estimuladores) > 0) {
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
        foreach ($estimuladores as $estimulador) {
            $contenido .= "<tr>";
            $contenido .= "<td style='text-align: left;'>
            " . $estimulador->getNombre() . "
        </td>";
            $contenido .= "<td style='padding: 1px;text-align: left;'>
            " . $estimulador->getCantidad() . "
        </td>";
            $contenido .= "<td style='text-align: left;'>
            " . $estimulador->getRangoDias() . "";
            $contenido .= "</td>";
            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
    }

    $contenido .= "<hr style='margin:0; margin-top:10px; ' >";
    //Seccion Observaciones
    $contenido .= "<br/>";
    //Observacion
    $contenido .= "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='font-size:9pt; border-collapse: collapse; padding:5px;'>
    <tr>
    <td><h3 style='font-size:9pt'>Observaciones</h3></td>
    </tr>
    <tr>
        <td width='100%' style='text-align: justify;padding:5px;'>
            " . $receta->getObservacion() . "
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


    /***********Auditoria******************* */
    $titulo = "Generaracón de receta medica";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $object = $c->buscarenUsuario1($idUsuario);
    $idUsuario = $_SESSION['USER_ID'];
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha generado una receta Medica para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2();
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */

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
    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "Receta_" . $paciente->getRut() . "_" . date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');
}
