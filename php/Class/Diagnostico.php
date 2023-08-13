<?php
class Diagnostico{
    private $id;
    private $codigo;
    private $nombre;
    private $registro;

    public function __construct($id, $codigo, $nombre, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->registro = $registro;
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

    public function getRegistro(){
        return $this->registro;
    }
}