<?php
class Inscripcion{
    private $id;
    private $paciente;
    private $ficha;
    private $fechaadmision;
    private $admision;
    private $inscrito;
    private $sector;
    private $tipoprevision;
    private $estadoafiliar;
    private $chilesolidario;
    private $pais;
    private $sename;
    private $ubicacionficha;
    private $saludmental;
    private $registro;

    public function __construct($id, $paciente, $ficha, $fechaadmision, $admision, $inscrito, $sector, $tipoprevision, $estadoafiliar, $chilesolidario, $pais, $sename, $ubicacionficha, $saludmental, $registro){
        $this->id = $id;
        $this->paciente = $paciente;
        $this->ficha = $ficha;
        $this->fechaadmision = $fechaadmision;
        $this->admision = $admision;
        $this->inscrito = $inscrito;
        $this->sector = $sector;
        $this->tipoprevision = $tipoprevision;
        $this->estadoafiliar = $estadoafiliar;
        $this->chilesolidario = $chilesolidario;
        $this->pais = $pais;
        $this->sename = $sename;
        $this->ubicacionficha = $ubicacionficha;
        $this->saludmental = $saludmental;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getFicha(){
        return $this->ficha;
    }

    public function getFechaadmision(){
        return $this->fechaadmision;
    }

    public function getAdmision(){
        return $this->admision;
    }

    public function getInscrito(){
        return $this->inscrito;
    }

    public function getSector(){
        return $this->sector;
    }

    public function getTipoprevision(){
        return $this->tipoprevision;
    }

    public function getEstadoafiliar(){
        return $this->estadoafiliar;
    }

    public function getChilesolidario(){
        return $this->chilesolidario;
    }

    public function getPais(){
        return $this->pais;
    }

    public function getSename(){
        return $this->sename;
    }

    public function getUbicacionficha(){
        return $this->ubicacionficha;
    }

    public function getSaludmental(){
        return $this->saludmental;
    }

    public function getRegistro(){
        return $this->registro;
    }
}