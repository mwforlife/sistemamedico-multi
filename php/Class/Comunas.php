<?php
class Comunas{
    private $id;
    private $codigo;
    private $nombre;
    private $region;
    private $provincia;

    public function __construct($id, $codigo, $nombre, $region, $provincia){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->region = $region;
        $this->provincia = $provincia;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getRegion(){
        return $this->region;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function getProvincia(){
        return $this->provincia;
    }

    public function setProvincia($provincia){
        $this->provincia = $provincia;
    }
}