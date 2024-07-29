<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['paciente'])){
    $paciente = $_POST['paciente'];
    if(strlen($paciente)==0 || !is_numeric($paciente) || $paciente<0){
        echo json_encode(array("status"=>false, "message"=>"El Identificador del paciente no es válido"));
        return;
    }
    $pacienteObject = $c->buscarpaciente($paciente);
    if($pacienteObject==null){
        echo json_encode(array("status"=>false, "message"=>"No se encontró el paciente"));
        return;
    }
    $registros = $c->listarregistropoblacional($paciente);
    $content = "";

    $content .= "<div class='table-responsive'>";
    $content .= "<table class='table table-striped table-bordered text-center'>";
    $content .= "<thead>";
    $content .= "<tr>";
    $content .= "<th>ID</th>";
    $content .= "<th>Fecha de Registro</th>";
    $content .= "<th>Provenecia</th>";
    $content .= "<th>PDF</th>";
    $content .= "<th>Usuario</th>";
    $content .= "</tr>";
    $content .= "</thead>";
    $content .= "<tbody>";
    foreach($registros as $registro){
        $content .= "<tr>";
        $content .= "<td>".$registro['id']."</td>";
        $content .= "<td>".$registro['registro']."</td>";
        $provenencia = $registro['proveniencia'];
        if($provenencia==1){
            $provenencia = "Modulo Registro Poblacional";
        }else if($provenencia==2){
            $provenencia = "Modulo Evaluación Paciente Comité";
        }
        $content .= "<td>".$provenencia."</td>"; 
        $content .= "<td><a href='php/reporte/registropoblacional.php?id=".$registro['id']."' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
        $content .= "<td>".$registro['usuario']."</td>";
        $content .= "</tr>";
    }
    $content .= "</tbody>";
    $content .= "</table>";
    $content .= "</div>";

    echo json_encode(array("status"=>true, "message"=>"Registros encontrados", "content"=>$content));
}else{
    echo json_encode(array("status"=>false, "message"=>"No se ha enviado el Identificador del paciente"));
}