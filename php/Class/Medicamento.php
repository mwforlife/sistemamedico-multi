<?php
class Medicamento{
    private $id;
    private $codigo;
    private $descripcion;
    private $laboratorio;
    private $division;
    private $categoria;
    private $registro;

    public function __construct($id, $codigo, $descripcion, $laboratorio, $division, $categoria, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->laboratorio = $laboratorio;
        $this->division = $division;
        $this->categoria = $categoria;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getLaboratorio(){
        return $this->laboratorio;
    }

    public function getDivision(){
        return $this->division;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function getRegistro(){
        return $this->registro;
    }
}