<?php
require '../controller.php';
$c = new Controller();
session_start();

$empresa = null;
$usuario = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($enterprise);
}
if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(array("status" => false, "message" => "No se ha iniciado sesión"));
    return;
} else {
    $valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        echo  json_encode(array("status" => false, "message" => "Sesión no válida"));
        return;
    }
}
$id = $_SESSION['USER_ID'];
$usuario = $c->buscarenUsuario1($id);

if(isset($_SESSION['DESDE']) && isset($_SESSION['HASTA'])){
    $fechainicio = $_SESSION['DESDE'];
    $fechatermino = $_SESSION['HASTA'];
}

if (isset($_POST['fechainicio']) && isset($_POST['fechatermino'])) {
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];

    if (strlen($fechainicio) < 10 || strlen($fechatermino) < 10) {
        echo json_encode(array("status" => false, "message" => "Debe ingresar la fecha de inicio y la fecha de término"));
        return;
    }

    $_SESSION['DESDE'] = $fechainicio;
    $_SESSION['HASTA'] = $fechatermino;

    if ($fechatermino < $fechainicio) {
        echo json_encode(array("status" => false, "message" => "La fecha de término no puede ser menor a la fecha de inicio"));
        return;
    }

    $contenido = "";

    if ($empresa != null && $usuario != null) {
        $lista = $c->buscarreservasrangomedico($empresa->getId(),$id, $fechainicio, $fechatermino);
        $contenido = '<div class="table-responsive">
            <table class="table w-100 text-wrap text-center" id="example1">
                <thead class="border-top">
                    <tr class="">
                        <th class="bg-transparent">Fecha</th>
                        <th class="bg-transparent">Hora</th>
                        <th class="bg-transparent">Identificación</th>
                        <th class="bg-transparent">Nombre Paciente</th>
                        <th class="bg-transparent">Intervalo</th>
                        <th class="bg-transparent">Estado</th>
                        <th class="bg-transparent">Hora de Espera</th>
                        <th class="bg-transparent">Acción</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($lista as $l) {
            $id = $l->getId();
            $rut = $l->getRut();
            $paciente = $l->getPaciente();
            $fecha = $l->getFecha();
            $horainicio = $l->getHoraInicio();
            $horatermino = $l->getHoraTermino();
            $intervalo = $l->getIntervalo();
            $observacion = $l->getObservacion();
            $horallegada = $l->getHoraLlegada();
            $horaatencion = $l->getHoraAtencion();
            $estado = $l->getEstado();
            $estadonombre = $c->nombreestadoatencion($estado);
            $registro = $l->getRegistro();
            $contenido .= "<tr class='text-center'>";
            $contenido .= "<td class='bg-transparent'>" . date("d-m-Y", strtotime($fecha)) . "</td>";
            $contenido .= "<td class='bg-transparent'>" . date("H:i", strtotime($horainicio)) . " - " . date("H:i", strtotime($horatermino)) . "</td>";
            $contenido .= "<td class='bg-transparent'>" . $rut . "</td>";
            $contenido .= "<td class='bg-transparent'>" . $paciente . "</td>";
            $contenido .= "<td class='bg-transparent'>" . $intervalo . " minutos</td>";
            if ($estado == 1) {
                //Reservado
                $contenido .= "<td class='bg-transparent'><span class='badge badge-success'>Reservado</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-outline-primary btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-plus'></i></button></td>";
            } else if ($estado == 2) {
                //Confirmado
                $contenido .= "<td class='bg-transparent'><span class='badge badge-primary'>Confirmado</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-outline-primary btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-plus'></i></button></td>";
            } else if ($estado == 3) {
                //En Sala de Espera
                $contenido .= "<td class='bg-transparent'><span class='badge badge-warning'>En Sala de Espera</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-outline-warning btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-check'></i></button></td>";
            } else if ($estado == 4) {
                //En Atención
                $contenido .= "<td class='bg-transparent'><span class='badge badge-info'>En Atención</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-info btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-check'></i></button></td>";
            } else if ($estado == 5) {
                //Atendido(a)
                $contenido .= "<td class='bg-transparent'><span class='badge badge-success'>Atendido(a)</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-success btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-check'></i></button></td>";
            } else if ($estado == 6) {
                //Cancelado
                $contenido .= "<td class='bg-transparent'><span class='badge badge-danger'>Reserva Cancelada</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'>-</td>";
            } else if ($estado == 7) {
                //Paciente No Asiste
                $contenido .= "<td class='bg-transparent'><span class='badge badge-danger'>Paciente No Asiste</span></td>";
                $contenido .= "<td class='bg-transparent'>";
                if(strlen($horallegada) == 8){
                    $contenido .= date("H:i", strtotime($horallegada));
                }

                if(strlen($horaatencion) == 8){
                    $contenido .= "- ".date("H:i", strtotime($horaatencion));
                }

                $contenido .= "</td>";
                $contenido .= "<td class='bg-transparent'><button class='btn btn-danger btn-sm' onclick='atencion(" . $id . ")'><i class='fa fa-user-times'></i></button></td>";
            }

            $contenido .= "</tr>";
        }
        $contenido .= '</tbody>
            </table>
            </div>';
        echo json_encode(array("status" => true, "table" => $contenido));
    } else {
        echo json_encode(array("status" => false, "message" => "No se ha encontrado la empresa"));
    }
} else {
    echo json_encode(array("status" => false, "message" => "Debe ingresar la fecha de inicio y la fecha de término"));
    return;
}
