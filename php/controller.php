<?php
require "Class/Diagnostico.php";
require "Class/DiagnosticoCIEO.php";
require "Class/DiagnosticoCIE10.php";
require "Class/Objects.php";
require "Class/Comunas.php";
require "Class/Profesion.php";
require "Class/Usuario.php";
require "Class/Nombrecomite.php";
require "Class/Comite.php";
require "Class/Paciente.php";
require "Class/Profesionalcomite.php";
require "Class/Pacientecomite.php";
require "Class/Auditoria.php";
require "Class/Signos.php";
require "Class/Medidas.php";
require "Class/TNM.php";
require "Class/PacienteDiagnosticos.php";
require "Class/Informecomite.php";  
require "Class/CodigoActividad.php";
require "Class/RepresentanteLegal.php";
require "Class/Empresa.php";
require "Class/Otrosatecedentes.php";
require "Class/Responsable.php";
require "Class/Datosubicacion.php";
require "Class/Incripcion.php";
require 'Class/DiasFeriados.php';
require 'Class/Disponibilidad.php';
require 'Class/Horario.php';
require 'Class/Atencion.php';

class Controller{
    private $mi;

    private $host = "localhost";
    /*Variables
    private $user = "root";
    private $pass = "";
    private $bd = "oncoway";

    /*Variables BD Server
    private $user = 'oncowayc_admin';
    private $pass = 'Administrad0r2023%$#@';
    private $bd = 'oncowayc_bd';
    
    /*Variables BD Server*/
    private $user = 'u729479817_admin';
    private $pass = 'Administrad0r2023%$#@';
    private $bd = 'u729479817_oncoway';

    /* Variables globales */
    private function conexion()
    {
        $this->mi = new mysqli($this->host, $this->user, $this->pass, $this->bd);
        if ($this->mi->connect_errno) {
            echo "Error al conectar con la base de datos";
        }
    }

    //Desconexion
    private function desconexion(){
        $this->mi->close();
    }

