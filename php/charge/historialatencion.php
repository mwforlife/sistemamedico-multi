<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['folio']) && isset($_POST['atencion'])){
    $folio = $_POST['folio'];
    $atencion = $_POST['atencion'];
    $atencion = $c->escapeString($atencion);
    $folio = $c->escapeString($folio);
    
    $consultas = $c->listarconsultasatencionfolio($atencion,$folio);
    if(count($consultas)>0){
        $content = "";
        $content .= '<div class="table-responsive">';
        $content .= '<table class="table w-100 table-bordered table-striped" id="tablehistorialatencion">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th>Fecha</th>';
        $content .= '<th>Hora</th>';
        $content .= '<th>Folio</th>';
        $content .= '<th>Primer Ingreso</th>';
        $content .= '<th>Reingreso</th>';
        $content .= '<th>Genera Receta</th>';
        $content .= '<th class="text-center">Atención</th>';
        $content .= '</tr>';
        $content .= '</thead>';
        $content .= '<tbody>';
        foreach ($consultas as $consulta) {
            $content .= "<tr>";
            $content .= "<td>" . date("d-m-Y", strtotime($consulta->getRegistro())) . "</td>";
            $content .= "<td>" . date("H:i", strtotime($consulta->getRegistro())) . "</td>";
            $content .= "<td>" . $consulta->getFolio() . "</td>";
            if ($consulta->getIngreso() == 1) {
                $content .= "<td>Si</td>";
            } else {
                $content .= "<td>No</td>";
            }
            if ($consulta->getReingreso() == 1) {
                $content .= "<td>Si</td>";
            } else {
                $content .= "<td>No</td>";
            }
            if ($consulta->getReceta() == 1) {
                $content .= "<td>Si</td>";
            } else {
                $content .= "<td>No</td>";
            }
        $content .= "<td class=' text-center'><a target='_blank' title='Ver Atención' href='php/reporte/consulta.php?c=".$consulta->getId()."' class='btn btn-outline-primary btn-sm'><i class='fe fe-download'></i></a></td>";
																				
            $content .= "</td>";
            
        }
        $content .= "</tbody>";
        $content .= "</table>";
        $content .= "</div>";

        echo json_encode(array("status" => true, "content" => $content));
    }else{
        echo json_encode(array('status' => false, 'message' => 'No se encontraron consultas'));
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'No se encontraron consultas'));
}