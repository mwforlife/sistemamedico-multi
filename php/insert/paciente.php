<?php
//Imprimir error de debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Incluir archivo de conexion a base de datos
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
} else {
	echo "No se ha seleccionado una empresa";
    return;
}
if(isset($_POST['tipoidentificacion']) && isset($_POST['rut']) && isset($_POST['documentoadd']) && isset($_POST['nacionalidad']) && isset($_POST['paisorigen']) && isset($_POST['correo']) && isset($_POST['nombre']) && isset($_POST['apellido1']) && isset($_POST['apellido2']) && isset($_POST['genero']) && isset($_POST['estadocivil']) && isset($_POST['fechanacimiento']) && isset($_POST['hora']) && isset($_POST['fonomovil']) && isset($_POST['fonofijo']) && isset($_POST['nombresocial']) && isset($_POST['funcionario']) && isset($_POST['discapacidad']) && isset($_POST['reciennacido']) && isset($_POST['hijode']) && isset($_POST['pesodenacimiento']) && isset($_POST['talladenacimiento']) && isset($_POST['tipoparto']) && isset($_POST['rol']) && isset($_POST['fechafallecimiento']) && isset($_POST['horafallecimiento']) && isset($_POST['ficha']) && isset($_POST['fechaadmision']) && isset($_POST['familia']) && isset($_POST['inscrito']) && isset($_POST['sector']) && isset($_POST['prevision']) && isset($_POST['tipoprevision']) && isset($_POST['estadoafiliar']) && isset($_POST['chilesolidario']) && isset($_POST['prais']) && isset($_POST['sename']) && isset($_POST['ubicacionficha']) && isset($_POST['fichasaludmental']) && isset($_POST['region']) && isset($_POST['procincia']) && isset($_POST['comuna']) && isset($_POST['ciudad']) && isset($_POST['tipocalle']) && isset($_POST['nombrecalle']) && isset($_POST['numerodireccion']) && isset($_POST['block']) && isset($_POST['pueblooriginario']) && isset($_POST['escolaridad']) && isset($_POST['cursorepite']) && isset($_POST['situacionlaboral']) && isset($_POST['ocupacion']) && isset($_POST['rutpersona']) && isset($_POST['nombrepersona']) && isset($_POST['relacion']) && isset($_POST['telefonomovil']) && isset($_POST['direccion'])){
    //Recuperar datos paciente
    $tipoidentificacion = $_POST['tipoidentificacion']; $rut = $_POST['rut']; $documentoadd = $_POST['documentoadd']; $nacionalidad = $_POST['nacionalidad']; $paisorigen = $_POST['paisorigen']; $correo = $_POST['correo']; $nombre = $_POST['nombre']; $apellido1 = $_POST['apellido1']; $apellido2 = $_POST['apellido2']; $genero = $_POST['genero']; $estadocivil = $_POST['estadocivil']; $fechanacimiento = $_POST['fechanacimiento']; $hora = $_POST['hora']; $fonomovil = $_POST['fonomovil']; $fonofijo = $_POST['fonofijo']; $nombresocial = $_POST['nombresocial']; $funcionario = $_POST['funcionario']; $discapacidad = $_POST['discapacidad']; $reciennacido = $_POST['reciennacido']; $hijode = $_POST['hijode']; $pesodenacimiento = $_POST['pesodenacimiento']; $talladenacimiento = $_POST['talladenacimiento']; $tipoparto = $_POST['tipoparto']; $rol = $_POST['rol']; $fechafallecimiento = $_POST['fechafallecimiento']; $horafallecimiento = $_POST['horafallecimiento'];

    
    //Validacion de datos
    if($tipoidentificacion == 1){
        $valid = $c->validarregistropaciente($rut,$empresa->getId());
        if($valid==true){
            echo "El rut ya existe";
            return;
        }
    }else if($tipoidentificacion > 2){
        $valid = $c->validaridentificacionpaciente($documentoadd);
        if($valid==true){
            echo "El numero de identificacion ya existe";
            return;
        }
    }else if($tipoidentificacion == 2){
        //Generar un numero de documento aleatorio
        while($valid == false){
            $documentoadd = rand(10000000, 99999999);
            $valid = $c->validaridentificacionpaciente($documentoadd);
        }
    }

    if(strlen($rut) < 8){
        echo "El rut debe tener al menos 8 caracteres";
        return;
    }

    if(strlen($nombre) < 3){
        echo "El nombre debe tener al menos 3 caracteres";
        return;
    }

    if(strlen($apellido1) < 3){
        echo "El apellido paterno debe tener al menos 3 caracteres";
        return;
    }


    if(strlen($fechanacimiento) < 10){
        echo "La fecha de nacimiento debe tener al menos 10 caracteres";
        return;
    }

    if(strlen($fonomovil) == 0){
        echo "Debe ingresar un numero de telefono movil";
        return;
    }

    if(strlen($talladenacimiento)==0){
        $talladenacimiento = 0;
    }

    if(strlen($pesodenacimiento)==0){
        $pesodenacimiento = 0;
    }

    $empresa = $enterprise;

    

    $idpac = $c->registrarpaciente($tipoidentificacion, $rut, $documentoadd, $nacionalidad, $paisorigen, $correo, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $hora, $fonomovil, $fonofijo, $nombresocial, $funcionario,$discapacidad, $reciennacido, $hijode, $pesodenacimiento, $talladenacimiento, $tipoparto, $rol, $fechafallecimiento, $horafallecimiento,1,$empresa);

    if($idpac<=0){
        echo "Error al registrar paciente" . $idpac;
        return;
    }
    
    //Recuperar datos ficha
    $ficha = $_POST['ficha']; $fechaAdmision = $_POST['fechaadmision']; $familia = $_POST['familia']; $inscrito = $_POST['inscrito']; $sector = $_POST['sector']; $prevision = $_POST['prevision']; $tipoPrevision = $_POST['tipoprevision']; $estadoAfiliar = $_POST['estadoafiliar']; $chileSolidario = $_POST['chilesolidario']; $prais = $_POST['prais']; $sename = $_POST['sename']; $ubicacionFicha = $_POST['ubicacionficha']; $fichaSaludMental = $_POST['fichasaludmental']; 

    $c->registrarinscripcionprevision($idpac, $ficha, $fechaAdmision, $familia, $inscrito, $sector, $tipoPrevision, $estadoAfiliar, $chileSolidario, $prais, $sename, $ubicacionFicha, $fichaSaludMental);
    
    //Recuperar datos de Ubicacion
    $region = $_POST['region']; $provincia = $_POST['procincia']; $comuna = $_POST['comuna']; $ciudad = $_POST['ciudad']; $tipoCalle = $_POST['tipocalle']; $nombreCalle = $_POST['nombrecalle']; $numeroDireccion = $_POST['numerodireccion']; $block = $_POST['block']; 

    $nombreCalle = $c->escapeString($nombreCalle);
    $numeroDireccion = $c->escapeString($numeroDireccion);
    $block = $c->escapeString($block);
    $c->registrardatosubicacion($idpac, $region, $provincia, $comuna, $ciudad, $tipoCalle, $nombreCalle, $numeroDireccion, $block);
    
    //Recuperar Otros Antecedentes
    $puebloOriginario = $_POST['pueblooriginario']; $escolaridad = $_POST['escolaridad']; $cursoRepite = $_POST['cursorepite']; $situacionLaboral = $_POST['situacionlaboral']; $ocupacion = $_POST['ocupacion'];

    $c->registrarotrosantecedentes($idpac, $puebloOriginario, $escolaridad, $cursoRepite, $situacionLaboral, $ocupacion);
    
    //Recuperar datos de Persona responsable
    $rutPersona = $_POST['rutpersona']; $nombrePersona = $_POST['nombrepersona']; $relacion = $_POST['relacion']; $telefonoMovil = $_POST['telefonomovil']; $direccion = $_POST['direccion'];

    $rutPersona = $c->escapeString($rutPersona);
    $nombrePersona = $c->escapeString($nombrePersona);
    $telefonoMovil = $c->escapeString($telefonoMovil);
    $direccion = $c->escapeString($direccion);

    $c->registrarresponsable($idpac, $rutPersona, $nombrePersona, $relacion, $telefonoMovil, $direccion);

    echo 1;
    
        /***********Auditoria******************* */
        $titulo = "Registro de Paciente";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo paciente con nombre " . $nombre . " " . $apellido1 . " " . $apellido2 . " y rut " . $rut . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */

}else{
    echo "No se han recibido los datos correctamente";
}

