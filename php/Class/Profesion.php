<?php
class Profesion{
    private $id;
    private $codigo;
    private $nombre;
    private $especialidad;

    public function __construct($id,$codigo, $nombre,$especialidad){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->especialidad = $especialidad;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getEspecialidad(){
        return $this->especialidad;
    }
}