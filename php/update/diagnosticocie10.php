<?php
require '../controller.php';
$c = new Controller();
/*id: id, codigo: codigo, descripcion: descripcion, nodoedit: nodoedit, manifestacionedit: manifestacionedit, perinataledit: perinataledit, pediatricoedit: pediatricoedit, obstetricoedit: obstetricoedit, adultoedit: adultoedit, mujeredit: mujeredit, hombreedit: hombreedit, poaexemptoedit: poaexemptoedit, dpnoprincedit: dpnoprincedit, vcdpedit: vcdpedit */
/*id: 3
codigo: A00
descripcion: Cólera
nodoedit: 0
manifestacionedit: 0
perinataledit: 0
pediatricoedit: 0
obstetricoedit: 0
adultoedit: 0
mujeredit: 0
hombreedit: 0
poaexemptoedit: 0
dpnoprincedit: 0
vcdpedit: 0*/

if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['descripcion']) && isset($_POST['nodoedit']) && isset($_POST['manifestacionedit']) && isset($_POST['perinataledit']) && isset($_POST['pediatricoedit']) && isset($_POST['obstetricoedit']) && isset($_POST['adultoedit']) && isset($_POST['mujeredit']) && isset($_POST['hombreedit']) && isset($_POST['poaexemptoedit']) && isset($_POST['dpnoprincedit']) && isset($_POST['vcdpedit'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $nodoedit = $_POST['nodoedit'];
    $manifestacionedit = $_POST['manifestacionedit'];
    $perinataledit = $_POST['perinataledit'];
    $pediatricoedit = $_POST['pediatricoedit'];
    $obstetricoedit = $_POST['obstetricoedit'];
    $adultoedit = $_POST['adultoedit'];
    $mujeredit = $_POST['mujeredit'];
    $hombreedit = $_POST['hombreedit'];
    $poaexemptoedit = $_POST['poaexemptoedit'];
    $dpnoprincedit = $_POST['dpnoprincedit'];
    $vcdpedit = $_POST['vcdpedit'];


    if(strlen($manifestacionedit) == 0){
        $manifestacionedit = "NULL";
    } 

    if(strlen($perinataledit) == 0){
        $perinataledit = "NULL";
    }

    if(strlen($pediatricoedit) == 0){
        $pediatricoedit = "NULL";
    }

    if(strlen($obstetricoedit) == 0){
        $obstetricoedit = "NULL";
    }

    if(strlen($adultoedit) == 0){
        $adultoedit = "NULL";
    }

    if(strlen($mujeredit) == 0){
        $mujeredit = "NULL";
    }

    if(strlen($hombreedit) == 0){
        $hombreedit = "NULL";
    }

    if(strlen($poaexemptoedit) == 0){
        $poaexemptoedit = "NULL";
    }

    if(strlen($dpnoprincedit) == 0){
        $dpnoprincedit = "NULL";
    }

    if(strlen($vcdpedit) == 0){
        $vcdpedit = "NULL";
    }

    
    if(strlen($codigo)>0 && strlen($descripcion)>0 && strlen($nodoedit)>0){
        $result = $c->actualizarDiagnosticocie10($id, $codigo, $descripcion, $nodoedit, $manifestacionedit, $perinataledit, $pediatricoedit, $obstetricoedit, $adultoedit, $mujeredit, $hombreedit, $poaexemptoedit, $dpnoprincedit, $vcdpedit);
        if ($result == true) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "Hay campos vacios";
    }
}else{
echo "No se recibieron los datos";
}
