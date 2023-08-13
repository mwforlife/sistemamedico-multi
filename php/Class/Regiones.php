<?php
class Regiones{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;

    public function Regiones($id, $codigo, $codigoPrevired, $nombre){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
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

    public function getCodigoPrevired(){
        return $this->codigoPrevired;
    }

    public function setCodigoPrevired($codigoPrevired){
        $this->codigoPrevired = $codigoPrevired;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}