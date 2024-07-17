<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id']) && isset($_POST['receta'])) {
    $id = $_POST['id'];
    $receta = $_POST['receta'];
    $medidasant = $c->buscarmedicamentoesquema($id);
    $carbo = $c->buscarcarboplatino($id);
    $contenido = "<div class='table-responsive'>";
    $contenido = "<table class='table table-bordered mt-4 w-100'>";
    $contenido .= "<tr>";
    $contenido .= "<th></th>";
    $contenido .= "<th>Medicamento</th>";
    $contenido .= "<th class='text-center'>%</th>";
    $contenido .= "<th>DOSIS MG ESQUEMA</th>";
    if ($carbo == true) {
        $contenido .= "<th>DOSIS TOTAL MG</th>";
    } else {
        $contenido .= "<th>DOSIS TOTAL MG - SC</th>";
    }
    $contenido .= "<th>ORAL</th>";
    $contenido .= "<th>EV</th>";
    $contenido .= "<th>SC</th>";
    $contenido .= "<th>IT</th>";
    $contenido .= "<th>BICCAD</th>";
    $contenido .= "<th>OBSERVACION</th>";
    $contenido .= "</tr>";
    $contenido .= "<tbody id='medicamentoscharge'>";
    $medicacion = $c->listarMedicamentosrecetavalue($receta);
    if (count($medidasant) > 0) {
        foreach ($medidasant as $medicamento) {
            $check = false;
            $med = null;
            foreach ($medicacion as $med) {
                if ($med->getMedicamento() == $medicamento->getId()) {
                    $contenido .= "<tr class='m-0' >";
                    $contenido .= "<td class='m-0'><input type='checkbox' onclick='calc(" . $medicamento->getId() . ")' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "' checked></td>";
                    $contenido .= "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                    $contenido .= "<td class='m-0'>";
                    $contenido .= "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 100) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='100'>100%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 90) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='90'>90%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 80) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='80'>80%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 70) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='70'>70%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 60) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='60'>60%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 50) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='50'>50%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 40) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='40'>40%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 30) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='30'>30%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 20) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='20'>20%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 10) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='10'>10%</option>";
                    $contenido .= "<option ";
                    if ($med->getPorcentaje() == 0) {
                        $contenido .= "selected";
                    }
                    $contenido .= " value='0'>0%</option>";
                    $contenido .= "</select>";
                    $contenido .= "<input type='hidden' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' value='" . $med->getCarboplatino() . "'>";

                    $contenido .= "</td>";

                    $contenido .= "<td class='m-0'><input type='number' onkeyup='calc(" . $medicamento->getId() . ")'  name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "' value='" . $med->getDosis() . "'></td>";
                    $contenido .= "<td class='m-0'><input type='number'  name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG' value='" . $med->getDosistotal() . "'></td>";
                    $contenido .= "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'";
                    if ($med->getOral() == 1) {
                        $contenido .= "checked";
                    }
                    $contenido .= "></td>";
                    $contenido .= "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1' ";
                    if ($med->getEv() == 1) {
                        $contenido .= "checked";
                    }
                    $contenido .= "></td>";
                    $contenido .= "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1' ";
                    if ($med->getSc() == 1) {
                        $contenido .= "checked";
                    }
                    $contenido .= "></td>";
                    $contenido .= "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1' ";
                    if ($med->getIt() == 1) {
                        $contenido .= "checked";
                    }
                    $contenido .= "></td>";
                    $contenido .= "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1' ";
                    if ($med->getBiccad() == 1) {
                        $contenido .= "checked";
                    }
                    $contenido .= "></td>";
                    $contenido .= "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación' value='" . $med->getObservacion() . "'></td>";
                    $contenido .= "</tr>";
                    $check = true;
                    break;
                }
            }

            if ($check == false) {
                $contenido .= "<tr class='m-0' >";
                $contenido .= "<td class='m-0'><input type='checkbox' onclick='calc(" . $medicamento->getId() . ")' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "'></td>";
                $contenido .= "<td  class='m-0'> <span>" . $medicamento->getMedicamento() . "</span></td>";
                $contenido .= "<td class='m-0'>";
                $contenido .= "<select name='porcentaje" . $medicamento->getId() . "' id='porcentaje" . $medicamento->getId() . "' class='form-control' onchange='calc(" . $medicamento->getId() . ")'>";
                $contenido .= "<option value='100'>100%</option>";
                $contenido .= "<option value='90'>90%</option>";
                $contenido .= "<option value='80'>80%</option>";
                $contenido .= "<option value='70'>70%</option>";
                $contenido .= "<option value='60'>60%</option>";
                $contenido .= "<option value='50'>50%</option>";
                $contenido .= "<option value='40'>40%</option>";
                $contenido .= "<option value='30'>30%</option>";
                $contenido .= "<option value='20'>20%</option>";
                $contenido .= "<option value='10'>10%</option>";
                $contenido .= "<option value='0'>0%</option>";
                $contenido .= "</select>";
                $contenido .= "<input type='hidden' name='carboplatino" . $med->getId() . "' id='carboplatino" . $med->getId() . "' value='" . $med->getCarboplatino() . "'>";

                $contenido .= "</td>";

                $contenido .= "<td class='m-0'><input type='number' onkeyup='calc(" . $medicamento->getId() . ")' name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' placeholder='" . $medicamento->getMedicion() . "'></td>";
                $contenido .= "<td class='m-0'><input type='number' class='form-control' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' ></td>";
                $contenido .= "<td class='m-0'><input type='number'  name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG' value='" . $med->getDosistotal() . "'></td>";
                $contenido .= "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'></td>";
                $contenido .= "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1'></td>";
                $contenido .= "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1'></td>";
                $contenido .= "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1'></td>";
                $contenido .= "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1'></td>";
                $contenido .= "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación'></td>";
                $contenido .= "</tr>";
            }
        }
    } else {
        $contenido .= "<tr>";
        $contenido .= "<td colspan='13'>No hay medicamentos en el esquema</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";
    $contenido .= "</div>";

    echo json_encode(array("status" => true, "contenido" => $contenido, "carbo" => $carbo));
} else {
    $contenido .= json_encode(array('error' => true, 'message' => 'No se enviaron los datos correctamente'));
}
