<?php
class Nacionalidad{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;

    public function Nacionalidad($id, $codigo, $codigoPrevired, $nombre){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getCodigoPrevired(){
        return $this->codigoPrevired;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function setCodigoPrevired($codigoPrevired){
        $this->codigoPrevired = $codigoPrevired;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

}