<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['idpaciente']) && isset($_POST['provenencia']) && isset($_POST['rama1']) && isset($_POST['rama2']) && isset($_POST['rama3']) && isset($_POST['rama4']) && isset($_POST['rama5']) && isset($_POST['rama6']) && isset($_POST['rama7']) && isset($_POST['rama8']) && isset($_POST['rama9']) && isset($_POST['rama10']) && isset($_POST['ocupacion1']) && isset($_POST['ocupacion2']) && isset($_POST['ocupacion3']) && isset($_POST['ocupacion4']) && isset($_POST['ocupacion5']) && isset($_POST['ocupacion6']) && isset($_POST['ocupacion7']) && isset($_POST['ocupacion8']) && isset($_POST['ocupacion9']) && isset($_POST['ocupacion10']) && isset($_POST['ocupacion11']) && isset($_POST['sp1']) && isset($_POST['sp2']) && isset($_POST['sp3']) && isset($_POST['th1']) && isset($_POST['th2']) && isset($_POST['th3']) && isset($_POST['th4']) && isset($_POST['th5']) && isset($_POST['comportamiento']) && isset($_POST['comportamientoobservacion']) && isset($_POST['grado1']) && isset($_POST['grado2']) && isset($_POST['grado3']) && isset($_POST['grado4']) && isset($_POST['grado5']) && isset($_POST['extension1']) && isset($_POST['extension2']) && isset($_POST['extension3']) && isset($_POST['extension4']) && isset($_POST['extension5']) && isset($_POST['lateralidad1']) && isset($_POST['lateralidad2']) && isset($_POST['lateralidad3']) && isset($_POST['lateralidad4']) && isset($_POST['lateralidad5']) && isset($_POST['fechaincidencia']) && isset($_POST['horaincidencia']) && isset($_POST['basediagnostico1']) && isset($_POST['basediagnostico2']) && isset($_POST['basediagnostico3']) && isset($_POST['basediagnostico4']) && isset($_POST['basediagnostico5']) && isset($_POST['basediagnostico6']) && isset($_POST['basediagnostico7']) && isset($_POST['basediagnostico8']) && isset($_POST['basediagnostico9']) && isset($_POST['fuente1']) && isset($_POST['fechapacex1']) && isset($_POST['fechahospex1']) && isset($_POST['horahospex1']) && isset($_POST['fuente2']) && isset($_POST['fechapacex2']) && isset($_POST['fechahospex2']) && isset($_POST['horahospex2']) && isset($_POST['fuente3']) && isset($_POST['fechapacex3']) && isset($_POST['fechahospex3']) && isset($_POST['horahospex3']) && isset($_POST['fechaultimocontacto']) && isset($_POST['estadio']) && isset($_POST['defuncion']) && isset($_POST['causa']) && isset($_POST['observacionfinal'])){
    $idpaciente = $_POST['idpaciente'];
    $provenencia = $_POST['provenencia'];
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
    $extension2 = $_POST['extension2'];
    $extension3 = $_POST['extension3'];
    $extension4 = $_POST['extension4'];
    $extension5 = $_POST['extension5'];
    $lateralidad1 = $_POST['lateralidad1'];
    $lateralidad2 = $_POST['lateralidad2'];
    $lateralidad3 = $_POST['lateralidad3'];
    $lateralidad4 = $_POST['lateralidad4'];
    $lateralidad5 = $_POST['lateralidad5'];
    $fechaincidencia = $_POST['fechaincidencia'];
    $horaincidencia = $_POST['horaincidencia'];
    $basediagnostico1 = $_POST['basediagnostico1'];
    $basediagnostico2 = $_POST['basediagnostico2'];
    $basediagnostico3 = $_POST['basediagnostico3'];
    $basediagnostico4 = $_POST['basediagnostico4'];
    $basediagnostico5 = $_POST['basediagnostico5'];
    $basediagnostico6 = $_POST['basediagnostico6'];
    $basediagnostico7 = $_POST['basediagnostico7'];
    $basediagnostico8 = $_POST['basediagnostico8'];
    $basediagnostico9 = $_POST['basediagnostico9'];
    $fuente1 = $_POST['fuente1'];
    $fechapacex1 = $_POST['fechapacex1'];
    $fechahospex1 = $_POST['fechahospex1'];
    $horahospex1 = $_POST['horahospex1'];
    $fuente2 = $_POST['fuente2'];
    $fechapacex2 = $_POST['fechapacex2'];
    $fechahospex2 = $_POST['fechahospex2'];
    $horahospex2 = $_POST['horahospex2'];
    $fuente3 = $_POST['fuente3'];
    $fechapacex3 = $_POST['fechapacex3'];
    $fechahospex3 = $_POST['fechahospex3'];
    $horahospex3 = $_POST['horahospex3'];
    $fechaultimocontacto = $_POST['fechaultimocontacto'];
    $estadio = $_POST['estadio'];
    $defuncion = $_POST['defuncion'];
    $causa = $_POST['causa'];
    $observacionfinal = $_POST['observacionfinal'];

    $result = $c->registrarregistropoblacional($idpaciente,$rama1,$rama2,$rama3,$rama4,$rama5,$rama6,$rama7,$rama8,$rama9,$rama10,$ocupacion1,$ocupacion2,$ocupacion3,$ocupacion4,$ocupacion5,$ocupacion6,$ocupacion7,$ocupacion8,$ocupacion9,$ocupacion10,$ocupacion11,$sp1,$sp2,$sp3,$th1,$th2,$th3,$th4,$th5,$comportamiento,$comportamientoobservacion,$grado1,$grado2,$grado3,$grado4,$grado5,$extension1,$extension2,$extension3,$extension4,$extension5,$lateralidad1,$lateralidad2,$lateralidad3,$lateralidad4,$lateralidad5,$fechaincidencia,$horaincidencia,$basediagnostico1,$basediagnostico2,$basediagnostico3,$basediagnostico4,$basediagnostico5,$basediagnostico6,$basediagnostico7,$basediagnostico8,$basediagnostico9,$fuente1,$fechapacex1,$fechahospex1,$horahospex1,$fuente2,$fechapacex2,$fechahospex2,$horahospex2,$fuente3,$fechapacex3,$fechahospex3,$horahospex3,$fechaultimocontacto,$estadio,$defuncion,$causa,$observacionfinal,$provenencia);
    if($result==true){
        echo json_encode(array("status"=>true,"message"=>"Registro poblacional insertado correctamente"));
    }else{
        echo json_encode(array("status"=>false,"message"=>"Error al insertar el registro poblacional"));
    }

}else{
    echo json_encode(array("status"=>false,"message"=>"No se han enviado los datos necesarios"));
}