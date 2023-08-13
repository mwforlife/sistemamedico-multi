<?php
class Datosubicacion{
    private $id;
    private $paciente;
    private $region;
    private $provincia;
    private $comuna;
    private $ciudad;
    private $tipocalle;
    private $nombrecalle;
    private $numerocalle;
    private $restodireccion;
    private $registro;

    public function __construct($id, $paciente, $region, $provincia, $comuna, $ciudad, $tipocalle, $nombrecalle, $numerocalle, $restodireccion, $registro){
        $this->id = $id;
        $this->paciente = $paciente;
        $this->region = $region;
        $this->provincia = $provincia;
        $this->comuna = $comuna;
        $this->ciudad = $ciudad;
        $this->tipocalle = $tipocalle;
        $this->nombrecalle = $nombrecalle;
        $this->numerocalle = $numerocalle;
        $this->restodireccion = $restodireccion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getProvincia(){
        return $this->provincia;
    }

    public function getComuna(){
        return $this->comuna;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    public function getTipocalle(){
        return $this->tipocalle;
    }

    public function getNombrecalle(){
        return $this->nombrecalle;
    }

    public function getNumerocalle(){
        return $this->numerocalle;
    }

    public function getRestodireccion(){
        return $this->restodireccion;
    }

    public function getRegistro(){
        return $this->registro;
    }
}