<?php
class DiagnosticoCIEO{
    private $id;
    private $codigo;
    private $descripcioncompleto;
    private $descripcionabreviado;
    private $tipo;
    private $registro;

    public function __construct($id, $codigo, $descripcioncompleto, $descripcionabreviado, $tipo, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcioncompleto = $descripcioncompleto;
        $this->descripcionabreviado = $descripcionabreviado;
        $this->tipo = $tipo;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getDescripcionCompleto(){
        return $this->descripcioncompleto;
    }

    public function getDescripcionAbreviado(){
        return $this->descripcionabreviado;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getRegistro(){
        return $this->registro;
    }
}