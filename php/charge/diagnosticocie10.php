<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$object = $c->buscarDiagnosticocie10($id);
	if ($object != null) {
		echo "<div class='row'>";
		//Código
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Código</label>";
		echo "<input type='text' class='form-control' id='codigoedit' name='codigoedit' value='" . $object->getCodigo() . "'>";
		echo "</div>";
		echo "</div>";
		//Descripción
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Descripción</label>";
		echo "<input type='text' class='form-control' id='completaedit' name='completaedit' value='" . $object->getDescripcion() . "'>";
		echo "</div>";
		echo "</div>";
		//Nodo Final
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Nodo Final</label>";
		echo "<input type='number' class='form-control' id='nodoedit' name='nodoedit' value='" . $object->getNodoFinal() . "'>";
		echo "</div>";
		echo "</div>";
		//Manifestación No DP
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Manifestación No DP</label>";
		echo "<input type='number' class='form-control' id='manifestacionedit' name='manifestacionedit' value='" . $object->getManifestacionNoDP() . "'>";
		echo "</div>";
		echo "</div>";
		//Perinatal
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Perinatal</label>";
		echo "<input type='number' class='form-control' id='perinataledit' name='perinataledit' value='" . $object->getPerinatal() . "'>";
		echo "</div>";
		echo "</div>";
		//Pediatrico
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Pediatrico</label>";
		echo "<input type='number' class='form-control' id='pediatricoedit' name='pediatricoedit' value='" . $object->getPediatrico() . "'>";
		echo "</div>";
		echo "</div>";
		//Obstetrico
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Obstetrico</label>";
		echo "<input type='number' class='form-control' id='obstetricoedit' name='obstetricoedit' value='" . $object->getObstetrico() . "'>";
		echo "</div>";
		echo "</div>";
		//Adulto
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Adulto</label>";
		echo "<input type='number' class='form-control' id='adultoedit' name='adultoedit' value='" . $object->getAdulto() . "'>";
		echo "</div>";
		echo "</div>";
		//Mujer
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Mujer</label>";
		echo "<input type='number' class='form-control' id='mujeredit' name='mujeredit' value='" . $object->getMujer() . "'>";
		echo "</div>";
		echo "</div>";
		//Hombre
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Hombre</label>";
		echo "<input type='number' class='form-control' id='hombreedit' name='hombreedit' value='" . $object->getHombre() . "'>";
		echo "</div>";
		echo "</div>";
		//Poa Exempto
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Poa Exempto</label>";
		echo "<input type='number' class='form-control' id='poaexemptoedit' name='poaexemptoedit' value='" . $object->getPoaExempto() . "'>";
		echo "</div>";
		echo "</div>";
		//DP NO principal
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>DP NO principal</label>";
		echo "<input type='number' class='form-control' id='dpnoprincedit' name='dpnoprincedit' value='" . $object->getDPNOPrincipal() . "'>";
		echo "</div>";
		echo "</div>";
		//VCDP
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>VCDP</label>";
		echo "<input type='number' class='form-control' id='vcdpedit' name='vcdpedit' value='" . $object->getVCDP() . "'>";
		echo "</div>";
		echo "</div>";
		//Boton actualizar
		echo "<div class='col-md-12 text-right'>";
		echo "<button type='button' class='btn btn-primary' onclick='actualizarDiagnosticoCie10(" . $object->getId() . ")'><i class='fas fa-save'></i> Guardar Cambios</button>";
		echo "<button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fas fa-times'></i> Cancelar</button>";
		echo "</div>";
		echo "</div>";
	} else {
		echo "<div class='alert alert-danger' role='alert'>No se encontró el diagnóstico</div>";
	}
}
