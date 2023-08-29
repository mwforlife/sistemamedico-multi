<?php
class RecetaPremedicacion {
    private $id;
    private $receta;
    private $premedicacion;
    private $dosis;
    private $oral;
    private $ev;
    private $sc;
    private $observacion;
    private $registro;

    public function __construct($id, $receta, $premedicacion, $dosis, $oral, $ev, $sc, $observacion, $registro) {
        $this->id = $id;
        $this->receta = $receta;
        $this->premedicacion = $premedicacion;
        $this->dosis = $dosis;
        $this->oral = $oral;
        $this->ev = $ev;
        $this->sc = $sc;
        $this->observacion = $observacion;
        $this->registro = $registro;
    }

    public function getId() {
        return $this->id;
    }

    public function getReceta() {
        return $this->receta;
    }

    public function getPremedicacion() {
        return $this->premedicacion;
    }

    public function getDosis() {
        return $this->dosis;
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

    public function getObservacion() {
        return $this->observacion;
    }

    public function getRegistro() {
        return $this->registro;
    }
}
