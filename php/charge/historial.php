<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['observacion'])) {
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];
    $observacion = $_POST['observacion'];
    $object = $c->buscarpaciente($paciente);
    $informes = $c->listainformecomite($paciente, $comite);
    echo '<div class="col-md-12 d-flex" style="gap:30px; font-size:20px;">
    <p>RUT: ' . $object->getRut() . '</p>
    <P>NOMBRE: ' . $object->getNombre() . ' ' . $object->getApellido1() . ' ' . $object->getApellido2() . '</P>
    </div>';
    
    $cantidad = count($informes);
    $i = 1;
    if($cantidad==0){
        echo "<div class='col-md-12 alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> No hay registros para mostrar de este paciente</div>";
    }else{
        echo "<div class='col-md-12 alert alert-success' role='alert'><i class='fas fa-check-circle'></i> Se han encontrado $cantidad registros</div>";
    
    echo '<div class="col-md-12 table-responsive">
    <hr/>
    <table class="table table-bordered w-100" id="">
        <thead>
        <tr>
        <th scope="col">Folio</th>
        <th scope="col">Diagnostico</th>
        <th scope="col">CIEO Morfologicos</th>
        <th scope="col">CIEO Topograficos</th>
        <th scope="col">Diagnostico CIE10</th>
        <th scope="col">Reingreso</th>
            <th>Observacion</th>
            <th>Documento</th>
        </tr>
        </thead>';
    echo '<tbody>';
    foreach ($informes as $informe) {
        $idinforme = $informe->getId();
        $diagnosticosinforme = $c->buscardiagnosticoscomite($informe->getId());
        $diagnostico = $diagnosticosinforme->getDiagnosticos();
        $cieomorfologico = "";
        $cieotopografico = "";
        $cie10 = $diagnosticosinforme->getDiagnosticocie10();
        $reingreso = $diagnosticosinforme->getReingreso();
        if($reingreso==0){
            $reingreso = "No";
        }else{
            $reingreso = "Si";
        }
        if($i > 1){
            echo '<tr class="list-group-item-danger">';
            echo "<td class='list-group-item-danger'>" . $informe->getFolio() . "</td>";
            echo "<td class='list-group-item-danger'>" . $diagnostico . "</td>";
            echo "<td class='list-group-item-danger'>" . $cieomorfologico . "</td>";
            echo "<td class='list-group-item-danger'>" . $cieotopografico . "</td>";
            echo "<td class='list-group-item-danger'>" . $cie10 . "</td>";
            echo "<td class='list-group-item-danger'>" . $reingreso . "</td>";
            echo "<td class='list-group-item-danger'>" . $observacion . "</td>";
            echo "<td class='list-group-item-danger'><a href='javascript:void(0)' class='btn btn-outline-info' title='Ver Informe' data-toggle='modal' data-target='#modalinforme' onclick='verinforme($idinforme)'><i class='fa fa-file-pdf-o'></i></a></td>";
            echo '</tr>';
        }else{
        echo '<tr>';
        echo "<td>" . $informe->getFolio() . "</td>";
        echo "<td>" . $diagnostico . "</td>";
        echo "<td>" . $cieomorfologico . "</td>";
        echo "<td>" . $cieotopografico . "</td>";
        echo "<td>" . $cie10 . "</td>";
        echo "<td>" . $reingreso . "</td>";
        echo "<td>" . $observacion . "</td>";
        echo "<td><a href='javascript:void(0)' class='btn btn-outline-info' title='Ver Informe' data-toggle='modal' data-target='#modalinforme' onclick='verinforme($idinforme)'><i class='fa fa-file-pdf-o'></i></a></td>";
        echo '</tr>';
        }
        $i++;
    }
    echo '</tbody>
    </table>
    </div>';
}
} else {
    echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> No se ha podido cargar el historial</div>";
}
