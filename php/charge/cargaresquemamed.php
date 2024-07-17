<?php
require '../controller.php';
$c = new Controller();
$id = $_POST['id'];
if($id<=0){
    $id = 0;
}
$medidasant = $c->buscarmedicamentoesquema($id);
$carbo = $c->buscarcarboplatino($id);
$contenido = "";
if($carbo == true){
    $contenido .= "<div class='table-responsive'>";
    $contenido .= "<table class='table table-bordered mt-4'>";
    $contenido .= "<tr>";
    $contenido .= "<th></th>";
    $contenido .= "<th>Medicamento</th>";
    $contenido .= "<th class='text-center'>%</th>";
    $contenido .= "<th>DOSIS MG ESQUEMA</th>";
    $contenido .= "<th>DOSIS TOTAL MG</th>";
    $contenido .= "<th>ORAL</th>";
    $contenido .= "<th>EV</th>";
    $contenido .= "<th>SC</th>";
    $contenido .= "<th>IT</th>";
    $contenido .= "<th>BICCAD</th>";
    $contenido .= "<th>OBSERVACION</th>";
    $contenido .= "</tr>";
    $contenido .= "<tbody id='medicamentoscharge'>";
    if(count($medidasant)>0){
        foreach ($medidasant as $medicamento) {
            $contenido .= "<tr class='m-0' >";
            $contenido .= "<td class='m-0'><input onclick='calc(" . $medicamento->getId() . ")' type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "'></td>";
            $contenido .= "<td  class='m-0'> <span name='medicamentoname" . $medicamento->getId() . "' id='medicamentoname" . $medicamento->getId() . "'>" . $medicamento->getMedicamento() . "</span></td>";
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
            $contenido .= "<input type='hidden' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' value='" .$medicamento->getCarboplatino() . "'>";
            $contenido .= "</td>";

            $contenido .= "<td class='m-0'><input type='number' onkeyup='calc(" . $medicamento->getId() . ")'  name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' value='" . $medicamento->getDosis() . "'></td>";
            $contenido .= "<td class='m-0'><input type='number'  name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación'></td>";
            $contenido .= "</tr>";
        }
    }else{
        $contenido .= "<tr>";
        $contenido .= "<td colspan='13'>No hay medicamentos en el esquema</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";
    $contenido .= "</div>";

}else{
    $contenido .= "<div class='table-responsive'>";
    $contenido .= "<table class='table table-bordered'>";
    $contenido .= "<tr>";
    $contenido .= "<th></th>";
    $contenido .= "<th>Medicamento</th>";
    $contenido .= "<th class='text-center'>%</th>";
    $contenido .= "<th>DOSIS MG ESQUEMA</th>";
    $contenido .= "<th>DOSIS TOTAL MG - SC</th>";
    $contenido .= "<th>ORAL</th>";
    $contenido .= "<th>EV</th>";
    $contenido .= "<th>SC</th>";
    $contenido .= "<th>IT</th>";
    $contenido .= "<th>BICCAD</th>";
    $contenido .= "<th>OBSERVACION</th>";
    $contenido .= "</tr>";
    $contenido .= "<tbody id='medicamentoscharge'>";
    if(count($medidasant)>0){
        foreach ($medidasant as $medicamento) {
            $contenido .= "<tr class='m-0' >";
            $contenido .= "<td class='m-0'><input onclick='calc(" . $medicamento->getId() . ")' type='checkbox' name='medicamento" . $medicamento->getId() . "' id='medicamento" . $medicamento->getId() . "' value='" . $medicamento->getId() . "'></td>";
            $contenido .= "<td  class='m-0'> <span name='medicamentoname" . $medicamento->getId() . "' id='medicamentoname" . $medicamento->getId() . "'>" . $medicamento->getMedicamento() . "</span></td>";
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
            $contenido .= "<input type='hidden' name='carboplatino" . $medicamento->getId() . "' id='carboplatino" . $medicamento->getId() . "' value='0'>";
            $contenido .= "</select>";
            $contenido .= "</td>";

            $contenido .= "<td class='m-0'><input type='number' onkeyup='calc(" . $medicamento->getId() . ")'  name='medida" . $medicamento->getId() . "' id='medida" . $medicamento->getId() . "' class='form-control' value='" . $medicamento->getDosis() . "'></td>";
            $contenido .= "<td class='m-0'><input type='number'  name='totalmg" . $medicamento->getId() . "' id='totalmg" . $medicamento->getId() . "' class='form-control' placeholder='Total MG'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='oral" . $medicamento->getId() . "' id='oral" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='ev" . $medicamento->getId() . "' id='ev" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='sc" . $medicamento->getId() . "' id='sc" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='it" . $medicamento->getId() . "' id='it" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='checkbox' name='biccad" . $medicamento->getId() . "' id='biccad" . $medicamento->getId() . "' value='1'></td>";
            $contenido .= "<td class='m-0'><input type='text' name='observacion" . $medicamento->getId() . "' id='observacion" . $medicamento->getId() . "' class='form-control' placeholder='Observación'></td>";
            $contenido .= "</tr>";
        }
    }else{
        $contenido .= "<tr>";
        $contenido .= "<td colspan='12'>No hay medicamentos en el esquema</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";
    $contenido .= "</div>";

}

echo json_encode(array("status" => true, "contenido" => $contenido, "carbo" => $carbo));