<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$tnm = $c->buscarentnm($id);

	if($tnm != null){
		$contenido = "<div class='row'>";
		$contenido .= "<div class='col-md-12'>";
		$contenido .= "<label for='descripcionedit'>Descripción</label>";
		$contenido .= "<input type='text' class='form-control' id='descripcionedit' value='".$tnm->getNombre()."'>";
		$contenido .= "</div>";
		$contenido .= "<div class='col-md-12'>";
		$contenido .= "<label for='diagnosticoedit'>Diagnóstico</label>";
		$diagnosticos = $c->listarDiagnosticos();
		$contenido .= "<select class='form-control' id='diagnosticoedit'>";
		foreach ($diagnosticos as $diagnostico) {
			if($diagnostico->getId() == $tnm->getDiagnostico()){
				$contenido .= "<option value='".$diagnostico->getId()."' selected>".$diagnostico->getNombre()."</option>";
			}else{
				$contenido .= "<option value='".$diagnostico->getId()."'>".$diagnostico->getNombre()."</option>";
			}
		}
		$contenido .= "</select>";
		$contenido .= "</div>";
		$contenido .= "<div class='col-md-12 text-right mt-2'>";
		$contenido .= "<button type='button' class='btn btn-outline-primary' onclick='actualizarTNM(".$tnm->getId().")'><i class='fa fa-refresh'></i> Actualizar</button>";
		$contenido .= "</div>";
		$contenido .= "</div>";
		echo json_encode(array("status" => true, "content" => $contenido));
	}else{
		echo json_encode(array("status" => false, "message" => "No se encontraron datos"));
	}
}else{
	echo json_encode(array("status" => false, "message" => "No se recibieron los datos correctamente"));
}
