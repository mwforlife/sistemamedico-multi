<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$object = $c->buscarenProfesion($id);
	if ($object != null) {
		echo "<div class='row'>";
        //Codigo
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Código</label>";
		echo "<input type='text' class='form-control' id='codigoedit' name='codigoedit' value='" . $object->getCodigo() . "'>";
		echo "</div>";
		echo "</div>";
        //Nombre
		echo "<div class='col-md-6'>";
		echo "<div class='form-group'>";
		echo "<label for='diagnostico'>Descripción Completa</label>";
		echo "<input type='text' class='form-control' id='descripcionedit' name='descripcionedit' value='" . $object->getNombre() . "'>";
		echo "</div>";
		echo "</div>";
        //Provincia
        echo "<div class='col-md-6'>";
        echo "<div class='form-group'>";
        echo "<label for='diagnostico'>Provincia</label>";
        echo "<select class='form-control select2' id='especialidad' name='especialidad'>";
        $provincias = $c->listarespecialidad();
        if(count($provincias)>0){
            foreach ($provincias as $p) {
                if ($p->getId() == $object->getEspecialidad()) {
                    echo "<option value='" . $p->getId() . "' selected>" . $p->getNombre() . "</option>";
                } else {
                    echo "<option value='" . $p->getId() . "'>" . $p->getNombre() . "</option>";
                }
            }
        }else{
            echo "<option value='0'>No hay Registros de especialidades</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "</div>";
        //Botones
		echo "<div class='col-md-12 text-right'>";
		echo "<button type='button' class='btn btn-primary' onclick='actualizarProfesion(" . $object->getId() . ")'><i class='fas fa-save'></i> Guardar Cambios</button>";
		echo "<button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fas fa-times'></i> Cancelar</button>";
		echo "</div>";
		echo "</div>";
	} else {
		echo "<div class='alert alert-danger' role='alert'>No se encontró el registro</div>";
	}
}
