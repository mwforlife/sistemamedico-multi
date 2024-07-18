<?php
class PacienteDiagnosticos{
    private $id;
    private $informecomite;
    private $diagnosticos;
    private $diagnosticosid;
    private $diagnosticocie10;
    private $diagnosticocie10id;
    private $fechabiopsia;
    private $reingreso;
    private $registro;
    public function __construct($id, $informecomite, $diagnosticos, $diagnosticosid, $diagnosticocie10, $diagnosticocie10id, $fechabiopsia, $reingreso, $registro){
        $this->id = $id;
        $this->informecomite = $informecomite;
        $this->diagnosticos = $diagnosticos;
        $this->diagnosticosid = $diagnosticosid;
        $this->diagnosticocie10 = $diagnosticocie10;
        $this->diagnosticocie10id = $diagnosticocie10id;
        $this->fechabiopsia = $fechabiopsia;
        $this->reingreso = $reingreso;
        $this->registro = $registro;
    }
    public function getId(){
        return $this->id;
    }
    public function getInformecomite(){
        return $this->informecomite;
    }
    public function getDiagnosticos(){
        return $this->diagnosticos;
    }
    public function getDiagnosticosid(){
        return $this->diagnosticosid;
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