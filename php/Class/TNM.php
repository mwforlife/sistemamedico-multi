<?php
class TNM{
    private $id;
    private $nombre;
    private $diagnostico;
    private $tipo;
    private $registro;

    public function __construct($id, $nombre,$diagnostico, $tipo, $registro){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->diagnostico = $diagnostico;
        $this->tipo = $tipo;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getDiagnostico(){
        return $this->diagnostico;
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