<?php
class Estimulador {
    private $id;
    private $receta;
    private $nombre;
    private $cantidad;
    private $rangodias;
    private $registro;

    public function __construct($id, $receta, $nombre, $cantidad, $rangodias, $registro) {
        $this->id = $id;
        $this->receta = $receta;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->rangodias = $rangodias;
        $this->registro = $registro;
    }

    public function getId() {
        return $this->id;
    }

    public function getReceta() {
        return $this->receta;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getRangoDias() {
        return $this->rangodias;
    }

    public function getRegistro() {
        return $this->registro;
    }
}
