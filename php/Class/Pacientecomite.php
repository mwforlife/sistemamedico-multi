<?php
class Pacientecomite{
    private $id;
    private $rut;
    private $nombre;
    private $contacto;
    private $profesionalid;
    private $profesional;
    private $observaciones;
    private $registro;

    public function __construct($id, $rut, $nombre, $contacto, $profesionalid, $profesional, $observaciones, $registro){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
        $this->profesionalid = $profesionalid;
        $this->profesional = $profesional;
        $this->observaciones = $observaciones;
        $this->registro = $registro;
    }

    public function getid(){
        return $this->id;
    }

    public function getrut(){
        return $this->rut;
    }

    public function getnombre(){
        return $this->nombre;
    }

    public function getcontacto(){
        return $this->contacto;
    }

    public function getprofesionalid(){
        return $this->profesionalid;
    }

    public function getprofesional(){
        return $this->profesional;
    }

    public function getobservaciones(){
        return $this->observaciones;
    }

    public function getregistro(){
        return $this->registro;
    }
}