<?php
class Medicamento{
    private $id;
    private $nombre;
    private $presentacion;
    private $cantidad;
    private $medida;
    private $viasdeadministracion;
    private $registro;

    public function __construct($id, $nombre, $presentacion, $cantidad, $medida, $viasdeadministracion, $registro){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->presentacion = $presentacion;
        $this->cantidad = $cantidad;
        $this->medida = $medida;
        $this->viasdeadministracion = $viasdeadministracion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getPresentacion(){
        return $this->presentacion;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function getMedida(){
        return $this->medida;
    }

    public function getViasdeadministracion(){
        return $this->viasdeadministracion;
    }

    public function getRegistro(){
        return $this->registro;
    }

}