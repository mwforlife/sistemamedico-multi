<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['tipo']) && isset($_POST['diagnostico'])){
    $tipo = $_POST['tipo'];
    $diagnostico = $_POST['diagnostico'];
    $contenido ="";
    $primario = $c->listartnmpordiagnostico($tipo, $diagnostico);
    foreach ($primario as $row) {
        $contenido .= "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
    }
    echo json_encode(array("status"=>true, "contenido"=>$contenido));
}else{
    echo json_encode(array("status"=>false, "message"=>"Error en los parametros"));
}