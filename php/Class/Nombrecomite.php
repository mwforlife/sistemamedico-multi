<?php
class Nombrecomite{
    private $id;
    private $codigo;
    private $nombre;
    private $empresa;
    private $estado;
    private $registro;

    public function __construct($id,$codigo, $nombre,$empresa, $estado, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->empresa = $empresa;
        $this->estado = $estado;
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

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getRegistro(){
        return $this->registro;
    }
}