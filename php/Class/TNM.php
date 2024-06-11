<?php
class TNM{
    private $id;
    private $nombre;
    private $tipo;
    private $registro;

    public function __construct($id, $nombre, $tipo, $registro){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }


    public function getTipo(){
        return $this->tipo;
    }

    public function getRegistro(){
        return $this->registro;
    }
}