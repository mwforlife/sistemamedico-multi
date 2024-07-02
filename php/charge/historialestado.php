<?php
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $lista = $c->listarhistorialestado($id);
    $contenido = "";
    foreach ($lista as $l) {
        $estado = $l['estado'];
        $observacion = $l['observacion'];
        $usuario = $l['usuario'];
        $contenido .= '<tr>
                        <td class="text-center">' .estadonombre($estado) . '</td>
                        <td class="text-center">' . $observacion . '</td>
                        <td class="text-center">' . $usuario . '</td>
                        <td class="text-center">' . date("d-m-Y H:i:s", strtotime($l['registro'])) . '</td>
                    </tr>';
    }
    echo json_encode(array("status" => true, "historial" => $contenido));
    return;
} else {
    echo json_encode(array("status" => false, "message" => "No se ha podido cargar el historial de estados"));
    return;
}

function estadonombre($estado)
{
    switch ($estado) {
        case '1':
            return 'Reservado';
            break;
        case '2':
            return 'Confirmado';
            break;
        case '3':
            return 'En Sala de Espera';
            break;
        case '4':
            return 'En Atención';
            break;
        case '5':
            return 'Atendido(a)';
            break;
        case '6':
            return 'Reserva Cancelada';
            break;
        case '7':
            return 'Paciente No Asiste';
            break;
    }
}
