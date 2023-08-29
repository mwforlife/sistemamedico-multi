<?php
class RecetaMedicamentos {
    private $id;
    private $receta;
    private $medicamento;
    private $porcentaje;
    private $dosis;
    private $carboplatino;
    private $oral;
    private $ev;
    private $sc;
    private $it;
    private $biccad;
    private $observacion;
    private $registro;

    public function __construct($id, $receta, $medicamento, $porcentaje, $dosis, $carboplatino, $oral, $ev, $sc, $it, $biccad, $observacion, $registro) {
        $this->id = $id;
        $this->receta = $receta;
        $this->medicamento = $medicamento;
        $this->porcentaje = $porcentaje;
        $this->dosis = $dosis;
        $this->carboplatino = $carboplatino;
        $this->oral = $oral;
        $this->ev = $ev;
        $this->sc = $sc;
        $this->it = $it;
        $this->biccad = $biccad;
        $this->observacion = $observacion;
        $this->registro = $registro;
    }

    public function getId() {
        return $this->id;
    }

    public function getReceta() {
        return $this->receta;
    }

    public function getMedicamento() {
        return $this->medicamento;
    }

    public function getPorcentaje() {
        return $this->porcentaje;
    }

    public function getDosis() {
        return $this->dosis;
    }

    public function getCarboplatino() {
        return $this->carboplatino;
    }

    public function getOral() {
        return $this->oral;
    }

    public function getEv() {
        return $this->ev;
    }

    public function getSc() {
        return $this->sc;
    }

    public function getIt() {
        return $this->it;
    }

    public function getBiccad() {
        return $this->biccad;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function getRegistro() {
        return $this->registro;
    }
}
