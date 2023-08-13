<?php
class Responsable{
    private $id;
    private $paciente;
    private $rut;
    private $nombre;
    private $relacion;
    private $telefono;
    private $direccion;
    private $registro;

    public function __construct($id, $paciente, $rut, $nombre, $relacion, $telefono, $direccion, $registro){
        $this->id = $id;
        $this->paciente = $paciente;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->relacion = $relacion;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getRelacion(){
        return $this->relacion;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getRegistro(){
        return $this->registro;
    }
    
}