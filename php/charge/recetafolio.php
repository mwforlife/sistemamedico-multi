<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['folio']) && isset($_POST['consulta'])) {
    $folio = $_POST['folio'];
    $consulta = $_POST['consulta'];

    if ($folio <= 0 || $consulta <= 0) {
        echo json_encode(array("status" => false, "message" => "Folio o Identificador de consulta no valido"));
        return;
    }

    $recetas = $c->recetalistfolioconsulta($folio, $consulta);
    if (count($recetas) > 0) {
        $content = "";
        $content .= '<div class="table-responsive">';
        $content .= '<table class="table w-100 table-bordered table-striped" id="tablehistorialreceta">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th>Fecha</th>';
        $content .= '<th>Estado</th>';
        $content .= '<th>Folio</th>';
        $content .= '<th>Atención</th>';
        $content .= '<th class="text-center">Receta</th>';
        $content .= '</tr>';
        $content .= '</thead>';
        $content .= '<tbody>';
        foreach ($recetas as $r) {
            $content .= "<tr>";
            $content .= "<td>" . date("d-m-Y", strtotime($r->getFecha())) . "</td>";
            
            if ($r->getEstado() == 1) {
                $content .= "<td><span class='badge bg-primary text-white'>Emitida</span></td>";
            } else if ($r->getEstado() == 2){
                $content .= "<td><span class='badge bg-warning'>Editado</span></td>";
            } else if ($r->getEstado() == 3){
                $content .= "<td><span class='badge bg-success text-white'>Aprobada</span></td>";
            }else if ($r->getEstado() == 4){
                $content .= "<td><span class='badge bg-danger text-white'>Rechazada</span></td>";
            }
            $idreceta = $r->getId();
            $content .= "<td>" . $r->getFolio() . "</td>";
            $content .= "<td>" . $r->getConsulta() . "</td>";
            $content .= "<td class='text-center'><a target='_blank' href='php/reporte/receta.php?r=$idreceta' class='btn-sm btn btn-outline-success'><i class='fe fe-file'></i></a></td>";
            $content .= "</td>";
            $content .= "</tr>";
        }
        $content .= "</tbody>";
        $content .= "</table>";
        $content .= "</div>";

        echo json_encode(array("status" => true, "content" => $content));

    } else {
        echo json_encode(array("status" => false, "message" => "No se encontraron recetas"));
    }
} else {
    echo json_encode(array("status" => false, "message" => "Faltan parametros"));
}
