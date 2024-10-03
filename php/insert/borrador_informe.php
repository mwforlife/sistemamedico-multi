<?php
require '../controller.php';
$c = new Controller();

session_start();

/*paciente: 1
comite: 1
peso: 
talla: 
sup: 0
diagnostico: 
diagnosticotext: 
diagnosticocie10: 
diagnosticocie10text: 
fechabiopsia: 
reingreso: 0
ecog: 1
ecogtext: 1 - PRUEBA
histologico: 1
histologicotext: 1 - PRUEBA
invasiontumoral: 1
invasiontumoraltext: PRUEBA
mitotico: 0
observaciontnm: 
anamnesis: 
cirugia: 0
quimioterapia: 0
radioterapia: 0
otros: 0
seguimiento: 0
completar: 0
revaluacion: 0
estudioclinicno: 0
observacionesdecision: 
consultade: 1
consultadetext: Cirugía
programacion: 0
traslado: 0
paliativos: 0
ingreso: 0
observacionplan: 
resolucion: 
rama1: 0
rama2: 0
rama3: 0
rama4: 0
rama5: 0
rama6: 0
rama7: 0
rama8: 0
rama9: 0
rama10: 0
ocupacion1: 0
ocupacion2: 0
ocupacion3: 0
ocupacion4: 0
ocupacion5: 0
ocupacion6: 0
ocupacion7: 0
ocupacion8: 0
ocupacion9: 0
ocupacion10: 0
ocupacion11: 0
sp1: 
sp2: 
sp3: 
th1: 
th2: 
th3: 
th4: 
th5: 
comportamiento: 
comportamientoobservacion: 
grado1: 0
grado2: 0
grado3: 0
grado4: 0
grado5: 0
extension1: 0
extension2: 0
extension3: 0
extension4: 0
extension5: 0
lateralidad1: 0
lateralidad2: 0
lateralidad3: 0
lateralidad4: 0
lateralidad5: 0
fechaincidencia: 
horaincidencia: 
basediagnostico1: 0
basediagnostico2: 0
basediagnostico3: 0
basediagnostico4: 0
basediagnostico5: 0
basediagnostico6: 0
basediagnostico7: 0
basediagnostico8: 0
basediagnostico9: 0
fuente1: 
fichapacex1: 
fechahospex1: 
horahospex1: 
fuente2: 
fichapacex2: 
fechahospex2: 
horahospex2: 
fuente3: 
fichapacex3: 
fechahospex3: 
horahospex3: 
fechaultimocontacto: 
estadio: 1
defuncion: 
causa: 0
observacionfinal: */

