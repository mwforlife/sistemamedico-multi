<?php
class Objects{
    private $id;
    private $codigo;
    private $nombre;

    public function __construct($id,$codigo, $nombre){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
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
}