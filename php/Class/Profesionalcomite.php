<?php
class Profesionalcomite{
    private $id;
    private $rut;
    private $nombre;
    private $profesion;
    private $idcomite;
    private $registro;

    public function __construct($id, $rut, $nombre, $profesion, $idcomite,$registro){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->profesion = $profesion;
        $this->idcomite = $idcomite;
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

    public function getprofesion(){
        return $this->profesion;
    }

    public function getidcomite(){
        return $this->idcomite;
    }

    public function getregistro(){
        return $this->registro;
    }
}