<?php
class Auditoria{
    private $id;
    private $usuario;
    private $empresa;
    private $accion;
    private $titulo;
    private $evento;
    private $fecha;

    function __construct($id, $usuario, $empresa, $accion, $titulo, $evento, $fecha) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->empresa = $empresa;
        $this->accion = $accion;
        $this->titulo = $titulo;
        $this->evento = $evento;
        $this->fecha = $fecha;
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

    function getAccion() {
        return $this->accion;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getEvento() {
        return $this->evento;
    }

    function getFecha() {
        return $this->fecha;
    }
}