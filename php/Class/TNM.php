<?php
class TNM{
    private $id;
    private $codigo;
    private $nombre;
    private $diagnostico;
    private $tipo;
    private $registro;

    public function __construct($id,$codigo, $nombre, $diagnostico, $tipo, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->diagnostico = $diagnostico;
        $this->tipo = $tipo;
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

    public function getTipo(){
        return $this->tipo;
    }

    public function getRegistro(){
        return $this->registro;
    }
}