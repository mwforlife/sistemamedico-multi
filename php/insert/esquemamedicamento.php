<?php
require '../controller.php';
$c = new controller();
session_start();
if(isset($_POST['medicamentoid']) && isset($_POST['dosis']) && isset($_POST['carboplatino']) && isset($_POST['esquemaid'])){
    $medicamentoid = $_POST['medicamentoid'];
    $dosis = $_POST['dosis'];
    $carboplatino = $_POST['carboplatino'];
    $esquemaid = $_POST['esquemaid'];

    $esquema = $c->buscarenesquema($esquemaid);

    //Validate if the data is not empty
    if(empty($medicamentoid) ||  empty($carboplatino) || empty($esquemaid)){
        echo json_encode(array('error' => true, 'message' => 'Se deben llenar todos los campos'));
        return;
    }

    //Validate Dosis
    if(is_numeric($dosis) == false){
        echo json_encode(array('error' => true, 'message' => 'La dosis debe ser un numero'));
        return;
    }
    
    if($dosis < 0){
        echo json_encode(array('error' => true, 'message' => 'La dosis debe ser mayor o igual a 0'));
        return;
    }

    //Validate if the medicament is already in the esquema
    $medicamentoesquema = $c->validarmedicamentoesquema($esquemaid, $medicamentoid);
    if($medicamentoesquema == true){
        echo json_encode(array('error' => true, 'message' => 'El medicamento ya se encuentra en el esquema'));
        return;
    }

    $object = $c->registrarmedicamentosesquemas($esquemaid,$medicamentoid, $dosis, $carboplatino);
    if ($object ==true) {
        echo json_encode(array('error' => false, 'message' => 'Esquema de medicamento insertado correctamente'));
        
        /***********Auditoria******************* */
        $titulo = "Asignación de Medicamento a Esquema";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo medicamento en el esquema con el nombre de " . $esquema->getNombre() . " y codigo " . $esquema->getCodigo() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    } else {
        echo json_encode(array('error' => true, 'message' => 'Error al insertar el esquema de medicamento'));
    }
}else{
    echo json_encode(array('error' => true, 'message' => 'No se recibieron los datos'));
}