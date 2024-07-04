<?php
require '../controller.php';
$c = new Controller();
session_start();
$enterprise = 0;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($enterprise);
} else {
    echo "No se ha seleccionado una empresa";
    return;
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $pacientes = $c->buscarpaciente($id);
    if ($pacientes != null) {
        $pacienteid = $pacientes['id'];
        $inscripcion = $c->listarinscripcionprevision($pacienteid);
        $datosubicacion = $c->listardatosubicacion($pacienteid);
        $otros = $c->listarotrosantecedentes($pacienteid);
        $responsable = $c->listarresponsable($pacienteid);

        $id = $pacientes['id'];
        $rut = $pacientes['rut'];
        $nombre = $pacientes['nombre'];
        $apellido1 = $pacientes['apellido1'];
        $apellido2 = $pacientes['apellido2'];
        $identificacion = $pacientes['identificacion'];
        $nacionalidad = $pacientes['nacionalidad'];
        $ficha = "";
        $ubicacion = "";
        $social = $pacientes['nombresocial'];
        $ano = date("Y", strtotime($pacientes['fechanacimiento']));
        $dia = date("d", strtotime($pacientes['fechanacimiento']));
        $mes = date("m", strtotime($pacientes['fechanacimiento']));
        $ano_actual = date("Y");
        $mes_actual = date("m");
        $dia_actual = date("d");
        $edad = $ano_actual - $ano;
        if ($mes_actual < $mes) {
            $edad--;
        } else {
            if ($mes_actual == $mes) {
                if ($dia_actual < $dia) {
                    $edad--;
                }
            }
        }
        $edad = $edad . " años";
        $genero = $pacientes['genero'];
        $prevision = "";
        $estadoafiliacion = "";
        $direccion = "";
        $fonomovil = $pacientes['fonomovil'];
        $email = $pacientes['email'];
        $inscrito = "";

        if ($inscripcion != null) {
            $ficha = $inscripcion->getFicha();
            $ubicacion = $inscripcion->getUbicacionficha();
            $prevision = $inscripcion->getTipoprevision();
            $prevision = $c->buscartipoprevisionvalores($prevision);
            $prevision = $prevision->getCodigo() . " - " . $prevision->getNombre();
            $estadoafiliacion = $inscripcion->getEstadoafiliar();
            if ($estadoafiliacion == 1) {
                $estadoafiliacion = "Activo";
            } else if ($estadoafiliacion == 2) {
                $estadoafiliacion = "Inactivo";
            }
            $inscrito = $inscripcion->getInscrito();
        }

        if ($datosubicacion != null) {
            $direccion = $datosubicacion->getNombrecalle() . " " . $datosubicacion->getNumerocalle();
        }

        $paciente = array("id" => $id, "rut" => $rut, "nombre" => $nombre, "apellido1" => $apellido1, "apellido2" => $apellido2, "identificacion" => $identificacion, "nacionalidad" => $nacionalidad, "edad" => $edad, "genero" => $genero, "social" => $social, "fonomovil" => $fonomovil, "email" => $email, "ficha" => $ficha, "ubicacion" => $ubicacion, "prevision" => $prevision, "estadoafiliacion" => $estadoafiliacion, "direccion" => $direccion, "inscrito" => $inscrito);

        echo json_encode(array("error" => false, "mensaje" => "Se encontraron pacientes con el rut ingresado", "paciente" => $paciente));
    } else {
        echo json_encode(array("error" => true, "mensaje" => "No se encontraron pacientes con el rut ingresado"));
    }
}else{
    echo json_encode(array("error"=>true,"mensaje"=>"No se ha ingresado una accion"));
}
