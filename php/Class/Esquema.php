<?php
class Esquema{
    private $id;
    private $codigo;
    private $nombre;
    private $diagnostico;
    private $libros;
    private $empresa;
    private $registro;

    public function __construct($id, $codigo, $nombre, $diagnostico, $libros, $empresa, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->diagnostico = $diagnostico;
        $this->libros = $libros;
        $this->empresa = $empresa;
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

    public function getDiagnostico(){
        return $this->diagnostico;
    }

    public function getLibros(){
        return $this->libros;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getRegistro(){
        return $this->registro;
    }
}