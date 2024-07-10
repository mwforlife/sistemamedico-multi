<?php
class Atencion{
    private $id;
    private $rut;
    private $paciente;
    private $profesional;
    private $profesion;
    private $fecha;
    private $horainicio;
    private $horatermino;
    private $intervalo;
    private $observacion;
    private $estado;
    private $horallegada;
    private $horaatencion;
    private $horafinalizacion;
    private $registro;

    public function __construct($id, $rut, $paciente, $profesional, $profesion, $fecha, $horainicio, $horatermino, $intervalo, $observacion, $estado,$horallegada, $horaatencion, $horafinalizacion, $registro){
        $this->id = $id;
        $this->rut = $rut;
        $this->paciente = $paciente;
        $this->profesional = $profesional;
        $this->profesion = $profesion;
        $this->fecha = $fecha;
        $this->horainicio = $horainicio;
        $this->horatermino = $horatermino;
        $this->intervalo = $intervalo;
        $this->observacion = $observacion;
        $this->estado = $estado;
        $this->horallegada = $horallegada;
        $this->horaatencion = $horaatencion;
        $this->horafinalizacion = $horafinalizacion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getProfesional(){
        return $this->profesional;
    }

    public function getProfesion(){
        return $this->profesion;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getHoraInicio(){
        return $this->horainicio;
    }

    public function getHoraTermino(){
        return $this->horatermino;
    }

    public function getIntervalo(){
        return $this->intervalo;
    }

    public function getObservacion(){
        return $this->observacion;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getHoraLlegada(){
        return $this->horallegada;
    }

    public function getHoraAtencion(){
        return $this->horaatencion;
    }

    public function getHoraFinalizacion(){
        return $this->horafinalizacion;
    }

    public function getRegistro(){
        return $this->registro;
    }
}