<?php
class PacienteDiagnosticos{
    private $id;
    private $diagnosticos;
    private $diagnosticosid;
    private $diagnosticocieotop;
    private $diagnosticocieotopid;
    private $diagnosticocieomor;
    private $diagnosticocieomorid;
    private $diagnosticocie10;
    private $diagnosticocie10id;
    private $fechabiopsia;
    private $reingreso;
    private $registro;
    public function __construct($id, $diagnosticos, $diagnosticosid, $diagnosticocieotop, $diagnosticocieotopid, $diagnosticocieomor, $diagnosticocieomorid, $diagnosticocie10, $diagnosticocie10id, $fechabiopsia, $reingreso, $registro){
        $this->id = $id;
        $this->diagnosticos = $diagnosticos;
        $this->diagnosticosid = $diagnosticosid;
        $this->diagnosticocieotop = $diagnosticocieotop;
        $this->diagnosticocieotopid = $diagnosticocieotopid;
        $this->diagnosticocieomor = $diagnosticocieomor;
        $this->diagnosticocieomorid = $diagnosticocieomorid;
        $this->diagnosticocie10 = $diagnosticocie10;
        $this->diagnosticocie10id = $diagnosticocie10id;
        $this->fechabiopsia = $fechabiopsia;
        $this->reingreso = $reingreso;
        $this->registro = $registro;
    }
    public function getId(){
        return $this->id;
    }
    public function getDiagnosticos(){
        return $this->diagnosticos;
    }
    public function getDiagnosticosid(){
        return $this->diagnosticosid;
    }
    public function getDiagnosticocieotop(){
        return $this->diagnosticocieotop;
    }
    public function getDiagnosticocieotopid(){
        return $this->diagnosticocieotopid;
    }
    public function getDiagnosticocieomor(){
        return $this->diagnosticocieomor;
    }
    public function getDiagnosticocieomorid(){
        return $this->diagnosticocieomorid;
    }
    public function getDiagnosticocie10(){
        return $this->diagnosticocie10;
    }
    public function getDiagnosticocie10id(){
        return $this->diagnosticocie10id;
    }
    public function getFechabiopsia(){
        return $this->fechabiopsia;
    }
    public function getReingreso(){
        return $this->reingreso;
    }
    public function getRegistro(){
        return $this->registro;
    }
}