<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$object = $c->buscarmedicamento($id);
	if ($object != null) {
		echo "<div class='row'>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Código(SKU)</label>";
		echo "<input type='text' class='form-control' id='codigoedit' name='codigoedit' value='" . $object->getCodigo() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Descripción</label>";
		echo "<input type='text' class='form-control' id='descripcionedit' name='descripcionedit' value='" . $object->getDescripcion() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Laboratorio</label>";
		echo "<input type='text' class='form-control' id='laboratorioedit' name='laboratorioedit' value='" . $object->getLaboratorio() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>División</label>";
		echo "<input type='text' class='form-control' id='division' name='division' value='" . $object->getDescripcion() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Categoría</label>";
		echo "<input type='text' class='form-control' id='categoriaedit' name='categoriaedit' value='" . $object->getDescripcion() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<input type='hidden' class='form-control' id='idmedicamento' name='idmedicamento' value='" . $object->getId() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-12 text-right'>";
		echo "<button type='submit' class='btn btn-primary' ><i class='fas fa-save'></i> Guardar Cambios</button>";
		echo "<button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fas fa-times'></i> Cancelar</button>";
		echo "</div>";
		echo "</div>";
	} else {
		echo "<div class='alert alert-danger' role='alert'>No se encontró el registro</div>";
	}
}
