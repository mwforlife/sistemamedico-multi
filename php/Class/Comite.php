<?php
class Comite{
    private $id;
    private $folio;
    private $fecha;
    private $nombre;
    private $estado;
    private $registro;

    public function __construct($id, $folio, $fecha, $nombre, $estado, $registro){
        $this->id = $id;
        $this->folio = $folio;
        $this->fecha = $fecha;
        $this->nombre = $nombre;
        $this->estado = $estado;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getFolio(){
        return $this->folio;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getRegistro(){
        return $this->registro;
    }
}