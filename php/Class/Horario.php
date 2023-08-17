<?php
class Horario{
    private $id;
    private $usuario;
    private $empresa;
    private $fecha;
    private $horainicio;
    private $horafin;
    private $intervalo;
    private $disponibilidad;
    private $estado;
    private $registro;

    function __construct($id, $usuario, $empresa, $fecha, $horainicio, $horafin, $intervalo, $disponibilidad,$estado, $registro) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->empresa = $empresa;
        $this->fecha = $fecha;
        $this->horainicio = $horainicio;
        $this->horafin = $horafin;
        $this->intervalo = $intervalo;
        $this->disponibilidad = $disponibilidad;
        $this->estado = $estado;
        $this->registro = $registro;
    }

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHorainicio() {
        return $this->horainicio;
    }

    function getHorafin() {
        return $this->horafin;
    }

    function getIntervalo() {
        return $this->intervalo;
    }

    function getDisponibilidad() {
        return $this->disponibilidad;
    }

    function getEstado() {
        return $this->estado;
    }

    function getRegistro() {
        return $this->registro;
    }
}