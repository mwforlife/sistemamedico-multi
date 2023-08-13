<?php
class Auditoria{
    private $id;
    private $usuario;
    private $accion;
    private $titulo;
    private $evento;
    private $fecha;

    function __construct($id, $usuario, $accion, $titulo, $evento, $fecha) {
        $this->id = $id;
        $this->usuario = $usuario;
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