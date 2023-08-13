<?php
class CodigoActividad{
    private $id;
    private $codigoSii;
    private $nombre;

    public function __construct($id, $codigoSii, $nombre){
        $this->id = $id;
        $this->codigoSii = $codigoSii;
        $this->nombre = $nombre;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCodigoSii(){
        return $this->codigoSii;
    }

    public function setCodigoSii($codigoSii){
        $this->codigoSii = $codigoSii;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    
}