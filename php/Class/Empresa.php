<?php
class Empresa{
    private $id;
    private $rut;
    private $razonsocial;
    private $calle;
    private $villa;
    private $numero;
    private $departamento;
    private $region;
    private $comuna;
    private $ciudad;
    private $telefono;
    private $email;
    private $giro;
    private $registro;
    private $update;

    public function __construct($id, $rut, $razonsocial, $calle,$villa,$numero,$departamento, $region, $comuna, $ciudad, $telefono, $email,$giro,$registro, $update){
        $this->id = $id;
        $this->rut = $rut;
        $this->razonsocial = $razonsocial;
        $this->calle = $calle;
        $this->villa = $villa;
        $this->numero = $numero;
        $this->departamento = $departamento;
        $this->region = $region;
        $this->comuna = $comuna;
        $this->ciudad = $ciudad;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->giro = $giro;
        $this->registro = $registro;
        $this->update = $update;
    }

    public function getId(){
        return $this->id;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getRazonSocial(){
        return $this->razonsocial;
    }

    public function getCalle(){
        return $this->calle;
    }

    public function getVilla(){
        return $this->villa;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getDepartamento(){
        return $this->departamento;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getComuna(){
        return $this->comuna;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getGiro(){
        return $this->giro;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function getUpdate(){
        return $this->update;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setRut($rut){
        $this->rut = $rut;
    }

    public function setRazonSocial($razonsocial){
        $this->razonsocial = $razonsocial;
    }

    public function setCalle($calle){
        $this->calle = $calle;
    }

    public function setVilla($villa){
        $this->villa = $villa;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function setDepartamento($departamento){
        $this->departamento = $departamento;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function setComuna($comuna){
        $this->comuna = $comuna;
    }

    public function setCiudad($ciudad){
        $this->ciudad = $ciudad;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setGiro($giro){
        $this->giro = $giro;
    }

    public function setCajasCompensacion($cajascompensacion){
        $this->cajascompensacion = $cajascompensacion;
    }

    public function setMutuales($mutuales){
        $this->mutuales = $mutuales;
    }

    public function setCotizacionBasica($cotizacionbasica){
        $this->cotizacionbasica = $cotizacionbasica;
    }

    public function setCotizacionLeySanna($cotizacionleysanna){
        $this->cotizacionleysanna = $cotizacionleysanna;
    }

    public function setCotizacionAdicional($cotizacionadicional){
        $this->cotizacionadicional = $cotizacionadicional;
    }

    public function setRegistro($registro){
        $this->registro = $registro;
    }

    public function setUpdate($update){
        $this->update = $update;
    }

}