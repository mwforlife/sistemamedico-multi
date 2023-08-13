<?php
class RepresentanteLegal{
    private $id;
    private $rut;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $empresa;

    public function __construct($id, $rut, $nombre, $apellido1, $apellido2, $empresa){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->empresa = $empresa;
    }

    public function getId(){
        return $this->id;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido1(){
        return $this->apellido1;
    }

    public function getApellido2(){
        return $this->apellido2;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setRut($rut){
        $this->rut = $rut;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido1($apellido1){
        $this->apellido1 = $apellido1;
    }

    public function setApellido2($apellido2){
        $this->apellido2 = $apellido2;
    }

    public function setEmpresa($empresa){
        $this->empresa = $empresa;
    }
}