<?php
class Profesionalcomite{
    private $id;
    private $rut;
    private $nombre;
    private $profesion;
    private $idcomite;
    private $registro;
    private $cargoid;
    private $cargo;

    public function __construct($id, $rut, $nombre, $profesion, $idcomite,$registro,$cargoid,$cargo){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->profesion = $profesion;
        $this->idcomite = $idcomite;
        $this->registro = $registro;
        $this->cargoid = $cargoid;
        $this->cargo = $cargo;
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

    public function getcargoid(){
        return $this->cargoid;
    }

    public function getcargo(){
        return $this->cargo;
    }
}