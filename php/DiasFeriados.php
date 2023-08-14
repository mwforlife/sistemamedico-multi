<?php
class DiasFeriados
{
    private $id;
    private $periodo;
    private $fecha;
    private $descripcion;

    public function __construct($id, $periodo, $fecha, $descripcion)
    {
        $this->id = $id;
        $this->periodo = $periodo;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