if(isset($_POST['paciente']) && isset($_POST['comite']) && isset($_POST['peso']) && isset($_POST['talla']) && isset($_POST['sup']) && isset($_POST['diagnostico']) && isset($_POST['diagnosticotext']) && isset($_POST['diagnosticocie10']) && isset($_POST['diagnosticocie10text']) && isset($_POST['fechabiopsia']) && isset($_POST['reingreso']) && isset($_POST['ecog']) && isset($_POST['ecogtext']) && isset($_POST['histologico']) && isset($_POST['histologicotext']) && isset($_POST['invasiontumoral']) && isset($_POST['invasiontumoraltext']) && isset($_POST['mitotico']) && isset($_POST['observaciontnm']) && isset($_POST['anamnesis']) && isset($_POST['cirugia']) && isset($_POST['quimioterapia']) && isset($_POST['radioterapia']) && isset($_POST['otros']) && isset($_POST['seguimiento']) && isset($_POST['completar']) && isset($_POST['revaluacion']) && isset($_POST['estudioclinicno']) && isset($_POST['observacionesdecision']) && isset($_POST['consultade']) && isset($_POST['consultadetext']) && isset($_POST['programacion']) && isset($_POST['traslado']) && isset($_POST['paliativos']) && isset($_POST['ingreso']) && isset($_POST['observacionplan']) && isset($_POST['resolucion']) && isset($_POST['rama1']) && isset($_POST['rama2']) && isset($_POST['rama3']) && isset($_POST['rama4']) && isset($_POST['rama5']) && isset($_POST['rama6']) && isset($_POST['rama7']) && isset($_POST['rama8']) && isset($_POST['rama9']) && isset($_POST['rama10']) && isset($_POST['ocupacion1']) && isset($_POST['ocupacion2']) && isset($_POST['ocupacion3']) && isset($_POST['ocupacion4']) && isset($_POST['ocupacion5']) && isset($_POST['ocupacion6']) && isset($_POST['ocupacion7']) && isset($_POST['ocupacion8']) && isset($_POST['ocupacion9']) && isset($_POST['ocupacion10']) && isset($_POST['ocupacion11']) && isset($_POST['sp1']) && isset($_POST['sp2']) && isset($_POST['sp3']) && isset($_POST['th1']) && isset($_POST['th2']) && isset($_POST['th3']) && isset($_POST['th4']) && isset($_POST['th5']) && isset($_POST['comportamiento']) && isset($_POST['comportamientoobservacion']) && isset($_POST['grado1']) && isset($_POST['grado2']) && isset($_POST['grado3']) && isset($_POST['grado4']) && isset($_POST['grado5']) && isset($_POST['extension1']) && isset($_POST['extension2']) && isset($_POST['extension3']) && isset($_POST['extension4']) && isset($_POST['extension5']) && isset($_POST['lateralidad1']) && isset($_POST['lateralidad2']) && isset($_POST['lateralidad3']) && isset($_POST['lateralidad4']) && isset($_POST['lateralidad5']) && isset($_POST['fechaincidencia']) && isset($_POST['horaincidencia']) && isset($_POST['basediagnostico1']) && isset($_POST['basediagnostico2']) && isset($_POST['basediagnostico3']) && isset($_POST['basediagnostico4']) && isset($_POST['basediagnostico5']) && isset($_POST['basediagnostico6']) && isset($_POST['basediagnostico7']) && isset($_POST['basediagnostico8']) && isset($_POST['basediagnostico9']) && isset($_POST['fuente1']) && isset($_POST['fichapacex1']) && isset($_POST['fechahospex1']) && isset($_POST['horahospex1']) && isset($_POST['fuente2']) && isset($_POST['fichapacex2']) && isset($_POST['fechahospex2']) && isset($_POST['horahospex2']) && isset($_POST['fuente3']) && isset($_POST['fichapacex3']) && isset($_POST['fechahospex3']) && isset($_POST['horahospex3']) && isset($_POST['fechaultimocontacto']) && isset($_POST['estadio']) && isset($_POST['defuncion']) && isset($_POST['causa']) && isset($_POST['observacionfinal'])) {
    $paciente = $_POST['paciente'];
    $comite = $_POST['comite'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];
    $sup = $_POST['sup'];
    $diagnostico = $_POST['diagnostico'];
    $diagnosticotext = $_POST['diagnosticotext'];
    $diagnosticocie10 = $_POST['diagnosticocie10'];
    $diagnosticocie10text = $_POST['diagnosticocie10text'];
    $fechabiopsia = $_POST['fechabiopsia'];
    $reingreso = $_POST['reingreso'];
    $ecog = $_POST['ecog'];
    $ecogtext = $_POST['ecogtext'];
    $histologico = $_POST['histologico'];
    $histologicotext = $_POST['histologicotext'];
    $invasiontumoral = $_POST['invasiontumoral'];
    $invasiontumoraltext = $_POST['invasiontumoraltext'];
    $mitotico = $_POST['mitotico'];
    $observaciontnm = $_POST['observaciontnm'];
    $anamnesis = $_POST['anamnesis'];
    $cirugia = $_POST['cirugia'];
    $quimioterapia = $_POST['quimioterapia'];
    $radioterapia = $_POST['radioterapia'];
    $otros = $_POST['otros'];
    $seguimiento = $_POST['seguimiento'];
    $completar = $_POST['completar'];
    $revaluacion = $_POST['revaluacion'];
    $estudioclinicno = $_POST['estudioclinicno'];
    $observacionesdecision = $_POST['observacionesdecision'];
    $consultade = $_POST['consultade'];
    $consultadetext = $_POST['consultadetext'];
    $programacion = $_POST['programacion'];
    $traslado = $_POST['traslado'];
    $paliativos = $_POST['paliativos'];
    $ingreso = $_POST['ingreso'];
    $observacionplan = $_POST['observacionplan'];
    $resolucion = $_POST['resolucion'];
    $rama1 = $_POST['rama1'];
    $rama2 = $_POST['rama2'];
    $rama3 = $_POST['rama3'];
    $rama4 = $_POST['rama4'];
    $rama5 = $_POST['rama5'];
    $rama6 = $_POST['rama6'];
    $rama7 = $_POST['rama7'];
    $rama8 = $_POST['rama8'];
    $rama9 = $_POST['rama9'];
    $rama10 = $_POST['rama10'];
    $ocupacion1 = $_POST['ocupacion1'];
    $ocupacion2 = $_POST['ocupacion2'];
    $ocupacion3 = $_POST['ocupacion3'];
    $ocupacion4 = $_POST['ocupacion4'];
    $ocupacion5 = $_POST['ocupacion5'];
    $ocupacion6 = $_POST['ocupacion6'];
    $ocupacion7 = $_POST['ocupacion7'];
    $ocupacion8 = $_POST['ocupacion8'];
    $ocupacion9 = $_POST['ocupacion9'];
    $ocupacion10 = $_POST['ocupacion10'];
    $ocupacion11 = $_POST['ocupacion11'];
    $sp1 = $_POST['sp1'];
    $sp2 = $_POST['sp2'];
    $sp3 = $_POST['sp3'];
    $th1 = $_POST['th1'];
    $th2 = $_POST['th2'];
    $th3 = $_POST['th3'];
    $th4 = $_POST['th4'];
    $th5 = $_POST['th5'];
    $comportamiento = $_POST['comportamiento'];
    $comportamientoobservacion = $_POST['comportamientoobservacion'];
    $grado1 = $_POST['grado1'];
    $grado2 = $_POST['grado2'];
    $grado3 = $_POST['grado3'];
    $grado4 = $_POST['grado4'];
    $grado5 = $_POST['grado5'];
    $extension1 = $_POST['extension1'];
}else{
    echo json_encode(array("status"=>false, "message"=>"Faltan datos"));
}