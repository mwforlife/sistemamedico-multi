<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id']) && isset($_POST['receta'])) {

    $id = $_POST['id'];
    $receta = $_POST['receta'];
    $medidasant = $c->listarmedicamentosesquemas($id);
    $carbo = $c->buscarcarboplatino($id);
    if ($carbo == true) {
        echo "<table class='table table-bordered mt-4'>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th>Medicamento</th>";
        echo "<th class='text-center'>%</th>";
        echo "<th>DOSIS MG ESQUEMA</th>";
        echo "<th>CARBOPLATINO</th>";
        echo "<th>DOSIS TOTAL MG</th>";
        echo "<th>ORAL</th>";
        echo "<th>EV</th>";
        echo "<th>SC</th>";
        echo "<th>IT</th>";
        echo "<th>BICCAD</th>";
        echo "<th>OBSERVACION</th>";
        echo "</tr>";
        echo "<tbody id='medicamentoscharge'>";
        $medicacion = $c->listarMedicamentosrecetavalue($receta);
        if (count($medidasant) > 0) {
            foreach ($medidasant as $medicamento) {
                $check = false;
                $med = null;
                foreach ($medicacion as $med) {
                    if ($med->getMedicamento() == $medicamento->getId()) {
                        echo "<tr class='m-0' >";
                        echo "<td class='m-0'><input type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "' checked></td>";
                        echo "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                        echo "<td class='m-0'>";
                        echo "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                        echo "<option"; if ($med->getPorcentaje() == 100) {echo "selected";} echo " value='100'>100%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 90) {echo "selected";} echo " value='90'>90%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 80) {echo "selected";} echo " value='80'>80%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 70) {echo "selected";} echo " value='70'>70%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 60) {echo "selected";} echo " value='60'>60%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 50) {echo "selected";} echo " value='50'>50%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 40) {echo "selected";} echo " value='40'>40%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 30) {echo "selected";} echo " value='30'>30%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 20) {echo "selected";} echo " value='20'>20%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 10) {echo "selected";} echo " value='10'>10%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 0) {echo "selected";} echo " value='0'>0%</option>";
                        echo "</select>";
                        echo "</td>";

                        echo "<td class='m-0'><input type='number' name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "' value='" . $med->getDosis() . "'></td>";
                        echo "<td class='m-0'><input type='number' class='form-control' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' value='" . $med->getCarboplatino() . "'></td>";
                        echo "<td class='m-0'><input type='number' name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
                        echo "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'"; if ($med->getOral() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1' "; if ($med->getEv() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1' "; if ($med->getSc() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1' "; if ($med->getIt() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1' "; if ($med->getBiccad() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación' value='" . $med->getObservacion() . "'></td>";
                        echo "</tr>";
                        $check = true;
                        break;
                    }
                }

                if ($check == false) {
                    echo "<tr class='m-0' >";
                    echo "<td class='m-0'><input type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "'></td>";
                    echo "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                    echo "<td class='m-0'>";
                    echo "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                    echo "<option value='100'>100%</option>";
                    echo "<option value='90'>90%</option>";
                    echo "<option value='80'>80%</option>";
                    echo "<option value='70'>70%</option>";
                    echo "<option value='60'>60%</option>";
                    echo "<option value='50'>50%</option>";
                    echo "<option value='40'>40%</option>";
                    echo "<option value='30'>30%</option>";
                    echo "<option value='20'>20%</option>";
                    echo "<option value='10'>10%</option>";
                    echo "<option value='0'>0%</option>";
                    echo "</select>";
                    echo "</td>";

                    echo "<td class='m-0'><input type='number' name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "'></td>";
                    echo "<td class='m-0'><input type='number' class='form-control' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' ></td>";
                    echo "<td class='m-0'><input type='number' name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación'></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr>";
            echo "<td colspan='13'>No hay medicamentos en el esquema</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<table class='table table-bordered'>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th>Medicamento</th>";
        echo "<th class='text-center'>%</th>";
        echo "<th>DOSIS MG ESQUEMA</th>";
        echo "<th>DOSIS TOTAL MG</th>";
        echo "<th>ORAL</th>";
        echo "<th>EV</th>";
        echo "<th>SC</th>";
        echo "<th>IT</th>";
        echo "<th>BICCAD</th>";
        echo "<th>OBSERVACION</th>";
        echo "</tr>";
        echo "<tbody id='medicamentoscharge'>";
        $medicacion = $c->listarMedicamentosrecetavalue($receta);
        if (count($medidasant) > 0) {
            foreach ($medidasant as $medicamento) {
                $check = false;
                $med = null;
                foreach ($medicacion as $med) {
                    if ($med->getMedicamento() == $medicamento->getId()) {
                        echo "<tr class='m-0' >";
                        echo "<td class='m-0'><input type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "' checked></td>";
                        echo "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                        echo "<td class='m-0'>";
                        echo "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                        echo "<option"; if ($med->getPorcentaje() == 100) {echo "selected";} echo " value='100'>100%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 90) {echo "selected";} echo " value='90'>90%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 80) {echo "selected";} echo " value='80'>80%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 70) {echo "selected";} echo " value='70'>70%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 60) {echo "selected";} echo " value='60'>60%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 50) {echo "selected";} echo " value='50'>50%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 40) {echo "selected";} echo " value='40'>40%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 30) {echo "selected";} echo " value='30'>30%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 20) {echo "selected";} echo " value='20'>20%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 10) {echo "selected";} echo " value='10'>10%</option>";
                        echo "<option"; if ($med->getPorcentaje() == 0) {echo "selected";} echo " value='0'>0%</option>";
                        echo "</select>";
                        echo "</td>";

                        echo "<td class='m-0'><input type='number' name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "' value='" . $med->getDosis() . "'></td>";
                        echo "<td class='m-0'><input type='number' name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
                        echo "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'"; if ($med->getOral() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1' "; if ($med->getEv() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1' "; if ($med->getSc() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1' "; if ($med->getIt() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1' "; if ($med->getBiccad() == 1) {echo "checked";} echo "></td>";
                        echo "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación' value='" . $med->getObservacion() . "'></td>";
                        echo "</tr>";
                        $check = true;
                        break;
                    }
                }

                if ($check == false) {
                    echo "<tr class='m-0' >";
                    echo "<td class='m-0'><input type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "'></td>";
                    echo "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                    echo "<td class='m-0'>";
                    echo "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                    echo "<option value='100'>100%</option>";
                    echo "<option value='90'>90%</option>";
                    echo "<option value='80'>80%</option>";
                    echo "<option value='70'>70%</option>";
                    echo "<option value='60'>60%</option>";
                    echo "<option value='50'>50%</option>";
                    echo "<option value='40'>40%</option>";
                    echo "<option value='30'>30%</option>";
                    echo "<option value='20'>20%</option>";
                    echo "<option value='10'>10%</option>";
                    echo "<option value='0'>0%</option>";
                    echo "</select>";
                    echo "</td>";

                    echo "<td class='m-0'><input type='number' name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "'></td>";
                    echo "<td class='m-0'><input type='number' class='form-control' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' ></td>";
                    echo "<td class='m-0'><input type='number' name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1'></td>";
                    echo "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación'></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr>";
            echo "<td colspan='12'>No hay medicamentos en el esquema</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
} else {
    echo json_encode(array('error' => true, 'message' => 'No se enviaron los datos correctamente'));
}
