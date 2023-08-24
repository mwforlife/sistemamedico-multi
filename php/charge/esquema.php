<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$object = $c->buscarenesquema($id);
	if ($object != null) {
		echo "<div class='row'>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Código</label>";
		echo "<input type='text' class='form-control' id='codigoedit' name='codigo' value='" . $object->getCodigo() . "'>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Descripción Completa</label>";
		echo "<input type='text' class='form-control' id='descripcionedit' name='descripcion' value='" . $object->getNombre() . "'>";
		echo "</div>";
		echo "</div>";
		echo "<input type='hidden' id='id' name='id' value='" . $object->getId() . "'>";
		echo "<div class='col-md-12 text-right'>";
		echo "<button type='submit' class='btn btn-primary'><i class='fas fa-save'></i> Guardar Cambios</button>";
		echo "<button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fas fa-times'></i> Cancelar</button>";
		echo "</div>";
		echo "</div>";
	} else {
		echo "<div class='alert alert-danger' role='alert'>No se encontró el registro</div>";
	}
}
