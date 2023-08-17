<?php
require '../controller.php';
$c = new Controller();
$Ano = date('Y');
$diasferiados = $c->listardiasferiadosperiodos($Ano);
foreach ($diasferiados as $df) {
    $fecha = $df->getFecha();
    echo "{id:'" . $df->getId() . "',start:'" . $fecha . "T00:00:00',end:'" . $fecha . "T23:59:59',title:'" . $df->getDescripcion() . "'},";
}
?>