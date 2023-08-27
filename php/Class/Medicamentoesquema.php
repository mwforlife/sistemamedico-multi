<?php
class MedicamentoEsquema{
    private $id;
    private $medicamento;
    private $dosis;
    private $medicion;
    private $carboplatino;
    private $registro;

    public function __construct($id, $medicamento, $dosis,$medicion, $carboplatino, $registro){
        $this->id = $id;
        $this->medicamento = $medicamento;
        $this->dosis = $dosis;
        $this->medicion = $medicion;
        $this->carboplatino = $carboplatino;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getMedicamento(){
        return $this->medicamento;
    }

    public function getDosis(){
        return $this->dosis;
    }
    
    public function getMedicion(){
        return $this->medicion;
    }
    
    public function getCarboplatino(){
        return $this->carboplatino;
    }

    public function getRegistro(){
        return $this->registro;
    }
}