<?php
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['nodofinal']) && isset($_POST['manifestacion']) && isset($_POST['perinatal']) && isset($_POST['pediatrico']) && isset($_POST['obstetrico']) && isset($_POST['adulto']) && isset($_POST['mujer']) && isset($_POST['hombre']) && isset($_POST['poaexento']) && isset($_POST['dpnoprincipal']) && isset($_POST['vcdp'])) {
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $nodofinal = $_POST['nodofinal'];
    
    $manifestacion = $_POST['manifestacion'];
    if(strlen($manifestacion) == 0){
        $manifestacion = "NULL";
    } 
    $perinatal = $_POST['perinatal'];
    if(strlen($perinatal) == 0){
        $perinatal = "NULL";
    }
    $pediatrico = $_POST['pediatrico'];
    if(strlen($pediatrico) == 0){
        $pediatrico = "NULL";
    }
    $obstetrico = $_POST['obstetrico'];
    if(strlen($obstetrico) == 0){
        $obstetrico = "NULL";
    }
    $adulto = $_POST['adulto'];
    if(strlen($adulto) == 0){
        $adulto = "NULL";
    }
    $mujer = $_POST['mujer'];
    if(strlen($mujer) == 0){
        $mujer = "NULL";
    }
    $hombre = $_POST['hombre'];
    if(strlen($hombre) == 0){
        $hombre = "NULL";
    }
    $poaexento = $_POST['poaexento'];
    if(strlen($poaexento) == 0){
        $poaexento = "NULL";
    }
    $dpnoprincipal = $_POST['dpnoprincipal'];
    if(strlen($dpnoprincipal) == 0){
        $dpnoprincipal = "NULL";
    }
    $vcdp = $_POST['vcdp'];
    if(strlen($vcdp) == 0){
        $vcdp = "NULL";
    }
    if(strlen($codigo)>0 && strlen($nombre)>0 && strlen($nodofinal)>0){
        $result = $c->registrardiagnosticocie10($codigo,$nombre,$nodofinal,$manifestacion,$perinatal,$pediatrico,$obstetrico,$adulto,$mujer,$hombre,$poaexento,$dpnoprincipal,$vcdp);
        if ($result == true) {
            echo "1";

            
        /***********Auditoria******************* */
        $titulo = "Registro de Diagnostico CIE10";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo diagnostico CIE10 con el nombre de " . $nombre . " y codigo " . $codigo . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
        } else {
            echo "0";
        }
    } else {
        echo "Hay campos vacios";
    }
}else{
echo "No se recibieron los datos";
}
