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
		echo "<label for='diagnostico'>Nombre</label>";
		echo "<input type='text' class='form-control' id='nombreedit' name='nombreedit' value='" . $object->getNombre() . "' required>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Presentacion</label>";
		$presentaciones = $c->listarpresentaciones();
		echo "<select class='form-control' id='presentacionedit' name='presentacionedit'>";
		foreach ($presentaciones as $presentacion) {
			if ($presentacion->getId() == $object->getPresentacion()) {
				echo "<option value='" . $presentacion->getId() . "' selected>" . $presentacion->getNombre() . "</option>";
			} else {
				echo "<option value='" . $presentacion->getId() . "'>" . $presentacion->getNombre() . "</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Cantidad</label>";
		if($object->getCantidad()==0){
			echo "<input type='text' class='form-control' id='cantidadedit' name='cantidadedit' value=''>";
		}else{
		echo "<input type='text' class='form-control' id='cantidadedit' name='cantidadedit' value='" . $object->getCantidad() . "' >";
		}
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Medida</label>";
		
		$presentaciones = $c->listarmedidas();
		echo "<select class='form-control' id='medidasedit' name='medidasedit'>";
		foreach ($presentaciones as $presentacion) {
			if ($presentacion->getId() == $object->getMedida()) {
				echo "<option value='" . $presentacion->getId() . "' selected>" . $presentacion->getNombre() . "</option>";
			} else {
				echo "<option value='" . $presentacion->getId() . "'>" . $presentacion->getNombre() . "</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "<div class='col-md-12'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Vias de Administración</label><br/>";
		$viasob = $object->getViasdeadministracion();
		//Separar las vias por ;
		$viaso = explode(";", $viasob);
		$cantidad = count($viaso);
		$vias = $c->listarviasadministracion();
		foreach ($vias as $via) {
			echo "<input type='checkbox' id='viaedit" . $via->getId() . "' name='viaedit" . $via->getId() . "' value='" . $via->getNombre() . "'";
			if($cantidad> 0){
				foreach ($viaso as $viao) {
					if ($via->getNombre() == $viao) {
						echo " checked";
					} 
				}
			}
			echo "> " . $via->getNombre() . " ";
		}
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