    //Calcular Edad, ano, mes, dia
    public function calcularEdad($fecha){
        $this->conexion();
        $sql = "select datediff(now(), '$fecha') as dias";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $dias = $rs['dias'];
            $anos = floor($dias/365);
            $meses = floor(($dias%365)/30);
            $dias = floor(($dias%365)%30);
            $edad = $anos . " años, " . $meses . " meses, " . $dias . " días";
            $this->desconexion();
            return $edad;
        }
        $this->desconexion();
        return null;
    }

    //Calcular BSA
    function calculateBSA($Height, $Weight) {
        $BSA = 0.007184 * pow($Height, 0.725) * pow($Weight, 0.425);
        return round($BSA, 2);
    }

    //Encriptar datos
    function encrypt($data, $clave_secreta) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $datos_encriptados = openssl_encrypt($data, 'aes-256-cbc', $clave_secreta, 0, $iv);
        return base64_encode($iv . $datos_encriptados);
    }

    //Desencriptar datos
    function decrypt($data, $clave_secreta) {
        $data = base64_decode($data);
        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $datos_desencriptados = openssl_decrypt(substr($data, openssl_cipher_iv_length('aes-256-cbc')), 'aes-256-cbc', $clave_secreta, 0, $iv);
        return $datos_desencriptados;
    }
    

    //Escape String 
    public function escapeString($text)
    {
        $this->conexion();
        $text = $this->mi->real_escape_string($text);
        $this->desconexion();
        return $text;
    }

    //Query
    public function query($sql)
    {
        $this->conexion();
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Acciones
    //Listar acciones
    public function listarAcciones(){
        $this->conexion();
        $sql = "select * from acciones order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $accion = new Objects($id,$id, $nombre);
            $lista[] = $accion;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Accion
    public function buscarAccion($id){
        $this->conexion();
        $sql = "select * from acciones where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $accion = new Objects($id,$id, $nombre);
            $this->desconexion();
            return $accion;
        }
        $this->desconexion();
        return null;
    }
    //Auditoria
    public function registrarAuditoria($usuario, $accion, $titulo, $evento){
        $this->conexion();
        $sql = "insert into auditoriaeventos values(null, $usuario, $accion, '$titulo', '$evento', now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Auditoria por usuario
    public function listarAuditoria($usuario){
        $this->conexion();
        $sql = "select auditoriaeventos.id as id, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, acciones.nombre as accion, auditoriaeventos.titulo as titulo, auditoriaeventos.evento as evento, auditoriaeventos.fecha as fecha from auditoriaeventos inner join usuarios on auditoriaeventos.usuario = usuarios.id inner join acciones on auditoriaeventos.accion = acciones.id where auditoriaeventos.usuario = $usuario order by auditoriaeventos.fecha desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $usuario = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $accion = $rs['accion'];
            $titulo = $rs['titulo'];
            $evento = $rs['evento'];
            $fecha = $rs['fecha'];
            $auditoria = new Auditoria($id, $usuario, $accion, $titulo, $evento, $fecha);
            $lista[] = $auditoria;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Auditoria por acción
    public function listarAuditoriaAccion($accion){
        $this->conexion();
        $sql = "select auditoriaeventos.id as id, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, acciones.nombre as accion, auditoriaeventos.titulo as titulo, auditoriaeventos.evento as evento, auditoriaeventos.fecha as fecha from auditoriaeventos inner join usuarios on auditoriaeventos.usuario = usuarios.id inner join acciones on auditoriaeventos.accion = acciones.id where auditoriaeventos.accion = $accion order by auditoriaeventos.fecha desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $usuario = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $accion = $rs['accion'];
            $titulo = $rs['titulo'];
            $evento = $rs['evento'];
            $fecha = $rs['fecha'];
            $auditoria = new Auditoria($id, $usuario, $accion, $titulo, $evento, $fecha);
            $lista[] = $auditoria;
        }
        $this->desconexion();
        return $lista;
    }

    //bUSCAR EVENTO DE AUDITORIA
    public function buscarAuditoria($id){
        $this->conexion();
        $sql = "select auditoriaeventos.id as id, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, acciones.nombre as accion, auditoriaeventos.titulo as titulo, auditoriaeventos.evento as evento, auditoriaeventos.fecha as fecha from auditoriaeventos inner join usuarios on auditoriaeventos.usuario = usuarios.id inner join acciones on auditoriaeventos.accion = acciones.id where auditoriaeventos.id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $usuario = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $accion = $rs['accion'];
            $titulo = $rs['titulo'];
            $evento = $rs['evento'];
            $fecha = $rs['fecha'];
            $auditoria = new Auditoria($id, $usuario, $accion, $titulo, $evento, $fecha);
            $this->desconexion();
            return $auditoria;
        }
        $this->desconexion();
        return null;
    }

    //listar Diagnosticos
    public function listarDiagnosticos(){
        $this->conexion();
        $sql = "select * from diagnosticos order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $completa = $rs['nombre'];
            $abreviado = $rs['registro'];
            $diagnostico = new Diagnostico($id, $codigo, $completa, $abreviado);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }

    //Diagnosticos CIEO
    //Registrar Diagnosticos CIEO
    public function registrardiagnosticocieo($codigo, $completa, $abreviado, $tipo){
        $this->conexion();
        $sql = "insert into diagnosticoscieo values(null,'$codigo','$completa', '$abreviado',$tipo,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Diagnosticos CIEO 
    public function listarDiagnosticosCIEO(){
        $this->conexion();
        $sql = "select * from diagnosticoscieo;";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $completa = $rs['descipcioncompleta'];
            $abreviado = $rs['descripcionabreviada'];
            $tipo = $rs['tipodiagnostico'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIEO($id, $codigo, $completa, $abreviado, $tipo, $fecha);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }
    //Listar Diagnosticos CIEO Morfologicos
    public function listarDiagnosticosCIEOMorfologicos(){
        $this->conexion();
        $sql = "select * from diagnosticoscieo where tipodiagnostico = 1;";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $completa = $rs['descipcioncompleta'];
            $abreviado = $rs['descripcionabreviada'];
            $tipo = $rs['tipodiagnostico'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIEO($id, $codigo, $completa, $abreviado, $tipo, $fecha);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Diagnosticos CIEO Topograficos
    public function listarDiagnosticosCIEOTopograficos(){
        $this->conexion();
        $sql = "select * from diagnosticoscieo where tipodiagnostico = 2;";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $completa = $rs['descipcioncompleta'];
            $abreviado = $rs['descripcionabreviada'];
            $tipo = $rs['tipodiagnostico'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIEO($id, $codigo, $completa, $abreviado, $tipo, $fecha);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Diagnostico CIEO
    public function buscarDiagnosticocieo($id){
        $this->conexion();
        $sql = "select * from diagnosticoscieo where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $completa = $rs['descipcioncompleta'];
            $abreviado = $rs['descripcionabreviada'];
            $tipo = $rs['tipodiagnostico'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIEO($id, $codigo, $completa, $abreviado, $tipo, $fecha);
            $this->desconexion();
            return $diagnostico;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Diagnostico CIEO
    public function actualizarDiagnosticocieo($id, $codigo, $completa, $abreviado, $tipo){
        $this->conexion();
        $sql = "update diagnosticoscieo set codigo = '$codigo', descipcioncompleta = '$completa', descripcionabreviada = '$abreviado', tipodiagnostico = $tipo where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Diagnostico CIEO
    public function eliminarDiagnosticocieo($id){
        $this->conexion();
        $sql = "delete from diagnosticoscieo where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    
    //Diagnosticos CIE10
    //Registrar Diagnosticos CIE10
    //$codigo, $nombre, $nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp
    public function registrardiagnosticocie10($codigo, $nombre ,$nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp){
        $this->conexion();
        $sql = "insert into diagnosticoscie10 values(null,'$codigo','$nombre', $nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp, now())";
        echo $sql;
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Diagnosticos CIE10
    public function listarDiagnosticosCIE10(){
        $this->conexion();
        $sql = "select * from diagnosticoscie10;";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['descripcion'];
            $nodofinal = $rs['nodo_final'];
            $manifestacion = $rs['manifestacion_no_dp'];
            $perinatal = $rs['perinatal'];
            $pediatrico = $rs['pediatrico'];
            $obstetrico = $rs['obstetrico'];
            $adulto = $rs['adulto'];
            $mujer = $rs['mujer'];
            $hombre = $rs['hombre'];
            $poaexento = $rs['poa_exempto'];
            $dpnoprincipal = $rs['dp_no_principal'];
            $vcdp = $rs['vcdp'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIE10($id, $codigo, $nombre, $nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp, $fecha);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Diagnosticos CIE10
    public function listarDiagnosticosCIE10test(){
        $this->conexion();
        $sql = "select * from diagnosticoscie10;";
        $result = $this->mi->query($sql);
        $lista = array();
        $lista = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return json_encode($lista);
    }

    public function listarDiagnosticosCIE101(){
        $this->conexion();
        $sql = "select id, codigo, descripcion from diagnosticoscie10;";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['descripcion'];
            $nodofinal = "";
            $manifestacion = "";
            $perinatal = "";
            $pediatrico = "";
            $obstetrico = "";
            $adulto = "";
            $mujer= "";
            $hombre = "";
            $poaexento = "";
            $dpnoprincipal = "";
            $vcdp = "";
            $fecha = "";
            $diagnostico = new DiagnosticoCIE10($id, $codigo, $nombre, $nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp, $fecha);
            $lista[] = $diagnostico;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Diagnostico CIE10
    public function buscarDiagnosticocie10($id){
        $this->conexion();
        $sql = "select * from diagnosticoscie10 where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['descripcion'];
            $nodofinal = $rs['nodo_final'];
            $manifestacion = $rs['manifestacion_no_dp'];
            $perinatal = $rs['perinatal'];
            $pediatrico = $rs['pediatrico'];
            $obstetrico = $rs['obstetrico'];
            $adulto = $rs['adulto'];
            $mujer = $rs['mujer'];
            $hombre = $rs['hombre'];
            $poaexento = $rs['poa_exempto'];
            $dpnoprincipal = $rs['dp_no_principal'];
            $vcdp = $rs['vcdp'];
            $fecha = $rs['registro'];
            $diagnostico = new DiagnosticoCIE10($id, $codigo, $nombre, $nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp, $fecha);
            $this->desconexion();
            return $diagnostico;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Diagnostico CIE10
    public function actualizarDiagnosticocie10($id, $codigo, $nombre ,$nodofinal, $manifestacion, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poaexento, $dpnoprincipal, $vcdp){
        $this->conexion();
        $sql = "update diagnosticoscie10 set codigo = '$codigo', descripcion = '$nombre', nodo_final = $nodofinal, manifestacion_no_dp = $manifestacion, perinatal = $perinatal, pediatrico = $pediatrico, obstetrico = $obstetrico, adulto = $adulto, mujer = $mujer, hombre = $hombre, poa_exempto = $poaexento, dp_no_principal = $dpnoprincipal, vcdp = $vcdp where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Diagnostico CIE10
    public function eliminarDiagnosticocie10($id){
        $this->conexion();
        $sql = "delete from diagnosticoscie10 where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }


    //Ecog
    public function registrarecog($codigo, $nombre){
        $this->conexion();
        $sql = "insert into ecog values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Ecog
    public function listarecog(){
        $this->conexion();
        $sql = "select * from ecog order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Ecog
    public function buscarenecog($id){
        $this->conexion();
        $sql = "select * from ecog where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Ecog
    public function actualizarecog($id,$codigo, $nombre){
        $this->conexion();
        $sql = "update ecog set codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Ecog
    public function eliminarecog($id){
        $this->conexion();
        $sql = "delete from ecog where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }


    //Histologico
    public function registrarhistologico($codigo, $nombre){
        $this->conexion();
        $sql = "insert into histologico values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Histologico
    public function listarhistologico(){
        $this->conexion();
        $sql = "select * from histologico order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Histologico
    public function buscarenhistologico($id){
        $this->conexion();
        $sql = "select * from histologico where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id ,$codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Histologico
    public function actualizarhistologico($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update histologico set codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Histologico
    public function eliminarhistologico($id){
        $this->conexion();
        $sql = "delete from histologico where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }
    

    //Invacion Tumoral
    public function registrarinvaciontumoral($codigo, $nombre){
        $this->conexion();
        $sql = "insert into invaciontumoral values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Invacion Tumoral
    public function listarinvaciontumoral(){
        $this->conexion();
        $sql = "select * from invaciontumoral order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Invacion Tumoral
    public function buscareninvaciontumoral($id){
        $this->conexion();
        $sql = "select * from invaciontumoral where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Invacion Tumoral
    public function actualizarinvaciontumoral($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update invaciontumoral set  codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Invacion Tumoral
    public function eliminarinvaciontumoral($id){
        $this->conexion();
        $sql = "delete from invaciontumoral where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //TNM
    public function registrartnm($codigo, $nombre,$diagnostico,$tipo){
        $this->conexion();
        $sql = "insert into tnm values(null, '$codigo', '$nombre',$tipo,$diagnostico,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar TNM por tipo
    public function listartnm($tipo){
        $this->conexion();
        $sql = "select tnm.id as id, tnm.codigo as codigo, tnm.nombre as nombre, diagnosticos.nombre as diagnostico, tipotnm.nombre as tipotnm, tnm.registro as registro from tnm inner join diagnosticos on tnm.diagnostico = diagnosticos.id inner join tipotnm on tnm.tipotnm = tipotnm.id where tnm.tipotnm = $tipo order by tnm.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $diagnostico = $rs['diagnostico'];
            $tipo = $rs['tipotnm'];
            $registro = $rs['registro'];
            $tnm = new Tnm($id, $codigo, $nombre, $diagnostico, $tipo, $registro);
            $lista[] = $tnm;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar TNM por tipo
    public function listartnmpordiagnostico($tipo,$diagnostico){
        $this->conexion();
        $sql = "select tnm.id as id, tnm.codigo as codigo, tnm.nombre as nombre, diagnosticos.nombre as diagnostico, tipotnm.nombre as tipotnm, tnm.registro as registro from tnm inner join diagnosticos on tnm.diagnostico = diagnosticos.id inner join tipotnm on tnm.tipotnm = tipotnm.id where tnm.tipotnm = $tipo and tnm.diagnostico=$diagnostico order by tnm.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $diagnostico = $rs['diagnostico'];
            $tipo = $rs['tipotnm'];
            $registro = $rs['registro'];
            $tnm = new Tnm($id, $codigo, $nombre, $diagnostico, $tipo, $registro);
            $lista[] = $tnm;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar TNM
    public function buscarentnm($id){
        $this->conexion();
        $sql = "select * from tnm where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $diagnostico = $rs['diagnostico'];
            $tipo = $rs['tipotnm'];
            $registro = $rs['registro'];
            $tnm = new Tnm($id, $codigo, $nombre, $diagnostico, $tipo, $registro);
            $this->desconexion();
            return $tnm;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar TNM
    public function actualizartnm($id, $codigo, $nombre,$diagnostico){
        $this->conexion();
        $sql = "update tnm set  codigo = '$codigo', nombre = '$nombre' , diagnostico = $diagnostico where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar TNM
    public function eliminartnm($id){
        $this->conexion();
        $sql = "delete from tnm where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Regiones
    public function registrarregion($codigo, $nombre){
        $this->conexion();
        $sql = "insert into regiones values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Regiones
    public function listarregion(){
        $this->conexion();
        $sql = "select * from regiones order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Regiones
    public function buscarenregion($id){
        $this->conexion();
        $sql = "select * from regiones where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Regiones
    public function actualizarregion($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update regiones set codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Regiones
    public function eliminarregion($id){
        $this->conexion();
        $sql = "delete from regiones where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Provincias
    public function registrarprovincia($codigo, $nombre, $region){
        $this->conexion();
        $sql = "insert into provincias values(null, '$codigo', '$nombre', $region,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Provincias
    public function listarprovincia($region){
        $this->conexion();
        $sql = "select * from provincias where region = $region order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id']; 
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Provincias
    public function buscarenprovincia($id){
        $this->conexion();
        $sql = "select * from provincias where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id']; 
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Provincias
    public function actualizarprovincia($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update provincias set  codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Provincias
    public function eliminarprovincia($id){
        $this->conexion();
        $sql = "delete from provincias where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }


    //Comunas
    public function registrarcomuna($codigo, $nombre, $region, $provicia){
        $this->conexion();
        $sql = "insert into comunas values(null, '$codigo', '$nombre', $region, $provicia,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }
 
    //Listar Comunas por region
    public function listarcomuna($region){
        $this->conexion();
        $sql = "select comunas.id as id, comunas.codigo as codigo, comunas.nombre as nombre, regiones.nombre as region, provincias.nombre as provincia from comunas inner join regiones on comunas.region = regiones.id inner join provincias on comunas.provincia = provincias.id where comunas.region = $region order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $lista[] = $comuna;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Comunas por provincia
    public function listarcomunaprovicia($provincia){
        $this->conexion();
        $sql = "select * from comunas where provincia = $provincia order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id']; 
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $lista[] = $comuna;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Comunas
    public function buscarencomuna($id){
        $this->conexion();
        $sql = "select * from comunas where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $this->desconexion();
            return $comuna;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Comunas
    public function actualizarcomuna($id, $codigo, $nombre, $provincia){
        $this->conexion();
        $sql = "update comunas set  codigo = '$codigo', nombre = '$nombre' ,provincia = $provincia where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Comunas
    public function eliminarcomuna($id){
        $this->conexion();
        $sql = "delete from comunas where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Ciudades
    public function registraciudad($codigo, $nombre, $region, $provicia){
        $this->conexion();
        $sql = "insert into ciudades values(null, '$codigo', '$nombre', $region, $provicia,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Ciudades por region
    public function listarciudad($region){
        $this->conexion();
        $sql = "select * from ciudades where region = $region order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $ciudad = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $lista[] = $ciudad;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Ciudades por provincia
    public function listarciudadprovicia($provincia){
        $this->conexion();
        $sql = "select * from ciudades where provincia = $provincia order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id']; 
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $ciudad = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $lista[] = $ciudad;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Ciudades
    public function buscarenciudad($id){
        $this->conexion();
        $sql = "select * from ciudades where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provicia = $rs['provincia'];
            $ciudad = new Comunas($id, $codigo, $nombre, $region, $provicia);
            $this->desconexion();
            return $ciudad;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Ciudades
    public function actualizarciudad($id, $codigo, $nombre, $provincia){
        $this->conexion();
        $sql = "update ciudades set  codigo = '$codigo', nombre = '$nombre' , provincia = $provincia where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Ciudades
    public function eliminarciudad($id){
        $this->conexion();
        $sql = "delete from ciudades where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Nacionalidad
    public function registrarnacionalidad($codigo, $nombre){
        $this->conexion();
        $sql = "insert into nacionalidades values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //listar Nacionalidad
    public function listarnacionalidad(){
        $this->conexion();
        $sql = "select * from nacionalidades order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar paises
    public function listarpaises(){
        $this->conexion();
        $sql = "select * from paises order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Nacionalidad
    public function buscarenNacionalidad($id){
        $this->conexion();
        $sql = "select * from nacionalidades where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Paises
    public function buscarenPaises($id){
        $this->conexion();
        $sql = "select * from paises where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Nacionalidad
    public function actualizarnacionalidad($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update nacionalidades set  codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Nacionalidad
    public function eliminarnacionalidad($id){
        $this->conexion();
        $sql = "delete from nacionalidades where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Genero
    public function registrargenero($codigo, $nombre){
        $this->conexion();
        $sql = "insert into generos values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //listar Genero
    public function listargenero(){
        $this->conexion();
        $sql = "select * from generos";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Genero
    public function buscarenGenero($id){
        $this->conexion();
        $sql = "select * from generos where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Genero
    public function actualizargenero($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update generos set  codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result); 
    }

    //Eliminar Genero
    public function eliminargenero($id){
        $this->conexion();
        $sql = "delete from generos where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Especialidad
    public function registrarespecialidad($codigo, $nombre){
        $this->conexion();
        $sql = "insert into especialidades values(null, '$codigo', '$nombre',now())";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }
    
    //listar Especialidad
    public function listarespecialidad(){
        $this->conexion();
        $sql = "select * from especialidades order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Especialidad
    public function buscarenEspecialidad($id){
        $this->conexion();
        $sql = "select * from especialidades where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id, $codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Especialidad
    public function actualizarespecialidad($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update especialidades set  codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result); 
    }

    //Eliminar Especialidad
    public function eliminarespecialidad($id){
        $this->conexion();
        $sql = "delete from especialidades where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Servicio de proveniencia
    //Listar Servicio de proveniencia
    public function listarservicioproveniencia(){
        $this->conexion();
        $sql = "select * from servicioproveniencia order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Profesion
    public function registrarprofesion($codigo, $nombre, $especialidad){
        $this->conexion();
        $sql = "insert into profesiones values(null, '$codigo', '$nombre', $especialidad,now())";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //listar Profesion
    public function listarprofesion(){
        $this->conexion();
        $sql = "select * from profesiones order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $especialidad = $rs['especialidad'];
            $object = new Profesion($id, $codigo, $nombre, $especialidad);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar profesion por especialidad
    public function listarprofesionEspecialidad($especialidad){
        $this->conexion();
        $sql = "select * from profesiones where especialidad = $especialidad order by nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $especialidad = $rs['especialidad'];
            $object = new Profesion($id, $codigo, $nombre, $especialidad);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Lista de profesiones valores
    public function listarprofesionValores(){
        $this->conexion();
        $sql = "select profesiones.id as id, profesiones.codigo as codigo, profesiones.nombre as nombre, especialidades.nombre as especialidad from profesiones inner join especialidades on profesiones.especialidad = especialidades.id order by profesiones.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $especialidad = $rs['especialidad'];
            $object = new Profesion($id,$codigo, $nombre, $especialidad);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;

    }

    //Buscar Profesion
    public function buscarenProfesion($id){
        $this->conexion();
        $sql = "select * from profesiones where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $especialidad = $rs['especialidad'];
            $object = new Profesion($id, $codigo, $nombre, $especialidad);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Profesion
    public function actualizarprofesion($id, $codigo, $nombre, $especialidad){
        $this->conexion();
        $sql = "update profesiones set  codigo = '$codigo', nombre = '$nombre', especialidad = $especialidad where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result); 
    }

    //Eliminar Profesion
    public function eliminarprofesion($id){
        $this->conexion();
        $sql = "delete from profesiones where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Usuarios
    public function registrarusuario($rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $telefono, $contrasena){
        $this->conexion();
        $sql = "insert into usuarios values(null, '$rut', '$nombre', '$apellido1', '$apellido2', '$correo', '$direccion', $region, $comuna, '$telefono', sha1('$contrasena'),1, now())";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //UsuarioProfesion
    public function registrarusuarioprofesion($usuario, $profesion,$proveniencia,$empresa,$estado){
        $this->conexion();
        $sql = "insert into usuarioprofesion values(null, $usuario, $profesion, $proveniencia, $empresa,$estado, now())";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Validar Usuario
    public function validarusuario($rut, $correo){
        $this->conexion();
        $sql = "select * from usuarios where rut = '$rut' or correo = '$correo'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //Buscar Id Usuario
    public function buscaridusuario($rut, $correo){
        $this->conexion();
        $sql = "select * from usuarios where rut = '$rut' or correo = '$correo'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $this->desconexion();
            return $id;
        }
        $this->desconexion();
        return null;
    }

    //Validar Usuario 1
    public function validarusuario1($rut, $correo, $id){
        $this->conexion();
        $sql = "select * from usuarios where (rut = '$rut' or correo = '$correo') and id != $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //Validar Usuario Empresa
    public function validarusuarioempresa($usuario, $empresa){
        $this->conexion();
        $sql = "select * from usuarioprofesion where usuario = $usuario and empresa = $empresa";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //listar Usuarios
    public function listarusuario($empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.nombre as region, comunas.nombre as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, usuarioprofesion where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.empresa = $empresa order by usuarios.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Usuario
    public function buscarusuario($rut, $empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.id as region, comunas.id as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, usuarioprofesion where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.empresa = $empresa and usuarios.rut = '$rut'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }
    //Buscar Usuario
    public function buscarusuariobyRUT($rut){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.id as region, comunas.id as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, usuarioprofesion where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario  and usuarios.rut = '$rut'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Listar usuarios por profesion
    public function listarusuarioProfesion($profesion){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.nombre as region, comunas.nombre as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, usuarioprofesion where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = $profesion and usuarioprofesion.estado = 1 order by usuarios.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion, $proveniencia,$telefono, $contrasena, $registro, $estado);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar usuario Valores
    public function listarusuarioValores($empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.nombre as region, comunas.nombre as comuna, profesiones.nombre as profesion,servicioproveniencia.nombre as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarios.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, profesiones, usuarioprofesion, servicioproveniencia where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and usuarioprofesion.proveniencia = servicioproveniencia.id and usuarioprofesion.empresa = $empresa order by usuarios.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $lista[] = $object;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Usuario
    public function buscarenUsuario($id,$empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, usuarios.region as region, usuarios.comuna as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, usuarioprofesion where usuarios.id = usuarioprofesion.usuario and usuarios.id = $id and usuarioprofesion.empresa = $empresa";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion, $proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //buscar usuario 1
    public function buscarenUsuario1($id){
        $this->conexion();
        $sql = "select * from usuarios where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion ='';
            $proveniencia = '';
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = '';
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion, $proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Usuario por Rut
    public function buscarenUsuarioRut($rut,$empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, usuarios.region as region, usuarios.comuna as comuna, usuarioprofesion.profesion as profesion, usuarioprofesion.proveniencia as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarioprofesion.registro as registro, usuarioprofesion.estado as estado from usuarios, usuarioprofesion where usuarios.id = usuarioprofesion.usuario and usuarios.rut = '$rut' and usuarioprofesion.empresa = $empresa";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Usuario Valores
    public function buscarenUsuarioValores($id,$empresa){
        $this->conexion();
        $sql = "select usuarios.id as id, usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, usuarios.correo as correo, usuarios.direccion as direccion, regiones.nombre as region, comunas.nombre as comuna, profesiones.nombre as profesion, servicioproveniencia.nombre as proveniencia, usuarios.telefono as telefono, usuarios.contrasena as contrasena, usuarios.registro as registro, usuarioprofesion.estado as estado from usuarios, regiones, comunas, profesiones, usuarioprofesion, servicioproveniencia where usuarios.region = regiones.id and usuarios.comuna = comunas.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and usuarioprofesion.proveniencia = servicioproveniencia.id and usuarios.id = $id and usuarioprofesion.empresa = $empresa";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = $rs['profesion'];
            $proveniencia = $rs['proveniencia'];
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = $rs['estado'];
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Editar Usuario
    public function editarusuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $telefono){
        $this->conexion();
        $sql = "update usuarios set rut = '$rut', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', correo = '$correo', direccion = '$direccion', region = $region, comuna = $comuna, telefono = '$telefono' where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //function editar usuarioprofesion
    public function editarusuarioprofesion($usuario, $profesion, $proveniencia, $empresa){
        $this->conexion();
        $sql = "update usuarioprofesion set profesion = $profesion, proveniencia = $proveniencia where usuario = $usuario and empresa = $empresa";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }
    
    //Cambiar Contraseña
    public function cambiarcontrasena($id, $contrasena){
        $this->conexion();
        $sql = "update usuarios set contrasena = sha1('$contrasena') where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Cambiar Estado
    public function cambiarestado($id,$empresa, $estado){
        $this->conexion();
        $sql = "update usuarioprofesion set estado = $estado where usuario = $id and empresa = $empresa";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Usuario
    public function eliminarusuario($id){
        $this->conexion();
        $sql = "delete from usuarios where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }
    
    /************************************************************************************************************************************* */
    //Login
    public function login($user, $pass)
    {
        $this->conexion();
        $sql = "select * from usuarios where (rut = '$user' or correo = '$user') and contrasena = sha1('$pass');";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $correo = $rs['correo'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $profesion = '';
            $proveniencia = '';
            $telefono = $rs['telefono'];
            $contrasena = $rs['contrasena'];
            $registro = $rs['registro'];
            $estado = '';
            $object = new Usuario($id, $rut, $nombre, $apellido1, $apellido2, $correo, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $contrasena, $registro, $estado);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Cerrar Session
    public function crearsesion($usuario, $token)
    {
        $this->conexion();
        $sql = "delete from sesionusuario where usuario = $usuario";
        $result = $this->mi->query($sql);
        $sql = "insert into sesionusuario values(null, $usuario, '$token', now(), now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    public function validarsesion($usuario, $token)
    {
        $this->conexion();
        $sql = "select * from sesionusuario where usuario = $usuario and token = '$token'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconexion();
            return true;
        } else {
            $this->desconexion();
            return false;
        }
    }

    //Validar Permiso de Usuario
    public function validarPermiso($usuario, $permiso)
    {
        $this->conexion();
        $sql = "select * from permisosusuarios where idusuario = $usuario and idpermiso = $permiso";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }
/***************************************************************************************************************************************** */

    //Nombre de comite
    //Registrar Nombre de comite
    public function registrarnombrecomite($codigo,$nombre,$empresa){
        $this->conexion();
        $sql = "insert into nombrecomite values (null, '$codigo', '$nombre',$empresa,1,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Nombre de comite
    public function listarnombrecomite($empresa){
        $this->conexion();
        $sql = "select * from nombrecomite where empresa = $empresa order by nombre asc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $empresa = $rs['empresa'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Nombrecomite($id, $codigo, $nombre,$empresa, $estado, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Nombre de comite por ID
    public function buscarnombrecomiteID($id){
        $this->conexion();
        $sql = "select * from nombrecomite where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $empresa = $rs['empresa'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Nombrecomite($id, $codigo, $nombre,$empresa, $estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Nombre de comite por Codigo
    public function buscarnombrecomiteCodigo($codigo){
        $this->conexion();
        $sql = "select * from nombrecomite where codigo = '$codigo'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $empresa = $rs['empresa'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Nombrecomite($id, $codigo, $nombre, $empresa,$estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Editar Nombre de comite
    public function editarnombrecomite($id, $codigo, $nombre){
        $this->conexion();
        $sql = "update nombrecomite set codigo = '$codigo', nombre = '$nombre' where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Nombre de comite
    public function eliminarnombrecomite($id){
        $this->conexion();
        $sql = "delete from nombrecomite where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Desactivar Nombre de comite
    public function desactivarnombrecomite($id){
        $this->conexion();
        $sql = "update nombrecomite set estado = 2 where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Validar Nombre de comite
    public function validarnombrecomite($codigo){
        $this->conexion();
        $sql = "select estado from nombrecomite where codigo = '$codigo'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $estado = $rs['estado'];
            $this->desconexion();
            return $estado;
        }
        $this->desconexion();
        return false;
    }
    /************************************************************************************************************************************ */
    //Pacientes
    //Informacion Formulario pacientes
    //Listar tipo partos
    public function listartipoparto(){
        $this->conexion();
        $sql = "select * from tipopartos";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Prevision
    public function listarprevision(){
        $this->conexion();
        $sql = "select * from prevision";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Prevision
    public function buscarprevision($id){
        $this->conexion();
        $sql = "select * from prevision where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Listar tipo previsiones
    public function listartipoprevision($prevision){
        $this->conexion();
        $sql = "select * from tipoprevisiones where prevision = $prevision";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar tipo prevision
    public function buscartipoprevision($id){
        $this->conexion();
        $sql = "select * from tipoprevisiones where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $prevision = $rs['prevision'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$prevision,$nombre);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Listar tipo calle
    public function listartipocalle(){
        $this->conexion();
        $sql = "select * from tipocalle";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar pueblo originario
    public function listarpueblooriginario(){
        $this->conexion();
        $sql = "select * from pueblooriginarios";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Escolaridad
    public function listarescolaridad(){
        $this->conexion();
        $sql = "select * from escolaridad";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Situacion laboral
    public function listarsituacionlaboral(){
        $this->conexion();
        $sql = "select * from situacionlaboral";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Ocupacion
    public function listarocupacion(){
        $this->conexion();
        $sql = "select * from ocupaciones";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Relaciones
    public function listarrelaciones(){
        $this->conexion();
        $sql = "select * from relaciones";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Estado Civil
    public function listarestadocivil(){
        $this->conexion();
        $sql = "select * from estadocivil";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $object = new Objects($id,$codigo, $nombre);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar estado Civil
    public function buscarnombreestadocivil($id){
        $this->conexion();
        $sql = "select * from estadocivil where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $nombre = $rs['nombre'];
            $this->desconexion();
            return $nombre;
        }
        $this->desconexion();
        return null;
    }

    //Registrar Paciente
    public function registrarpaciente($tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario,$discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento,$estado){
        $this->conexion();
        $sql = "insert into pacientes values(null,$tipoidentificacion, '$rut', '$identificacion', $nacionalidad, $paisorigen, '$email', '$nombre', '$apellido1', '$apellido2', $genero,$estadocivil, '$fechanacimiento', '$horanacimiento', '$fonomovil', '$fonofijo', '$nombresocial', $funcionario,$discapacidad, $reciennacido, '$hijode', $pesodenacimiento, $tallanacimiento, $tipoparto, '$rol', '$fechafallecimiento', '$horafaallecimiento',$estado,now())";
        //Registrar y retornar id
        $this->mi->query($sql);
        $id = mysqli_insert_id($this->mi);
        $this->desconexion();
        return $id;
    }

    

    //Listar Pacientes
    public function listarpacientes(){
        $this->conexion();
        $sql = "select * from pacientes order by nombre asc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $tipoidentificacion = $rs['tipoidentificacion'];
            $rut = $rs['rut'];
            $identificacion = $rs['identificacion'];
            $nacionalidad = $rs['nacionalidad'];
            $paisorigen = $rs['paisorigen'];
            $email = $rs['email'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $genero = $rs['genero'];
            $estadocivil = $rs['estadocivil'];
            $fechanacimiento = $rs['fechanacimiento'];
            $horanacimiento = $rs['horanacimiento'];
            $fonomovil = $rs['fonomovil'];
            $fonofijo = $rs['fonofijo'];
            $nombresocial = $rs['nombresocial'];
            $funcionario = $rs['funcionario'];
            $discapacidad = $rs['discapacidad'];
            $reciennacido = $rs['reciennacido'];
            $hijode = $rs['hijode'];
            $pesodenacimiento = $rs['pesodenacimiento'];
            $tallanacimiento = $rs['tallanacimiento'];
            $tipoparto = $rs['tipoparto'];
            $rol = $rs['rol'];
            $fechafallecimiento = $rs['fechafallecimiento'];
            $horafaallecimiento = $rs['horafaallecimiento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $paciente = new Paciente($id, $tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario, $discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento, $estado, $registro);
            array_push($array, $paciente);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar paciente por rut
    public function buscarpacienterut($rut){
        $this->conexion();
        $sql = "select * from pacientes where rut = '$rut'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $tipoidentificacion = $rs['tipoidentificacion'];
            $rut = $rs['rut'];
            $identificacion = $rs['identificacion'];
            $nacionalidad = $rs['nacionalidad'];
            $paisorigen = $rs['paisorigen'];
            $email = $rs['email'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $genero = $rs['genero'];
            $estadocivil = $rs['estadocivil'];
            $fechanacimiento = $rs['fechanacimiento'];
            $horanacimiento = $rs['horanacimiento'];
            $fonomovil = $rs['fonomovil'];
            $fonofijo = $rs['fonofijo'];
            $nombresocial = $rs['nombresocial'];
            $funcionario = $rs['funcionario'];
            $discapacidad = $rs['discapacidad'];
            $reciennacido = $rs['reciennacido'];
            $hijode = $rs['hijode'];
            $pesodenacimiento = $rs['pesodenacimiento'];
            $tallanacimiento = $rs['tallanacimiento'];
            $tipoparto = $rs['tipoparto'];
            $rol = $rs['rol'];
            $fechafallecimiento = $rs['fechafallecimiento'];
            $horafaallecimiento = $rs['horafaallecimiento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $paciente = new Paciente($id, $tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario, $discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento, $estado, $registro);
            $this->desconexion();
            return $paciente;
        }
        $this->desconexion();
        return null;
    }
    
    //Buscar paciente por rut
    public function buscarpacienterut1($rut){
        $this->conexion();
        $sql = "select * from pacientes where rut = '$rut'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $pacientes = array("id"=>$rs['id'],"tipoidentificacion"=>$rs['tipoidentificacion'],"rut"=>$rs['rut'],"identificacion"=>$rs['identificacion'],"nacionalidad"=>$rs['nacionalidad'],"paisorigen"=>$rs['paisorigen'],"email"=>$rs['email'],"nombre"=>$rs['nombre'],"apellido1"=>$rs['apellido1'],"apellido2"=>$rs['apellido2'],"genero"=>$rs['genero'],"estadocivil"=>$rs['estadocivil'],"fechanacimiento"=>$rs['fechanacimiento'],"horanacimiento"=>$rs['horanacimiento'],"fonomovil"=>$rs['fonomovil'],"fonofijo"=>$rs['fonofijo'],"nombresocial"=>$rs['nombresocial'],"funcionario"=>$rs['funcionario'],"discapacidad"=>$rs['discapacidad'],"reciennacido"=>$rs['reciennacido'],"hijode"=>$rs['hijode'],"pesodenacimiento"=>$rs['pesodenacimiento'],"tallanacimiento"=>$rs['tallanacimiento'],"tipoparto"=>$rs['tipoparto'],"rol"=>$rs['rol'],"fechafallecimiento"=>$rs['fechafallecimiento'],"horafaallecimiento"=>$rs['horafaallecimiento'],"estado"=>$rs['estado'],"registro"=>$rs['registro']);
            $this->desconexion();
            return $pacientes;
        }
        $this->desconexion();
        return null;
    }

    //Buscar paciente por identificacion
    public function buscarpacienteidentificacion($identificacion){
        $this->conexion();
        $sql = "select * from pacientes where identificacion = '$identificacion'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $tipoidentificacion = $rs['tipoidentificacion'];
            $rut = $rs['rut'];
            $identificacion = $rs['identificacion'];
            $nacionalidad = $rs['nacionalidad'];
            $paisorigen = $rs['paisorigen'];
            $email = $rs['email'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $genero = $rs['genero'];
            $estadocivil = $rs['estadocivil'];
            $fechanacimiento = $rs['fechanacimiento'];
            $horanacimiento = $rs['horanacimiento'];
            $fonomovil = $rs['fonomovil'];
            $fonofijo = $rs['fonofijo'];
            $nombresocial = $rs['nombresocial'];
            $funcionario = $rs['funcionario'];
            $discapacidad = $rs['discapacidad'];
            $reciennacido = $rs['reciennacido'];
            $hijode = $rs['hijode'];
            $pesodenacimiento = $rs['pesodenacimiento'];
            $tallanacimiento = $rs['tallanacimiento'];
            $tipoparto = $rs['tipoparto'];
            $rol = $rs['rol'];
            $fechafallecimiento = $rs['fechafallecimiento'];
            $horafaallecimiento = $rs['horafaallecimiento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $paciente = new Paciente($id, $tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario, $discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento, $estado, $registro);
            $this->desconexion();
            return $paciente;
        }
        $this->desconexion();
        return null;
    }

    //Buscar paciente por identificacion
    public function buscarpacienteidentificacion1($identificacion){
        $this->conexion();
        $sql = "select * from pacientes where identificacion = '$identificacion'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $pacientes = array("id"=>$rs['id'],"tipoidentificacion"=>$rs['tipoidentificacion'],"rut"=>$rs['rut'],"identificacion"=>$rs['identificacion'],"nacionalidad"=>$rs['nacionalidad'],"paisorigen"=>$rs['paisorigen'],"email"=>$rs['email'],"nombre"=>$rs['nombre'],"apellido1"=>$rs['apellido1'],"apellido2"=>$rs['apellido2'],"genero"=>$rs['genero'],"estadocivil"=>$rs['estadocivil'],"fechanacimiento"=>$rs['fechanacimiento'],"horanacimiento"=>$rs['horanacimiento'],"fonomovil"=>$rs['fonomovil'],"fonofijo"=>$rs['fonofijo'],"nombresocial"=>$rs['nombresocial'],"funcionario"=>$rs['funcionario'],"discapacidad"=>$rs['discapacidad'],"reciennacido"=>$rs['reciennacido'],"hijode"=>$rs['hijode'],"pesodenacimiento"=>$rs['pesodenacimiento'],"tallanacimiento"=>$rs['tallanacimiento'],"tipoparto"=>$rs['tipoparto'],"rol"=>$rs['rol'],"fechafallecimiento"=>$rs['fechafallecimiento'],"horafaallecimiento"=>$rs['horafaallecimiento'],"estado"=>$rs['estado'],"registro"=>$rs['registro']);
            $this->desconexion();
            return $pacientes;
        }
        $this->desconexion();
        return null;
    }

    //Listar los rut de los pacientes
    public function listarrutpacientes(){
        $this->conexion();
        $sql = "select rut from pacientes order by nombre asc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $rut = $rs['rut'];
            array_push($array, $rut);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Paciente
    public function buscarpaciente($id){
        $this->conexion();
        $sql = "select * from pacientes where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $tipoidentificacion = $rs['tipoidentificacion'];
            $rut = $rs['rut'];
            $identificacion = $rs['identificacion'];
            $nacionalidad = $rs['nacionalidad'];
            $paisorigen = $rs['paisorigen'];
            $email = $rs['email'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['apellido1'];
            $apellido2 = $rs['apellido2'];
            $genero = $rs['genero'];
            $estadocivil = $rs['estadocivil'];
            $fechanacimiento = $rs['fechanacimiento'];
            $horanacimiento = $rs['horanacimiento'];
            $fonomovil = $rs['fonomovil'];
            $fonofijo = $rs['fonofijo'];
            $nombresocial = $rs['nombresocial'];
            $funcionario = $rs['funcionario'];
            $discapacidad = $rs['discapacidad'];
            $reciennacido = $rs['reciennacido'];
            $hijode = $rs['hijode'];
            $pesodenacimiento = $rs['pesodenacimiento'];
            $tallanacimiento = $rs['tallanacimiento'];
            $tipoparto = $rs['tipoparto'];
            $rol = $rs['rol'];
            $fechafallecimiento = $rs['fechafallecimiento'];
            $horafaallecimiento = $rs['horafaallecimiento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $paciente = new Paciente($id, $tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario, $discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento, $estado, $registro);
            $this->desconexion();
            return $paciente;
        }
        $this->desconexion();   
        return null;
    }

    //Actualizar Paciente
    public function actualizarpaciente($id,$tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario,$discapacidad, $reciennacido, $hijode, $pesodenacimiento, $tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafaallecimiento){
        $this->conexion();
        $sql = "update pacientes set tipoidentificacion = $tipoidentificacion, rut = '$rut', identificacion = '$identificacion', nacionalidad = $nacionalidad, paisorigen = $paisorigen, email = '$email', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', genero = $genero, estadocivil = $estadocivil, fechanacimiento = '$fechanacimiento', horanacimiento = '$horanacimiento', fonomovil = '$fonomovil', fonofijo = '$fonofijo', nombresocial = '$nombresocial', funcionario = $funcionario, discapacidad = $discapacidad, reciennacido = $reciennacido, hijode = '$hijode', pesodenacimiento = $pesodenacimiento, tallanacimiento = $tallanacimiento, tipoparto = $tipoparto, rol = '$rol', fechafallecimiento = '$fechafallecimiento', horafaallecimiento = '$horafaallecimiento' where id = $id";
        $result = $this->mi->query($sql); 
        $this->desconexion();
        return json_encode($result);
    }

    //Validar Rut paciente
    public function validarrutpaciente($rut){
        $this->conexion();
        $sql = "select * from pacientes where rut = '$rut'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //Validar Rut paciente por ID
    public function validarrutpacienteID($id, $rut){
        $this->conexion();
        $sql = "select * from pacientes where rut = '$rut' and id != $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //Validar Identificacion paciente
    public function validaridentificacionpaciente($identificacion){
        $this->conexion();
        $sql = "select * from pacientes where identificacion = '$identificacion'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $this->desconexion();
            return true;
        }else{
            $this->desconexion();
            return false;
        }
    }

    //Registrar Inscipcion prevision
    public function registrarinscripcionprevision($paciente, $ficha, $fechaadmision, $familia, $inscrito, $sector, $tipoprevision, $estadoafiliar, $chilesolidario, $prais, $sename, $ubicacionficha, $saludmental){
        $this->conexion();
        $sql = "insert into inscripcionprevision values (null,$paciente, '$ficha', '$fechaadmision', '$familia', '$inscrito', '$sector', $tipoprevision, $estadoafiliar, $chilesolidario, $prais, $sename, '$ubicacionficha', $saludmental,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Listar Inscipcion prevision
    //id	paciente	ficha	fechaadmision	familia	inscrito	sector	tipoprevision	estadoafiliar	chilesolidario	prais	sename	ubicacionficha	saludmental	registro	
    public function listarinscripcionprevision($paciente){
        $this->conexion();
        $sql = "select * from inscripcionprevision where paciente = $paciente";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $paciente = $rs['paciente'];
            $ficha = $rs['ficha'];
            $fechaadmision = $rs['fechaadmision'];
            $familia = $rs['familia'];
            $inscrito = $rs['inscrito'];
            $sector = $rs['sector'];
            $tipoprevision = $rs['tipoprevision'];
            $estadoafiliar = $rs['estadoafiliar'];
            $chilesolidario = $rs['chilesolidario'];
            $prais = $rs['prais'];
            $sename = $rs['sename'];
            $ubicacionficha = $rs['ubicacionficha'];
            $saludmental = $rs['saludmental'];
            $registro = $rs['registro'];
            $object = new Inscripcion($id, $paciente, $ficha, $fechaadmision, $familia, $inscrito, $sector, $tipoprevision, $estadoafiliar, $chilesolidario, $prais, $sename, $ubicacionficha, $saludmental, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //actualizar Inscipcion prevision
    public function actualizarinscripcionprevision($id, $paciente, $ficha, $fechaadmision, $familia, $inscrito, $sector, $tipoprevision, $estadoafiliar, $chilesolidario, $prais, $sename, $ubicacionficha, $saludmental){
        $this->conexion();
        $sql = "update inscripcionprevision set paciente = $paciente, ficha = '$ficha', fechaadmision = '$fechaadmision', familia = '$familia', inscrito = '$inscrito', sector = '$sector', tipoprevision = $tipoprevision, estadoafiliar = $estadoafiliar, chilesolidario = $chilesolidario, prais = $prais, sename = $sename, ubicacionficha = '$ubicacionficha', saludmental = $saludmental where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Registrar Datos de Ubicacion
    public function registrardatosubicacion($paciente, $region, $provincia, $comuna, $ciudad, $tipocalle, $nombrecalle, $numerocalle, $restodireccion){
        $this->conexion();
        $sql = "insert into datosubicacion (paciente, region, provincia, comuna, ciudad, tipocalle, nombrecalle, numerocalle, restodireccion) values ($paciente, $region, $provincia, $comuna, $ciudad, $tipocalle, '$nombrecalle', '$numerocalle', '$restodireccion')";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Listar Datos de Ubicacion
    //id	paciente	region	provincia	comuna	ciudad	tipocalle	nombrecalle	numerocalle	restodireccion	registro	
    public function listardatosubicacion($paciente){
        $this->conexion();
        $sql = "select * from datosubicacion where paciente = $paciente";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $paciente = $rs['paciente'];
            $region = $rs['region'];
            $provincia = $rs['provincia'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $tipocalle = $rs['tipocalle'];
            $nombrecalle = $rs['nombrecalle'];
            $numerocalle = $rs['numerocalle'];
            $restodireccion = $rs['restodireccion'];
            $registro = $rs['registro'];
            $object = new Datosubicacion($id, $paciente, $region, $provincia, $comuna, $ciudad, $tipocalle, $nombrecalle, $numerocalle, $restodireccion, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Datos de Ubicacion
    public function actualizardatosubicacion($id, $paciente, $region, $provincia, $comuna, $ciudad, $tipocalle, $nombrecalle, $numerocalle, $restodireccion){
        $this->conexion();
        $sql = "update datosubicacion set paciente = $paciente, region = $region, provincia = $provincia, comuna = $comuna, ciudad = $ciudad, tipocalle = $tipocalle, nombrecalle = '$nombrecalle', numerocalle = '$numerocalle', restodireccion = '$restodireccion' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Registrar otros antecedentes
    public function registrarotrosantecedentes($paciente, $pueblooriginario, $escolaridad, $cursorepite, $situacionlaboral, $ocupacion){
        $this->conexion();
        $sql = "insert into otrosantecedentes values (null,$paciente, $pueblooriginario, $escolaridad, '$cursorepite', $situacionlaboral, $ocupacion,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Listar otros antecedentes
    //id	paciente	pueblooriginario	escolaridad	cursorepite	situacionlaboral	ocupacion	registro
    public function listarotrosantecedentes($paciente){
        $this->conexion();
        $sql = "select * from otrosantecedentes where paciente = $paciente";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $paciente = $rs['paciente'];
            $pueblooriginario = $rs['pueblooriginario'];
            $escolaridad = $rs['escolaridad'];
            $cursorepite = $rs['cursorepite'];
            $situacionlaboral = $rs['situacionlaboral'];
            $ocupacion = $rs['ocupacion'];
            $registro = $rs['registro'];
            $object = new Otrosantecedentes($id, $paciente, $pueblooriginario, $escolaridad, $cursorepite, $situacionlaboral, $ocupacion, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar otros antecedentes
    public function actualizarotrosantecedentes($id, $paciente, $pueblooriginario, $escolaridad, $cursorepite, $situacionlaboral, $ocupacion){
        $this->conexion();
        $sql = "update otrosantecedentes set paciente = $paciente, pueblooriginario = $pueblooriginario, escolaridad = $escolaridad, cursorepite = '$cursorepite', situacionlaboral = $situacionlaboral, ocupacion = $ocupacion where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Registrar Persona Responsable
    //id	paciente	rut	nombre	relacion	telefono	direccion	registro	
    public function registrarresponsable($paciente, $rut, $nombre, $relacion, $telefono, $direccion){
        $this->conexion();
        $sql = "insert into personaresponsable values (null,$paciente, '$rut', '$nombre', $relacion, '$telefono', '$direccion',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Listar Persona Responsable
    //id	paciente	rut	nombre	relacion	telefono	direccion	registro	
    public function listarresponsable($paciente){
        $this->conexion();
        $sql = "select * from personaresponsable where paciente = $paciente";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $paciente = $rs['paciente'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $relacion = $rs['relacion'];
            $telefono = $rs['telefono'];
            $direccion = $rs['direccion'];
            $registro = $rs['registro'];
            $object = new Responsable($id, $paciente, $rut, $nombre, $relacion, $telefono, $direccion, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Actualizar Persona Responsable
    public function actualizarresponsable($id, $paciente, $rut, $nombre, $relacion, $telefono, $direccion){
        $this->conexion();
        $sql = "update personaresponsable set paciente = $paciente, rut = '$rut', nombre = '$nombre', relacion = $relacion, telefono = '$telefono', direccion = '$direccion' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    

    /************************************************************************************************************************************* */
    //Comite
    //Validar Folio
    public function validarfolio($folio){
        $this->conexion();
        $sql = "select * from comite where folio = '$folio'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }

    //EL ultimo folio
    public function ultimofoliocomite(){
        $this->conexion();
        $sql = "select folio from comite order by id desc limit 1";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $folio = $rs['folio'];
            $this->desconexion();
            return $folio;
        }
        $this->desconexion();
        return null;
    }

    //Registrar Comite
    public function registrarcomite($folio,$fecha,$nombre){
        $this->conexion();
        $sql = "insert into comite values (null, '$folio','$fecha', $nombre,1, now())";
        //Registrar y retornar id
        $this->mi->query($sql);
        $id = mysqli_insert_id($this->mi);
        $this->desconexion();
        return $id;
    }

    //finalizarComite
    public function finalizarcomite($id){
        $this->conexion();
        $sql = "update comite set estado = 2 where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Habilitar Comite
    public function habilitarcomite($id){
        $this->conexion();
        $sql = "update comite set estado = 1 where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Buscar el ultimo folio del comite por el nombre
    public function buscarultimofoliocomite($nombre){
        $this->conexion();
        $sql = "select folio from comite where nombrecomite = $nombre order by id desc limit 1";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $folio = $rs['folio'];
            $this->desconexion();
            return $folio;
        }
        $this->desconexion();
        return 0;
    }

    //Listar Comite
    public function listarcomiteactivo(){
        $this->conexion();
        $sql = "select * from comite where estado = 1";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombrecomite'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Comite inactivo
    public function listarcomiteinactivo(){
        $this->conexion();
        $sql = "select * from comite where estado = 2";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombrecomite'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar Comite valores
    public function listarcomitevaloresactivo($empresa){
        $this->conexion();
        $sql = "select comite.id as id, comite.folio as folio, comite.fecha as fecha, nombrecomite.nombre as nombre, comite.estado as estado, comite.registro as registro from comite inner join nombrecomite on comite.nombrecomite = nombrecomite.id where comite.estado = 1 and nombrecomite.empresa = $empresa";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombre'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    
    //Listar Comite valores
    public function listarcomitevaloresinactivo($empresa){
        $this->conexion();
        $sql = "select comite.id as id, comite.folio as folio, comite.fecha as fecha, nombrecomite.nombre as nombre, comite.estado as estado, comite.registro as registro from comite inner join nombrecomite on comite.nombrecomite = nombrecomite.id where comite.estado = 2 and nombrecomite.empresa = $empresa";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombre'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }


    //Buscar Comite por ID
    public function buscarcomiteID($id){
        $this->conexion();
        $sql = "select * from comite where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombrecomite'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar COmite por ID valores
    public function buscarcomiteIDvalores($id){
        $this->conexion();
        $sql = "select comite.id as id, comite.folio as folio, comite.fecha as fecha,comite.nombrecomite as idnombre, nombrecomite.nombre as nombre, comite.estado as estado, comite.registro as registro from comite inner join nombrecomite on comite.nombrecomite = nombrecomite.id where comite.id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombre'];
            $estado = $rs['estado'];
            $registro = $rs['idnombre'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Comite por Folio
    public function buscarcomiteFolio($folio){
        $this->conexion();
        $sql = "select * from comite where folio = '$folio'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombrecomite'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Comite por Folio valores
    public function buscarcomiteFoliovalores($folio){
        $this->conexion();
        $sql = "select comite.id as id, comite.folio as folio, comite.fecha as fecha, nombrecomite.nombre as nombre, comite.estado as estado, comite.registro as registro from comite inner join nombrecomite on comite.nombrecomite = nombrecomite.id where comite.folio = '$folio'";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){ 
            $id = $rs['id'];
            $folio = $rs['folio'];
            $fecha = $rs['fecha'];
            $nombre = $rs['nombre'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $object = new Comite($id, $folio, $fecha, $nombre, $estado, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Profesionales Comite
    //Registrar Profesionales Comite
    public function registrarprofesionalescomite($idcomite, $idprofesional){
        $this->conexion();
        $sql = "insert into profesionalescomite values(null,$idcomite, $idprofesional,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Validar Profesionales Comite
    public function validarprofesionalescomite($idcomite, $idprofesional){
        $this->conexion();
        $sql = "select * from profesionalescomite where comite = $idcomite and profesional = $idprofesional";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }

    //Eliminar Profesionales Comite
    public function eliminarprofesionalescomite($idcomite){
        $this->conexion();
        $sql = "delete from profesionalescomite where id = $idcomite;";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Buscar Profesionales Comite
    public function buscarprofesionalescomite($idcomite,$empresa){
        $this->conexion();
        $sql = "select profesionalescomite.id as id,usuarios.rut as rut, usuarios.nombre as nombre, usuarios.apellido1 as apellido1, usuarios.apellido2 as apellido2, profesionalescomite.profesional as profesional, profesionalescomite.registro, profesiones.nombre as profesion from profesionalescomite, usuarios, profesiones,usuarioprofesion where profesionalescomite.profesional = usuarios.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and profesionalescomite.comite = $idcomite and usuarioprofesion.empresa = $empresa";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $profesion = $rs['profesion'];
            $idcomite = $rs['profesional'];
            $registro = $rs['registro'];
            $object = new Profesionalcomite($id, $rut, $nombre, $profesion, $idcomite, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }


    //Pacientes Comite
    //Registrar Pacientes Comite
    public function registrarpacientescomite($idcomite, $idpaciente, $profesional, $observacion){
        $this->conexion();
        $sql = "insert into pacientescomite values(null, $idcomite, $idpaciente, $profesional, '$observacion',now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Validar Pacientes Comite
    public function validarpacientescomite($idcomite, $idpaciente){
        $this->conexion();
        $sql = "select * from pacientescomite where comite = $idcomite and paciente = $idpaciente";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $this->desconexion();
            return $id;
        }
        $this->desconexion();
        return false;
    }

    //Actualizar Pacientes Comite
    public function actualizarpacientescomite($id, $profesional, $observacion){
        $this->conexion();
        $sql = "update pacientescomite set profesionalresponsable = $profesional, observacion = '$observacion' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Eliminar Pacientes Comite
    public function eliminarpacientescomite($id){
        $this->conexion();
        $sql = "delete from pacientescomite where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return $result;
    }

    //Buscar Pacientes Comite
    public function buscarpacientescomite($idcomite){
        $this->conexion();
        $sql = "select pacientescomite.id as id, comite,pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, pacientescomite.paciente as paciente, pacientes.fonomovil, usuarios.nombre as usuarionombre, usuarios.apellido1 as usuarioapellido1, usuarios.apellido2 as usuarioapellido2, usuarios.id as usuarioid, observacion, pacientescomite.registro as registro from pacientescomite inner join pacientes on pacientescomite.paciente = pacientes.id inner join usuarios on pacientescomite.profesionalresponsable = usuarios.id where comite= $idcomite";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fonomovil = $rs['fonomovil'];
            $usuarionombre = $rs['usuarionombre'] . " " . $rs['usuarioapellido1'] . " " . $rs['usuarioapellido2'];
            $usuarioid = $rs['usuarioid'];
            $observacion = $rs['observacion'];
            $idcomite = $rs['paciente'];
            $registro = $rs['registro'];
            $object = new Pacientecomite($id, $rut, $nombre, $fonomovil, $usuarioid,$usuarionombre,  $observacion, $idcomite);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Paciente Comite por ID
    public function buscarpacientecomite($id){
        $this->conexion();
        $sql = "select pacientescomite.id as id, comite,pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, pacientescomite.paciente as paciente, pacientes.fonomovil, usuarios.nombre as usuarionombre, usuarios.apellido1 as usuarioapellido1, usuarios.apellido2 as usuarioapellido2, usuarios.id as usuarioid, comite, pacientescomite.registro as registro from pacientescomite inner join pacientes on pacientescomite.paciente = pacientes.id inner join usuarios on pacientescomite.profesionalresponsable = usuarios.id where pacientescomite.id= $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fonomovil = $rs['fonomovil'];
            $usuarionombre = $rs['usuarionombre'] . " " . $rs['usuarioapellido1'] . " " . $rs['usuarioapellido2'];
            $usuarioid = $rs['usuarioid'];
            $observacion = $rs['comite'];
            $idcomite = $rs['paciente'];
            $registro = $rs['registro'];
            $object = new Pacientecomite($id, $rut, $nombre, $fonomovil, $usuarioid,$usuarionombre,  $observacion, $idcomite);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Buscar Paciente Comite por ID
    public function buscarpacientecomiteval($paciente, $comite){
        $this->conexion();
        $sql = "select pacientescomite.id as id, comite,pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, pacientescomite.paciente as paciente, pacientes.fonomovil, usuarios.nombre as usuarionombre, usuarios.apellido1 as usuarioapellido1, usuarios.apellido2 as usuarioapellido2, usuarios.id as usuarioid, comite, pacientescomite.registro as registro from pacientescomite inner join pacientes on pacientescomite.paciente = pacientes.id inner join usuarios on pacientescomite.profesionalresponsable = usuarios.id where pacientescomite.paciente= $paciente and comite = $comite";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fonomovil = $rs['fonomovil'];
            $usuarionombre = $rs['usuarionombre'] . " " . $rs['usuarioapellido1'] . " " . $rs['usuarioapellido2'];
            $usuarioid = $rs['usuarioid'];
            $observacion = $rs['comite'];
            $idcomite = $rs['paciente'];
            $registro = $rs['registro'];
            $object = new Pacientecomite($id, $rut, $nombre, $fonomovil, $usuarioid,$usuarionombre,  $observacion, $idcomite);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    /********************************************** */
    //Signos vitales
    //Registrar Signos Vitales
    function registrarsignos($paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso){
        $this->conexion();
        $sql = "insert into signosvitales values(null, $paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso, now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Signos vitales
    function listarsignosvitales($paciente){
        $this->conexion();
        $sql = "select * from signosvitales where paciente = $paciente order by registro desc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $fresp = $rs["fresp"];
            $psist = $rs["psist"];
            $pdias = $rs["pdias"];
            $sat02 = $rs["sat02"];
            $fc = $rs["fc"];
            $tauxiliar = $rs["tauxiliar"];
            $trect = $rs["trect"];
            $totra = $rs["totra"];
            $hgt = $rs["hgt"];
            $peso = $rs["peso"];
            $registro = $rs["registro"];
            $object = new Signosvital($id, $paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar los ultimos 5 signos vitales
    function listarsignosvitales5($paciente){
        $this->conexion();
        $sql = "select * from signosvitales where paciente = $paciente order by registro desc limit 5";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $fresp = $rs["fresp"];
            $psist = $rs["psist"];
            $pdias = $rs["pdias"];
            $sat02 = $rs["sat02"];
            $fc = $rs["fc"];
            $tauxiliar = $rs["tauxiliar"];
            $trect = $rs["trect"];
            $totra = $rs["totra"];
            $hgt = $rs["hgt"];
            $peso = $rs["peso"];
            $registro = $rs["registro"];
            $object = new Signosvital($id, $paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Ultimo Signo Vital
    function buscarsignovital($paciente){
        $this->conexion();
        $sql = "select * from signosvitales where paciente = $paciente order by registro desc limit 1";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $fresp = $rs["fresp"];
            $psist = $rs["psist"];
            $pdias = $rs["pdias"];
            $sat02 = $rs["sat02"];
            $fc = $rs["fc"];
            $tauxiliar = $rs["tauxiliar"];
            $trect = $rs["trect"];
            $totra = $rs["totra"];
            $hgt = $rs["hgt"];
            $peso = $rs["peso"];
            $registro = $rs["registro"];
            $object = new Signosvital($id, $paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    /************************************************* */
    //Medidas antropometricas
    //Registrar Medidas Antropometricas
    function registrarmedidas($paciente, $peso, $estatura, $pcee, $pe, $pt,$te, $imc, $clasifimc, $pce, $clasifpcintura){
        $this->conexion();
        $sql = "insert into medidasantropometricas values(null, $paciente, $peso, $estatura, $pcee, $pe, $pt,$te, $imc, $clasifimc, $pce, $clasifpcintura, now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Medidas Antropometricas
    function listarmedidasantropometricas($paciente){
        $this->conexion();
        $sql = "select * from medidasantropometricas where paciente = $paciente order by registro desc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $peso = $rs["peso"];
            $estatura = $rs["talla"];
            $pcee = $rs["pcee"];
            $pe = $rs["pe"];
            $pt = $rs["pt"];
            $te = $rs["te"];
            $imc = $rs["imc"];
            $clasifimc = $rs["clasifimc"];
            $pce = $rs["pce"];
            $clasifpcintura = $rs["clasificacioncintura"];
            $registro = $rs["registro"];
            $object = new Medidas($id, $paciente, $peso, $estatura, $pcee, $pe, $pt,$te, $imc, $clasifimc, $pce, $clasifpcintura, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Listar las ultimas 5 medidas antropometricas
    function listarmedidasantropometricas5($paciente){
        $this->conexion();
        $sql = "select * from medidasantropometricas where paciente = $paciente order by registro desc limit 5";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $peso = $rs["peso"];
            $estatura = $rs["talla"];
            $pcee = $rs["pcee"];
            $pe = $rs["pe"];
            $pt = $rs["pt"];
            $te = $rs["te"];
            $imc = $rs["imc"];
            $clasifimc = $rs["clasifimc"];
            $pce = $rs["pce"];
            $clasifpcintura = $rs["clasificacioncintura"];
            $registro = $rs["registro"];
            $object = new Medidas($id, $paciente, $peso, $estatura, $pcee, $pe, $pt,$te, $imc, $clasifimc, $pce, $clasifpcintura, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar Ultima Medida Antropometrica
    function buscarmedidaantropometrica($paciente){
        $this->conexion();
        $sql = "select * from medidasantropometricas where paciente = $paciente order by registro desc limit 1";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $peso = $rs["peso"];
            $estatura = $rs["talla"];
            $pcee = $rs["pcee"];
            $pe = $rs["pe"];
            $pt = $rs["pt"];
            $te = $rs["te"];
            $imc = $rs["imc"];
            $clasifimc = $rs["clasifimc"];
            $pce = $rs["pce"];
            $clasifpcintura = $rs["clasificacioncintura"];
            $registro = $rs["registro"];
            $object = new Medidas($id, $paciente, $peso, $estatura, $pcee, $pe, $pt,$te, $imc, $clasifimc, $pce, $clasifpcintura, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    //Informe Comité
    //Registrar informecomite diagnostico
    function registrarcomitediagnostico($diagnosticos, $diagnosticosid, $diagnosticocieotoptext, $diagnosticocieotopid, $diagnosticocieomortext, $diagnosticocieomorid, $diagnosticocie10text, $diagnosticocie10id, $fechabiopsia, $reingreso){
        $this->conexion();
        //Registrar y devolver el id del informe comite diagnostico
        $sql = "insert into informecomitediagnostico values(null, '$diagnosticos', $diagnosticosid, '$diagnosticocieotoptext', $diagnosticocieotopid, '$diagnosticocieomortext', $diagnosticocieomorid, '$diagnosticocie10text', $diagnosticocie10id, '$fechabiopsia', $reingreso, now())";
        $this->mi->query($sql);
        $id = $this->mi->insert_id;
        $this->desconexion();
        return $id;        
    }

    //Listar informecomite diagnostico
    function listardiagnosticoscomite($paciente){
        $this->conexion();
        $sql = "select * from informecomitediagnostico where paciente = $paciente order by registro desc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $diagnosticos = $rs["diagnosticos"];
            $diagnosticosid = $rs["diagnosticosid"];
            $diagnosticocieotoptext = $rs["diagnosticocieotop"];
            $diagnosticocieotopid = $rs["diagnosticocieotopid"];
            $diagnosticocieomortext = $rs["diagnosticocieomor"];
            $diagnosticocieomorid = $rs["diagnosticocieomorid"];
            $diagnosticocie10text = $rs["diagnosticocie10"];
            $diagnosticocie10id = $rs["diagnosticocie10id"];
            $fechabiopsia = $rs["fechabiopsia"];
            $reingreso = $rs["reingreso"];
            $registro = $rs["registro"];
            $object = new PacienteDiagnosticos($id, $diagnosticos, $diagnosticosid, $diagnosticocieotoptext, $diagnosticocieotopid, $diagnosticocieomortext, $diagnosticocieomorid, $diagnosticocie10text, $diagnosticocie10id, $fechabiopsia, $reingreso, $registro);
            array_push($array, $object);
        }
        $this->desconexion();
        return $array;
    }

    

    //Registrar informecomite
    function registrarinformecomite($paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, $tnmprimario, $tnmprimarioid, $observacionprimario, $tnmregionales, $tnmregionalesid, $observacionregionales, $tnmdistancia, $tnmdistanciaid, $observaciondistancia, $anamesis, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $resolucion){
        $this->conexion();
        $sql = "insert into informecomite values(null, $paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, '$tnmprimario', $tnmprimarioid, '$observacionprimario', '$tnmregionales', $tnmregionalesid, '$observacionregionales', '$tnmdistancia', $tnmdistanciaid, '$observaciondistancia', '$anamesis', $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, '$observaciondesicion', '$consultade', $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, '$observacionplan', '$resolucion', now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Informe Comite
    function listainformecomite($paciente, $comite){
        $this->conexion();
        $sql = "select * from informecomite where paciente = $paciente and comite = $comite order by registro desc";
        $result = $this->mi->query($sql);
        $array = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $diagnosticos = $rs["diagnosticos"];
            $comite = $rs["comite"];
            $ecog = $rs["ecog"];
            $histologico = $rs["histologico"];
            $invaciontumoral = $rs["invaciontumoral"];
            $mitotico = $rs["mitotico"];
            $tnmprimario = $rs["tnmprimario"];
            $tnmprimarioid = $rs["tnmprimarioid"];
            $observacionprimario = $rs["observacionprimario"];
            $tnmregionales = $rs["tnmregionales"];
            $tnmregionalesid = $rs["tnmregionalesid"];
            $observacionregionales = $rs["observacionregionales"];
            $tnmdistancia = $rs["tnmdistancia"];
            $tnmdistanciaid = $rs["tnmdistanciaid"];
            $observaciondistancia = $rs["observaciondistancia"];
            $anamesis = $rs["anamesis"];
            $cirugia = $rs["cirugia"];
            $quimioterapia = $rs["quimioterapia"];
            $radioterapia = $rs["radioterapia"];
            $tratamientosoncologicos = $rs["tratamientosoncologicos"];
            $seguimientosintratamiento = $rs["seguimientosintratamiento"];
            $completarestudios = $rs["completarestudios"];
            $revaluacionposterior = $rs["revaluacionposterior"];
            $estudioclinico = $rs["estudioclinico"];
            $observaciondesicion = $rs["observaciondesicion"];
            $consultade = $rs["consultade"];
            $consultadeid = $rs["consultadeid"];
            $programacionquirurgica = $rs["programacionquirurgica"];
            $traslado = $rs["traslado"];
            $ciudadospaliativos = $rs["ciudadospaliativos"];
            $ingresohospitalario = $rs["ingresohospitalario"];
            $observacionplan = $rs["observacionplan"];
            $resolucion = $rs["resolucion"];
            $registro = $rs["registro"];
            $informecomite = new InformeComite($id, $paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, $tnmprimario, $tnmprimarioid, $observacionprimario, $tnmregionales, $tnmregionalesid, $observacionregionales, $tnmdistancia, $tnmdistanciaid, $observaciondistancia, $anamesis, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $resolucion, $registro);
            array_push($array, $informecomite);
        }
        $this->desconexion();
        return $array;
    }

    //Buscar informe comite


    //Ultimo informe comite
    function ultimoinformecomite($paciente, $comite){
        $this->conexion();
        $sql = "select * from informecomite where paciente = $paciente and comite = $comite order by registro desc limit 1";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $diagnosticos = $rs["diagnosticos"];
            $comite = $rs["comite"];
            $ecog = $rs["ecog"];
            $histologico = $rs["histologico"];
            $invaciontumoral = $rs["invaciontumoral"];
            $mitotico = $rs["mitotico"];
            $tnmprimario = $rs["tnmprimario"];
            $tnmprimarioid = $rs["tnmprimarioid"];
            $observacionprimario = $rs["observacionprimario"];
            $tnmregionales = $rs["tnmregionales"];
            $tnmregionalesid = $rs["tnmregionalesid"];
            $observacionregionales = $rs["observacionregionales"];
            $tnmdistancia = $rs["tnmdistancia"];
            $tnmdistanciaid = $rs["tnmdistanciaid"];
            $observaciondistancia = $rs["observaciondistancia"];
            $anamesis = $rs["anamesis"];
            $cirugia = $rs["cirugia"];
            $quimioterapia = $rs["quimioterapia"];
            $radioterapia = $rs["radioterapia"];
            $tratamientosoncologicos = $rs["tratamientosoncologicos"];
            $seguimientosintratamiento = $rs["seguimientosintratamiento"];
            $completarestudios = $rs["completarestudios"];
            $revaluacionposterior = $rs["revaluacionposterior"];
            $estudioclinico = $rs["estudioclinico"];
            $observaciondesicion = $rs["observaciondesicion"];
            $consultade = $rs["consultade"];
            $consultadeid  = $rs["consultadeid"];
            $programacionquirurgica = $rs["programacionquirurgica"];
            $traslado = $rs["traslado"];
            $ciudadospaliativos = $rs["ciudadospaliativos"];
            $ingresohospitalario = $rs["ingresohospitalario"];
            $observacionplan = $rs["observacionplan"];
            $resolucion = $rs["resolucion"];
            $registro = $rs["registro"];
            $informecomite = new InformeComite($id, $paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, $tnmprimario, $tnmprimarioid, $observacionprimario, $tnmregionales, $tnmregionalesid, $observacionregionales, $tnmdistancia, $tnmdistanciaid, $observaciondistancia, $anamesis, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $resolucion, $registro);
            $this->desconexion();
            return $informecomite;
        }
        $this->desconexion();
        return null;
    }

    //Ultimo informe comite
    function buscarinformecomite($id){
        $this->conexion();
        $sql = "select * from informecomite where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $paciente = $rs["paciente"];
            $diagnosticos = $rs["diagnosticos"];
            $comite = $rs["comite"];
            $ecog = $rs["ecog"];
            $histologico = $rs["histologico"];
            $invaciontumoral = $rs["invaciontumoral"];
            $mitotico = $rs["mitotico"];
            $tnmprimario = $rs["tnmprimario"];
            $tnmprimarioid = $rs["tnmprimarioid"];
            $observacionprimario = $rs["observacionprimario"];
            $tnmregionales = $rs["tnmregionales"];
            $tnmregionalesid = $rs["tnmregionalesid"];
            $observacionregionales = $rs["observacionregionales"];
            $tnmdistancia = $rs["tnmdistancia"];
            $tnmdistanciaid = $rs["tnmdistanciaid"];
            $observaciondistancia = $rs["observaciondistancia"];
            $anamesis = $rs["anamesis"];
            $cirugia = $rs["cirugia"];
            $quimioterapia = $rs["quimioterapia"];
            $radioterapia = $rs["radioterapia"];
            $tratamientosoncologicos = $rs["tratamientosoncologicos"];
            $seguimientosintratamiento = $rs["seguimientosintratamiento"];
            $completarestudios = $rs["completarestudios"];
            $revaluacionposterior = $rs["revaluacionposterior"];
            $estudioclinico = $rs["estudioclinico"];
            $observaciondesicion = $rs["observaciondesicion"];
            $consultade = $rs["consultade"];
            $consultadeid  = $rs["consultadeid"];
            $programacionquirurgica = $rs["programacionquirurgica"];
            $traslado = $rs["traslado"];
            $ciudadospaliativos = $rs["ciudadospaliativos"];
            $ingresohospitalario = $rs["ingresohospitalario"];
            $observacionplan = $rs["observacionplan"];
            $resolucion = $rs["resolucion"];
            $registro = $rs["registro"];
            $informecomite = new InformeComite($id, $paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, $tnmprimario, $tnmprimarioid, $observacionprimario, $tnmregionales, $tnmregionalesid, $observacionregionales, $tnmdistancia, $tnmdistanciaid, $observaciondistancia, $anamesis, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $resolucion, $registro);
            $this->desconexion();
            return $informecomite;
        }
        $this->desconexion();
        return null;
    }


    //Buscar informecomite diagnostico
    function buscardiagnosticoscomite($diagnostico){
        $this->conexion();
        $sql = "select * from informecomitediagnostico where id = $diagnostico";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $diagnosticos = $rs["diagnosticos"];
            $diagnosticosid = $rs["diagnosticosid"];
            $diagnosticocieotoptext = $rs["diagnosticocieotop"];
            $diagnosticocieotopid = $rs["diagnosticocieotopid"];
            $diagnosticocieomortext = $rs["diagnosticocieomor"];
            $diagnosticocieomorid = $rs["diagnosticocieomorid"];
            $diagnosticocie10text = $rs["diagnosticocie10"];
            $diagnosticocie10id = $rs["diagnosticocie10id"];
            $fechabiopsia = $rs["fechabiopsia"];
            $reingreso = $rs["reingreso"];
            $registro = $rs["registro"];
            $object = new PacienteDiagnosticos($id, $diagnosticos, $diagnosticosid, $diagnosticocieotoptext, $diagnosticocieotopid, $diagnosticocieomortext, $diagnosticocieomorid, $diagnosticocie10text, $diagnosticocie10id, $fechabiopsia, $reingreso, $registro);
            $this->desconexion();
            return $object;
        }
        $this->desconexion();
        return null;
    }

    /******************************************Empresa***************************************** */
     //Actualizar Empresa
     public function actualizarEmpresa($id, $rut, $razonsocial, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $region, $comuna, $ciudad, $telefono, $email, $giro)
     {
         $this->conexion();
         $sql = "update empresa set rut = '$rut', razonsocial = '$razonsocial', calle = '$Enterprisecalle', villa='$Enterprisevilla',numero = '$Enterprisenumero', dept= '$Enterprisedept', region = $region, comuna = $comuna, ciudad = $ciudad, telefono = '$telefono', email = '$email', giro='$giro', updated_at = now() where id = $id";
         $result = $this->mi->query($sql);
         $this->desconexion();
         return json_encode($result);
     }

    //Buscar Empresa por RUT
    public function buscarEmpresaporRUT($rut)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, created_at, updated_at from empresa, regiones, comunas, ciudades where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $created_at, $updated_at);
            $this->desconexion();
            return $empresa;
        }
        $this->desconexion();
        return null;
    }

    public function buscarEmpresa1($id)
    {
        $this->conexion();
        $sql = "select * from empresa where id = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $created_at, $updated_at);
            $this->desconexion();
            return $empresa;
        }
        $this->desconexion();
        return null;
    }

    
    //Buscar Empresa
    public function buscarEmpresa($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, created_at, updated_at from empresa, regiones, comunas, ciudades where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.id = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $created_at, $updated_at);
            $this->desconexion();
            return $empresa;
        }
        $this->desconexion();
        return null;
    }

    //Registrar Empresa
    public function RegistrarEmpresa($rut, $razonsocial, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $region, $comuna, $ciudad, $telefono, $email, $giro)
    {
        $this->conexion();
        $sql = "insert into empresa values(null, '$rut', '$razonsocial', '$Enterprisecalle','$Enterprisevilla','$Enterprisenumero', '$Enterprisedept', $region, $comuna, $ciudad, '$telefono', '$email','$giro',now(), now());";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

     //validarEmpresa
     public function validarEmpresa($rut)
     {
         $this->conexion();
         $sql = "select * from empresa where rut = '$rut'";
         $result = $this->mi->query($sql);
         if ($rs = mysqli_fetch_array($result)) {
             $this->desconexion();
             return true;
         }
         $this->desconexion();
         return false;
     }

     //Listar Empresas
    public function listarEmpresas()
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email, giro, created_at, updated_at from empresa, regiones, comunas, ciudades  where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $created_at, $updated_at);
            $lista[] = $empresa;
        }
        $this->desconexion();
        return $lista;
    }


     //Eliminar Empresa
    public function eliminarEmpresa($id)
    {
        $this->conexion();
        $sql = "delete from empresa where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Validar Representante Legal
    public function ValidarRepresentanteLegal($rut, $empresa)
    {
        $this->conexion();
        $sql = "select * from representantelegal where rut = '$rut' and empresa = $empresa";
        $result = $this->mi->query($sql);
        $this->desconexion();
        if ($rs = mysqli_fetch_array($result)) {
            return true;
        } else {
            return false;
        }
    }

    
    //Registrar Representante Legal
    public function RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa)
    {
        $this->conexion();
        $sql = "insert into representantelegal values(null, '$rut', '$nombre', '$apellido1', '$apellido2', $empresa);";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

     //Eliminar Representante Legal
     public function EliminarRepresentanteLegal($id)
     {
         $this->conexion();
         $sql = "delete from representantelegal where id = $id";
         $result = $this->mi->query($sql);
         $this->desconexion();
         return json_encode($result);
     }

     public function listarCodigoActividad()
     {
         $this->conexion();
         $sql = "select * from codigoactividad";
         $result = $this->mi->query($sql);
         $lista = array();
         while ($rs = mysqli_fetch_array($result)) {
             $id = $rs['id'];
             $codigo = $rs['codigosii'];
             $descripcion = $rs['nombre'];
             $codigoactividad = new CodigoActividad($id, $codigo, $descripcion);
             $lista[] = $codigoactividad;
         }
         $this->desconexion();
         return $lista;
     }

      //ValidarCodigoActividad Empresa
    public function ValidarCodigoActividadEmpresa($empresa, $codigoactividad)
    {
        $this->conexion();
        $sql = "select * from nubcodigoactividad where empresa = $empresa and codigo = $codigoactividad";
        $result = $this->mi->query($sql);
        $this->desconexion();
        if ($rs = mysqli_fetch_array($result)) {
            return true;
        } else {
            return false;
        }
    }

    
    //RegistrarCodigoActividad Empresa
    public function RegistrarCodigoActividadEmpresa($empresa, $codigoactividad)
    {
        $this->conexion();
        $sql = "insert into nubcodigoactividad values(null, $codigoactividad, $empresa)";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }
      //Eliminar Codigo Actividad Empresa
    public function EliminarCodigoActividadEmpresa($id)
    {
        $this->conexion();
        $sql = "delete from nubcodigoactividad where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Representante Legal
    public function listarRepresentantelegal($empresa)
    {
        $this->conexion();
        $sql = "select * from representantelegal where empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $rep = new RepresentanteLegal($id, $rut, $nombre, $apellido1, $apellido2, $empresa);
            $lista[] = $rep;
        }
        $this->desconexion();
        return $lista;
    }
    //Listar Codigo Actividad Empresa
    public function ListarCodigoActividadEmpresa($empresa)
    {
        $this->conexion();
        $sql = "select nubcodigoactividad.id as id, codigoactividad.codigosii as codigosii, codigoactividad.nombre as nombre from nubcodigoactividad, codigoactividad where nubcodigoactividad.codigo = codigoactividad.id and nubcodigoactividad.empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigosii = $rs['codigosii'];
            $nombre = $rs['nombre'];
            $cod  = new CodigoActividad($id, $codigosii, $nombre);
            $lista[] = $cod;
        }
        $this->desconexion();
        return $lista;
    }

    /************************************************************* */
    //Listar Roles
    public function listarRoles()
    {
        $this->conexion();
        $sql = "select * from roles";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $descripcion = $rs['descripcion'];
            $rol = new Objects($id, $nombre, $descripcion);
            $lista[] = $rol;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Roles Usuario Empresa
    public function BuscarRolesUsuarioEmpresa($empresa, $usuario)
    {
        $this->conexion();
        $sql = "select rolesusuarios.id as id, roles.nombre as nombre, roles.descripcion as descripcion from roles, rolesusuarios where roles.id = rolesusuarios.rol and rolesusuarios.usuario = $usuario and rolesusuarios.empresa = $empresa"; 
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $descripcion = $rs['descripcion'];
            $rol = new Objects($id, $nombre, $descripcion);
            $lista[] = $rol;
        }
        $this->desconexion();
        return $lista;
    }

    //Registrar Rol Usuario Empresa
    public function RegistrarRolUsuarioEmpresa($empresa, $usuario, $rol)
    {
        $this->conexion();
        $sql = "insert into rolesusuarios values(null, $usuario, $rol, $empresa,now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Rol Usuario Empresa
    public function EliminarRolUsuarioEmpresa($id)
    {
        $this->conexion();
        $sql = "delete from rolesusuarios where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    /*****************************Dias Feriados****************** */
    
    //Listar Dias Feriados
    function listardiasferiados()
    {
        $this->conexion();
        $sql = "select * from diasferiado";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $periodo = $rs['periodo'];
            $fecha = $rs['fecha'];
            $descripcion = $rs['descripcion'];
            $DF = new DiasFeriados($id, $periodo, $fecha, $descripcion);
            $lista[] = $DF;
        }
        $this->desconexion();
        return $lista;
    }
    //Listar Dias Feriados
    function listardiasferiadosperiodos($ano)
    {
        $this->conexion();
        $sql = "select * from diasferiado where periodo = $ano";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $periodo = $rs['periodo'];
            $fecha = $rs['fecha'];
            $descripcion = $rs['descripcion'];
            $DF = new DiasFeriados($id, $periodo, $fecha, $descripcion);
            $lista[] = $DF;
        }
        $this->desconexion();
        return $lista;
    }

    //Comprobar Dias Feriados
    function comprobardiasferiados($fecha)
    {
        $this->conexion();
        $sql = "select * from diasferiado where fecha = '$fecha'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }

    //Registrar Disponibilidad
    function registrardisponibilidad( $usuario,$empresa, $fecha, $horainicio, $horafinal, $intervalo, $estado)
    {
        $this->conexion();
        $sql = "insert into disponibilidad values(null,$usuario, $empresa,  '$fecha', '$horainicio', '$horafinal', $intervalo, $estado, now())";
        //Registrar y retornar el id de la disponibilidad
        $result = $this->mi->query($sql);
        $id = $this->mi->insert_id;
        $this->desconexion();
        return $id;
    }
    
    //Registrar Disponibilidad
    function registrarhorario( $usuario,$empresa, $fecha, $horainicio, $horafinal, $intervalo,$disponibilidad, $estado)
    {
        $this->conexion();
        $sql = "insert into horarios values(null,$usuario, $empresa,  '$fecha', '$horainicio', '$horafinal', $intervalo, $disponibilidad, $estado, now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Listar Disponibilidad
    function listardisponibilidad($usuario, $empresa)
    {
        $this->conexion();
        $sql = "select * from disponibilidad where usuario = $usuario and empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs["id"];
            $usuario = $rs["usuario"];
            $empresa = $rs["empresa"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafinal = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $disponibilidad = new Disponibilidad($id, $usuario, $empresa, $fecha, $horainicio, $horafinal, $intervalo, $estado, $registro);
            $lista[] = $disponibilidad;
        }
        $this->desconexion();
        return $lista;
    }

    //Listar Horario
    function listarhorario($usuario, $empresa)
    {
        $this->conexion();
        $sql = "select * from horarios where usuario = $usuario and empresa = $empresa and fecha >= curdate()";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs["id"];
            $usuario = $rs["usuario"];
            $empresa = $rs["empresa"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafinal = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $disponibilidad = $rs["disponibilidad"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $disponibilidad = new Horario($id, $usuario, $empresa, $fecha, $horainicio, $horafinal, $intervalo,$disponibilidad, $estado, $registro);
            $lista[] = $disponibilidad;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Disponibilidad desde la fecha de hoy
    function buscardisponibilidad($usuario, $empresa)
    {
        $this->conexion();
        $sql = "select * from disponibilidad where usuario = $usuario and empresa = $empresa and fecha >= curdate()";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs["id"];
            $usuario = $rs["usuario"];
            $empresa = $rs["empresa"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafinal = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $disponibilidad = new Disponibilidad($id, $usuario, $empresa, $fecha, $horainicio, $horafinal, $intervalo, $estado, $registro);
            $lista[] = $disponibilidad;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Horario desde la fecha de hoy
    function buscarhorario($usuario, $empresa)
    {
        $this->conexion();
        $sql = "select * from horarios where usuario = $usuario and empresa = $empresa and fecha >= curdate()";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs["id"];
            $usuario = $rs["usuario"];
            $empresa = $rs["empresa"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafinal = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $disponibilidad = $rs["disponibilidad"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $disponibilidad = new Horario($id, $usuario, $empresa, $fecha, $horainicio, $horafinal, $intervalo, $disponibilidad, $estado, $registro);
            $lista[] = $disponibilidad;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar Horario por Disponibilidad
    function buscarhorariodisponibilidad($disponibilidad)
    {
        $this->conexion();
        $sql = "select * from horarios where disponibilidad = $disponibilidad";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs["id"];
            $usuario = $rs["usuario"];
            $empresa = $rs["empresa"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafinal = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $disponibilidad = $rs["disponibilidad"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $disponibilidad = new Horario($id, $usuario, $empresa, $fecha, $horainicio, $horafinal, $intervalo, $disponibilidad, $estado, $registro);
            $lista[] = $disponibilidad;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar id Disponibilidad por horario
    function buscariddisponibilidad($horario)
    {
        $this->conexion();
        $sql = "select * from horarios where id = $horario";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $disponibilidad = $rs["disponibilidad"];
            $this->desconexion();
            return $disponibilidad;
        }
        $this->desconexion();
        return null;
    }

    //Comprobar horarios disponibles por disponibilidad
    function comprobarhorariosdisponibles($disponibilidad)
    {
        $this->conexion();
        $sql = "select * from horarios where disponibilidad = $disponibilidad and estado = 1 and fecha >= curdate()";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }
    

    //Eliminar Disponibilidad
    function eliminardisponibilidad($id)
    {
        $this->conexion();
        $sql = "delete from disponibilidad where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Eliminar Horario por disponibilidad
    function eliminarhorariodisponibilidad($disponibilidad)
    {
        $this->conexion();
        $sql = "delete from horarios where disponibilidad = $disponibilidad";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Cambiar Estado Disponibilidad
    function cambiarestadodisponibilidad($id, $estado)
    {
        $this->conexion();
        $sql = "update disponibilidad set estado = $estado where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Cambiar Estado Horario
    function cambiarestadohorario($id, $estado)
    {
        $this->conexion();
        $sql = "update horarios set estado = $estado where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Cancelar

    /**********************************Reservas***************** */
    //Registrar Reserva
    function registrarreserva($paciente, $horario){
        $this->conexion();
        $sql = "insert into atenciones values(null, $paciente, $horario,'',1, now())";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Cambiar Estado Reserva
    function cambiarestadoreserva($id, $estado){
        $this->conexion();
        $sql = "update atenciones set estado = $estado where id = $id";
        $result = $this->mi->query($sql);
        $this->desconexion();
        return json_encode($result);
    }

    //Validar Reserva horario
    function validarreservahorario($horario){
        $this->conexion();
        $sql = "select * from atenciones where horario = $horario";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $this->desconexion();
            return true;
        }
        $this->desconexion();
        return false;
    }

    //Buscar las reservas del día
    function buscarreservashoy($empresa){
        $this->conexion();
        $sql = "select atenciones.id as id, pacientes.tipoidentificacion as tipo, pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, usuarios.nombre as nombremedico, usuarios.apellido1 as ape1medico, usuarios.apellido2 as ape2medico,profesiones.nombre as profesion, horarios.fecha as fecha, horarios.horainicio as horainicio, horarios.horafin as horafin, horarios.intervalo as intervalo, atenciones.observacion as observacion, atenciones.estado as estado, atenciones.registro as registro from atenciones, horarios,pacientes, usuarios, usuarioprofesion, profesiones where atenciones.horario = horarios.id and horarios.usuario = usuarios.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and atenciones.paciente = pacientes.id and horarios.fecha = curdate() and usuarioprofesion.empresa = $empresa group by id order by horarios.horainicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $tipo = $rs["tipo"];
            $rut = $rs["rut"];
            $nombre = $rs["nombre"]." ". $rs["apellido1"] ." ".$rs["apellido2"];
            $nombremedico = $rs["nombremedico"]." ". $rs["ape1medico"] ." ".$rs["ape2medico"];
            $profesion = $rs["profesion"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafin = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $observacion = $rs["observacion"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $reserva = new Atencion($id,  $rut, $nombre, $nombremedico, $profesion, $fecha, $horainicio, $horafin, $intervalo, $observacion, $estado, $registro);
            $lista[] = $reserva;
        }
        $this->desconexion();
        return $lista;
    }

    //Buscar las reservas del día del medico
    function buscarreservashoymedico($empresa, $usuario){
        $this->conexion();
        $sql = "select atenciones.id as id, pacientes.tipoidentificacion as tipo, pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, usuarios.nombre as nombremedico, usuarios.apellido1 as ape1medico, usuarios.apellido2 as ape2medico,profesiones.nombre as profesion, horarios.fecha as fecha, horarios.horainicio as horainicio, horarios.horafin as horafin, horarios.intervalo as intervalo, atenciones.observacion as observacion, atenciones.estado as estado, atenciones.registro as registro from atenciones, horarios,pacientes, usuarios, usuarioprofesion, profesiones where atenciones.horario = horarios.id and horarios.usuario = usuarios.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and atenciones.paciente = pacientes.id and horarios.fecha = curdate() and usuarioprofesion.empresa = $empresa and usuarios.id = $usuario group by id order by horarios.horainicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $tipo = $rs["tipo"];
            $rut = $rs["rut"];
            $nombre = $rs["nombre"]." ". $rs["apellido1"] ." ".$rs["apellido2"];
            $nombremedico = $rs["nombremedico"]." ". $rs["ape1medico"] ." ".$rs["ape2medico"];
            $profesion = $rs["profesion"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafin = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $observacion = $rs["observacion"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $reserva = new Atencion($id,  $rut, $nombre, $nombremedico, $profesion, $fecha, $horainicio, $horafin, $intervalo, $observacion, $estado, $registro);
            $lista[] = $reserva;
        }
        $this->desconexion();
        return $lista;
    }

    ///Buscar todas las reservas del paciente
    function buscarreservaspaciente($paciente){
        $this->conexion();
        $sql = "select atenciones.id as id, pacientes.tipoidentificacion as tipo, pacientes.rut as rut, pacientes.nombre as nombre, pacientes.apellido1 as apellido1, pacientes.apellido2 as apellido2, usuarios.nombre as nombremedico, usuarios.apellido1 as ape1medico, usuarios.apellido2 as ape2medico,profesiones.nombre as profesion, horarios.fecha as fecha, horarios.horainicio as horainicio, horarios.horafin as horafin, horarios.intervalo as intervalo, atenciones.observacion as observacion, atenciones.estado as estado, atenciones.registro as registro from atenciones, horarios,pacientes, usuarios, usuarioprofesion, profesiones where atenciones.horario = horarios.id and horarios.usuario = usuarios.id and usuarios.id = usuarioprofesion.usuario and usuarioprofesion.profesion = profesiones.id and atenciones.paciente = pacientes.id and pacientes.id = $paciente group by id order by horarios.horainicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while($rs = mysqli_fetch_array($result)){
            $id = $rs["id"];
            $tipo = $rs["tipo"];
            $rut = $rs["rut"];
            $nombre = $rs["nombre"]." ". $rs["apellido1"] ." ".$rs["apellido2"];
            $nombremedico = $rs["nombremedico"]." ". $rs["ape1medico"] ." ".$rs["ape2medico"];
            $profesion = $rs["profesion"];
            $fecha = $rs["fecha"];
            $horainicio = $rs["horainicio"];
            $horafin = $rs["horafin"];
            $intervalo = $rs["intervalo"];
            $observacion = $rs["observacion"];
            $estado = $rs["estado"];
            $registro = $rs["registro"];
            $reserva = new Atencion($id,  $rut, $nombre, $nombremedico, $profesion, $fecha, $horainicio, $horafin, $intervalo, $observacion, $estado, $registro);
            $lista[] = $reserva;
        }
        $this->desconexion();
        return $lista;
    }
    
            
}
?>