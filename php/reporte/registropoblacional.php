<?php
require '../validation/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../controller.php';
require '../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
$empresa = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($enterprise);
} else {
    echo "Ups! Hubo un problema con su sesión, por favor vuelva a iniciar sesión";
    return;
}

if (!isset($_SESSION['USER_ID'])) {
    echo "No se ha iniciado una sesión";
    return;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if($id<=0){
        echo "El id ingresado no es válido";
        return;
    }
    $registro = $c->buscarregistropoblacional($id);
    if($registro==null){
        echo "No se ha encontrado el registro poblacional";
        return;
    }
    //Recopilar Información
    $paciente = $c->buscarPaciente($registro['paciente']);
    $empresa = $c->buscarEmpresa($paciente->getEmpresa());
    
    $ano = date("Y", strtotime($paciente->getFechaNacimiento()));
    $dia = date("d", strtotime($paciente->getFechaNacimiento()));
    $mes = date("m", strtotime($paciente->getFechaNacimiento()));
    $ano_actual = date("Y");
    $mes_actual = date("m");
    $dia_actual = date("d");
    $edad = $ano_actual - $ano;
    if ($mes_actual < $mes) {
        $edad--;
    } else {
        if ($mes_actual == $mes) {
            if ($dia_actual < $dia) {
                $edad--;
            }
        }
    }
    $edad = $edad . " años";
    $direccion = "";
    $comuna = null;
    $ciudad = null;
    $datosubicacion = $c->listardatosubicacion($paciente->getId());
    if($datosubicacion!=null){
        $direccion = $datosubicacion->getNombrecalle()." ". $datosubicacion->getNumerocalle();
        $comuna = $c->buscarencomuna($datosubicacion->getComuna());
        $ciudad = $c->buscarenciudad($datosubicacion->getCiudad());
    }
    //Información Centro de salud
    $contenido = "<h4 style='text-align:center;'>Registro Poblacional de Cancer</h4>";
    $contenido .= "<p style='text-align:center;'>FORMULARIO DE REGISTRO caso nuevo de cáncer (llenar por personal del Registro)</p>";
    $contenido .= "<table border='1' style='width:100%; font-size:11px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr>";
    $contenido .= "<th style='width:100%;'>";

    $contenido .= "<table border='0' style='width:100%; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr>";
    $contenido .= "<th style='width:50%; text-align:left;'>Servicio de Salud: " . $empresa->getRazonSocial() . "</th>";
    $contenido .= "<td style='width:50%; text-align:right;'>Región: " . $empresa->getRegion() . "</td>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "<table border='1' style='width:100%; margin-top:7px; font-size:11px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr>";
    $contenido .= "<th style='width: 50%; text-align:left;'>";
    $contenido .= "<label>Fecha Visita</label>";
    $contenido .= "<input type='text' value='";echo date("d-m-Y", strtotime($registro['registro']));$contenido .= "'>";
    $contenido .= "</th>";
    $contenido .= "<th style='width: 50%; text-align:left;'>";
    $contenido .= "<label>N° Correlativo del Caso</label>";
    $contenido .= "<input type='text'>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "<table border='1' style='width:100%; margin-top:7px;font-size:11px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "Institución o Establecimiento que entrega información: ".$empresa->getRazonSocial();
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    //Información Paciente
    $contenido .= "<table border='1' style='width:100%; margin-top:7px; font-size:11px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th colspan='3' style='width:100%; text-align:left;'>";
        $contenido .= "Antecedentes del Paciente";
        $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width: 33%; text-align:center;'>";
        $contenido .= "Apellido Paterno:<br>".$paciente->getApellido1();
        $contenido .= "</th>";
        $contenido .= "<th style='width: 33%; text-align:center;'>";
        $contenido .= "Apellido Materno:<br>".$paciente->getApellido2();
        $contenido .= "</th>";
        $contenido .= "<th style='width: 33%; text-align:center;'>";
        $contenido .= "Nombres:<br>".$paciente->getNombre();
        $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th colspan='3'>";

            $contenido .= "<table border='0' style='width:100%; border-collapse: collapse; border: 1px solid #fff;'>";
            $contenido .= "<tr>";
            $contenido .= "<th colspan='3' style='width:100%; text-align:left;'>RUT: " . $paciente->getRut() . "</th>";
            $contenido .= "</tr>";
            $contenido .= "<tr>";
            $contenido .= "<th style='width:33%; text-align:left;'>Sexo:";
            $contenido .= "<input style='width:15px;' type='text' ";if($paciente->getGenero()==1){$contenido .= "value='X'";} $contenido .= ">M";
            $contenido .= "<input style='width:15px;' type='text'";if($paciente->getGenero()==2){$contenido .= "value='X'";} $contenido .= ">F";
            $contenido .= "<input style='width:15px;' type='text'";if($paciente->getGenero()!=1 && $paciente->getGenero()!=2){$contenido .= "value='X'";} $contenido .= ">Desc";
            $contenido .= "</th>";
            $contenido .= "<th style='width:33%; text-align:left;'>Edad: " . $edad . "</th>";
            $contenido .= "<th style='width:33%; text-align:left;'>Fecha Nacimiento: " . date("d-m-Y", strtotime($paciente->getFechaNacimiento())) . "</th>";
            $contenido .= "</tr>";
            $contenido .= "</table>";
        
        $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th colspan='3' style='width:100%; text-align:left;'>";
    $contenido .= "Dirección: ".$direccion;
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th colspan='3' style='width:100%; text-align:left;'>";

    $contenido .= "<table border='0' style='width:100%; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "Comuna: ".$comuna->getNombre();
    $contenido .= "</th>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "Ciudad: ".$ciudad->getNombre();
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";

    $contenido .= "<table border='1' style='width:100%; margin-top:7px; font-size:11px;  border-collapse: collapse; border: 1px solid #fff;'>";

    //Rama de Actividad
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";
        $contenido .= "Rama de Actividad";
        $contenido .= "</th>";
    $contenido .= "</tr>";

    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";

        $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
                    $contenido .= "<tr style='width:100%; text-align:left;'>";
                        //Rama de Actividad del 1 al 4
                        $contenido .= "<th style='width: 33%; text-align:left;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama1']==1){$contenido .= "value='X'";} $contenido .= ">Agricultura, Caza, Silvicultura y Pesca<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama2']==1){$contenido .= "value='X'";} $contenido .= ">Minas y Canteras<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama3']==1){$contenido .= "value='X'";} $contenido .= ">Industria Manufacturera<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama4']==1){$contenido .= "value='X'";} $contenido .= ">Electricidad, Gas y Agua<br>";
                        $contenido .= "</th>";
                        //Rama de Actividad del 5 al 8
                        $contenido .= "<th style='width: 33%; text-align:left;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama5']==1){$contenido .= "value='X'";} $contenido .= ">Construcción<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama6']==1){$contenido .= "value='X'";} $contenido .= ">Comercio mayor y menor, restaurant y hotel<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama7']==1){$contenido .= "value='X'";} $contenido .= ">Transporte, Almacenamiento y Comunicaciones<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama8']==1){$contenido .= "value='X'";} $contenido .= ">Servicios Financierios<br>";                        
                        $contenido .= "</th>";
                        //Rama de Actividad del 9 al 10
                        $contenido .= "<th style='width: 33%; text-align:left; display:flex; align-items:start;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama9']==1){$contenido .= "value='X'";} $contenido .= ">Servicios Comunales, Sociales, Personales<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['rama10']==1){$contenido .= "value='X'";} $contenido .= ">Actividad no especificada<br>";                        
                        $contenido .= "</th>";
                    $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Ocupación
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";
        $contenido .= "Ocupación";
        $contenido .= "</th>";
    $contenido .= "</tr>";

    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";

        $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
                    $contenido .= "<tr style='width:100%; text-align:left;'>";
                        //Ocupacion del 1 al 4
                        $contenido .= "<th style='width: 33%; text-align:left;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion1']==1){$contenido .= "value='X'";} $contenido .= ">Profesionales, Técnicos y Afines<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion2']==1){$contenido .= "value='X'";} $contenido .= ">Gerentes, Administradores y Directivos<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion3']==1){$contenido .= "value='X'";} $contenido .= ">Empleados oficina y afines<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion4']==1){$contenido .= "value='X'";} $contenido .= ">Vendedores y afines<br>";
                        $contenido .= "</th>";
                        //Ocupacion del 5 al 8
                        $contenido .= "<th style='width: 33%; text-align:left;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion5']==1){$contenido .= "value='X'";} $contenido .= ">Agricultores, Ganadores, Pescadores<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion6']==1){$contenido .= "value='X'";} $contenido .= ">Conductores y afines<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion7']==1){$contenido .= "value='X'";} $contenido .= ">Artesanos y Operarios<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion8']==1){$contenido .= "value='X'";} $contenido .= ">Otros Artesanos y Operarios<br>";
                        $contenido .= "</th>";
                        //Ocupacion del 9 al 11
                        $contenido .= "<th style='width: 33%; text-align:left; display:flex; align-items:start;'>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion9']==1){$contenido .= "value='X'";} $contenido .= ">Obreros y Jornaleros N.E.O.C<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion10']==1){$contenido .= "value='X'";} $contenido .= ">Trabajadores en Servicios Personales<br>";
                        $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['ocupacion11']==1){$contenido .= "value='X'";} $contenido .= ">Otros trabajadores N.E.O.C. 2/<br>";
                        $contenido .= "</th>";
                    $contenido .= "</tr>";
                $contenido .= "</table>";
            
        $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Características del cáncer
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";
        $contenido .= "Características del cáncer";
        $contenido .= "</th>";
    $contenido .= "</tr>";

    $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:100%; text-align:left;'>";

        $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
        $contenido .= "<tr style='width:100%; text-align:left;'>";
        $contenido .= "<th style='width:50%; text-align:left;'>";
        $contenido .= "<label> Sitio Primario: (Topografia)</label><br/>";
        $contenido .= "<label>C</label>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['sp1'] ."'>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['sp2'] ."'>";
        $contenido .= "<label>.</label>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['sp3'] ."'><br/>";

        $contenido .= "<br/><label>Tipo Morfológico: (Morfología)</label><br/>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['th1'] ."'>";
        $contenido .= "<label>_</label>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['th2'] ."'>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['th3'] ."'>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['th4'] ."'>";
        $contenido .= "<input style=' text-align:center;' type='text' value='". $registro['th5'] ."'>";

        $contenido .= "<br/><label> Comportamiento: (Comportamiento)</label><br/>";
        $contenido .= "<input style='text-align:center;' type='text' value='". $registro['comportamiento'] ."'>";
        $contenido .= "</th>";
        $contenido .= "<th style='width:50%; text-align:left;'>";
        $contenido .= "<label>Observaciones</label><br/>";
        $contenido .= $registro['comportamientoobservaciones'];
        $contenido .= "</th>";
        $contenido .= "</tr>";

        $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";

    //Grado de Diferenciación
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    
    $contenido .= "<th style='width:100%; text-align:left;'>";

    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Grado de Diferenciación</h3><br/>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['grado1']==1){$contenido .= "value='X'";} $contenido .= ">Bien diferenciado<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['grado2']==1){$contenido .= "value='X'";} $contenido .= ">Moderadamente diferenciado<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['grado3']==1){$contenido .= "value='X'";} $contenido .= ">Pobremente diferenciado<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['grado4']==1){$contenido .= "value='X'";} $contenido .= ">Indiferenciado o anaplásico<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['grado5']==1){$contenido .= "value='X'";} $contenido .= ">No determinado o inaplicable<br>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Extensión</h3><br/>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['extension1']==1){$contenido .= "value='X'";} $contenido .= ">In situ<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['extension2']==1){$contenido .= "value='X'";} $contenido .= ">Localizada<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['extension3']==1){$contenido .= "value='X'";} $contenido .= ">Regional<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['extension4']==1){$contenido .= "value='X'";} $contenido .= ">Metástasis<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['extension5']==1){$contenido .= "value='X'";} $contenido .= ">Desconocido<br>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Lateralidad<br/>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['lateralidad1']==1){$contenido .= "value='X'";} $contenido .= ">Derecho<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['lateralidad2']==1){$contenido .= "value='X'";} $contenido .= ">Izquierdo<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['lateralidad3']==1){$contenido .= "value='X'";} $contenido .= ">Bilateral<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['lateralidad4']==1){$contenido .= "value='X'";} $contenido .= ">No corresponde<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['lateralidad5']==1){$contenido .= "value='X'";} $contenido .= ">Desconocido<br>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    /***************************************************************************************************** */
    $contenido .= "</th>";
    $contenido .= "</tr>";


    //Fecha de Incidencia
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<label>Fecha de Incidencia: </label>".date("d-m-Y", strtotime($registro['fechaincidencia']))." ".date("H:i", strtotime($registro['horaincidencia']));
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<h3>Base de Diagnóstico</h3><br/>";
    $contenido .= "</th>";
    $contenido .= "</tr>";

    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico1']==1){$contenido .= "value='X'";} $contenido .= ">Clínico<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico2']==1){$contenido .= "value='X'";} $contenido .= ">Laboratorio<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico3']==1){$contenido .= "value='X'";} $contenido .= ">Radiológico<br>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico4']==1){$contenido .= "value='X'";} $contenido .= ">Citológico<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico5']==1){$contenido .= "value='X'";} $contenido .= ">Histológico<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico6']==1){$contenido .= "value='X'";} $contenido .= ">Inmunohistoquímico<br>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico7']==1){$contenido .= "value='X'";} $contenido .= ">Molecular<br>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['basediagnostico8']==1){$contenido .= "value='X'";} $contenido .= ">Otros<br>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";

    $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Fuente de Información
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Fuente N°1</h3><br/>";
    $contenido .= "<label>Nombre: </label>".$registro['fuente1']."<br/>";
    $contenido .= "<label>N° de Ficha del paciente o del examen: </label><br/>".$registro['fichapacex1']."<br/>";
    $contenido .= "<label>Fecha de la Hospitalización o examen: </label><br/>".date("d-m-Y", strtotime($registro['fechahospex1']))." ".date("H:i", strtotime($registro['horahospex1']))."<br/>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Fuente N°2</h3><br/>";
    $contenido .= "<label>Nombre: </label>".$registro['fuente2']."<br/>";
    $contenido .= "<label>N° de Ficha del paciente o del examen: </label><br/>".$registro['fichapacex2']."<br/>";
    $contenido .= "<label>Fecha de la Hospitalización o examen: </label><br/>".date("d-m-Y", strtotime($registro['fechahospex2']))." ".date("H:i", strtotime($registro['horahospex2']))."<br/>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:33%; text-align:left;'>";
    $contenido .= "<h3>Fuente N°3</h3><br/>";
    $contenido .= "<label>Nombre: </label>".$registro['fuente3']."<br/>";
    $contenido .= "<label>N° de Ficha del paciente o del examen: </label><br/>".$registro['fichapacex3']."<br/>";
    $contenido .= "<label>Fecha de la Hospitalización o examen: </label><br/>".date("d-m-Y", strtotime($registro['fechahospex3']))." ".date("H:i", strtotime($registro['horahospex3']))."<br/>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Ultimo Contacto
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "<h3>Fecha Ultimo Contacto</h3><br/>";
    $contenido .= date("d-m-Y", strtotime($registro['fechaultimocontacto']))."<br/>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "<h3>Estadio</h3><br/>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['estadio']==1){$contenido .= "value='X'";} $contenido .= ">Vivo";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['estadio']==2){$contenido .= "value='X'";} $contenido .= ">Muerto";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['estadio']==3){$contenido .= "value='X'";} $contenido .= ">Sin Información<br>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Defuncion
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<table border='0' style='width:100%; font-size:7px; border-collapse: collapse; border: 1px solid #fff;'>";
    $contenido .= "<tr style='width:100%; text-align:left;'>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "<h3>Defunción</h3><br/>";
    $contenido .= "<label>Fecha: </label>".date("d-m-Y", strtotime($registro['defuncion']))."<br/>";
    $contenido .= "</th>";
    $contenido .= "<th style='width:50%; text-align:left;'>";
    $contenido .= "<h3>Causa</h3><br/>";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['causa']==1){$contenido .= "value='X'";} $contenido .= ">Cáncer";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['causa']==2){$contenido .= "value='X'";} $contenido .= ">Otra";
    $contenido .= "<input style='width:10px; text-align:center;' type='text' ";if($registro['causa']==3){$contenido .= "value='X'";} $contenido .= ">Desconocido<br>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    /***************************************************************************************************** */
    //Observaciones
    /************************************************************************************************* */
    $contenido .= "<tr style='width:100%; text-align:left; border: 1px solid #000;'>";
    $contenido .= "<th style='width:100%; text-align:left;'>";
    $contenido .= "<p>Observaciones:<br/> ".$registro['obsersavacionfinal']."</p>";
    $contenido .= "</th>";
    $contenido .= "</tr>";
    $contenido .= "</table>";













    //PDF Inicio
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle("Registro Poblacional de Cancer");
    $mpdf->SetAuthor("Oncoway");
    $mpdf->SetCreator("Oncoway");
    $mpdf->SetSubject("Registro Poblacional de Cancer");
    $mpdf->SetKeywords("Oncoway, Registro Poblacional, Cancer");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetWatermarkText('Oncoway');
    //$mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    //$mpdf->SetHTMLHeader('<div style="text-align: right; font-weight: bold; font-size: 9pt; font-family: sans-serif;">{DATE j-m-Y}</div>');
    $mpdf->SetHTMLFooter('
    <div style="text-align: center; font-weight: bold; font-size: 9pt; font-family: sans-serif;">Oncoway</div>
    <div style="text-align: right; font-weight: bold; font-size: 9pt; font-family: sans-serif;">{PAGENO}/{nbpg}</div>
    ');
    $mpdf->WriteHTML($contenido);
    $nombrecontenido = "REG_POB_CAN_" . $paciente->getRut() . "_" . date("dmyHis") . ".pdf";
    $mpdf->Output($nombrecontenido, 'I');
}else{
    echo "No se ha seleccionado un paciente";
    return;
}