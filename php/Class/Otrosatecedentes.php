<?php
class otrosantecedentes{
    private $id;
    private $paciente;
    private $pueblooriginario;
    private $escolaridad;
    private $cursorepite;
    private $situacionlaboral;
    private $ocupacion;
    private $registro;

    public function __construct($id, $paciente, $pueblooriginario, $escolaridad, $cursorepite, $situacionlaboral, $ocupacion, $registro){
        $this->id = $id;
        $this->paciente = $paciente;
        $this->pueblooriginario = $pueblooriginario;
        $this->escolaridad = $escolaridad;
        $this->cursorepite = $cursorepite;
        $this->situacionlaboral = $situacionlaboral;
        $this->ocupacion = $ocupacion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getPueblooriginario(){
        return $this->pueblooriginario;
    }

    public function getEscolaridad(){
        return $this->escolaridad;
    }

    public function getCursorepite(){
        return $this->cursorepite;
    }

    public function getSituacionlaboral(){
        return $this->situacionlaboral;
    }

    public function getOcupacion(){
        return $this->ocupacion;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function setId($id){
        $this->id = $id;
    }
}