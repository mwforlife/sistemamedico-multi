<?php
class Receta {
    public $id;
    public $paciente;
    public $usuario;
    public $empresa;
    public $consulta;
    public $fecha;
    public $folio;
    public $estadio;
    public $nivel;
    public $ges;
    public $peso;
    public $talla;
    public $scorporal;
    public $creatinina;
    public $auc;
    public $fechaadministracion;
    public $pendiente;
    public $nciclo;
    public $anticipada;
    public $curativo;
    public $paliativo;
    public $adyuvante;
    public $concomitante;
    public $noeadyuvante;
    public $primeringreso;
    public $traemedicamentos;
    public $diabetes;
    public $hipertension;
    public $alergias;
    public $otrocor;
    public $detallealergias;
    public $otrcormo;
    public $urgente;
    public $esquema;
    public $observacion;
    public $estado;
    public $carboplatino;
    public $registro;
    
    public function __construct($data) {
        $this->id = $data['id'];
        $this->paciente = $data['paciente'];
        $this->usuario = $data['usuario'];
        $this->empresa = $data['empresa'];
        $this->consulta = $data['consulta'];
        $this->fecha = $data['fecha'];
        $this->folio = $data['folio'];
        $this->estadio = $data['estadio'];
        $this->nivel = $data['nivel'];
        $this->ges = $data['ges'];
        $this->peso = $data['peso'];
        $this->talla = $data['talla'];
        $this->scorporal = $data['scorporal'];
        $this->creatinina = $data['creatinina'];
        $this->auc = $data['auc'];
        $this->fechaadministracion = $data['fechaadministracion'];
        $this->pendiente = $data['pendiente'];
        $this->nciclo = $data['nciclo'];
        $this->anticipada = $data['anticipada'];
        $this->curativo = $data['curativo'];
        $this->paliativo = $data['paliativo'];
        $this->adyuvante = $data['adyuvante'];
        $this->concomitante = $data['concomitante'];
        $this->noeadyuvante = $data['neoadyuvante'];
        $this->primeringreso = $data['primeringreso'];
        $this->traemedicamentos = $data['traemedicamentos'];
        $this->diabetes = $data['diabetes'];
        $this->hipertension = $data['hipertension'];
        $this->alergias = $data['alergias'];
        $this->otrocor = $data['otrocor'];
        $this->detallealergias = $data['detallealergias'];
        $this->otrcormo = $data['otrcormo'];
        $this->urgente = $data['urgente'];
        $this->esquema = $data['esquema'];
        $this->observacion = $data['observacion'];
        $this->estado = $data['estado'];
        $this->carboplatino = $data['carboplatino'];
        $this->registro = $data['registro'];
    }

    public function getId() {
        return $this->id;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getConsulta() {
        return $this->consulta;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getFolio() {
        return $this->folio;
    }

    public function getEstadio() {
        return $this->estadio;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getGes() {
        return $this->ges;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getTalla() {
        return $this->talla;
    }

    public function getScorporal() {
        return $this->scorporal;
    }

    public function getCreatinina() {
        return $this->creatinina;
    }

    public function getAuc() {
        return $this->auc;
    }

    public function getFechaAdministracion() {
        return $this->fechaadministracion;
    }

    public function getPendiente() {
        return $this->pendiente;
    }

    public function getNciclo() {
        return $this->nciclo;
    }

    public function getAnticipada() {
        return $this->anticipada;
    }

    public function getCurativo() {
        return $this->curativo;
    }

    public function getPaliativo() {
        return $this->paliativo;
    }

    public function getAdyuvante() {
        return $this->adyuvante;
    }

    public function getConcomitante() {
        return $this->concomitante;
    }

    public function getNoeAdyuvante() {
        return $this->noeadyuvante;
    }

    public function getPrimeraIngreso() {
        return $this->primeringreso;
    }

    public function getTraeMedicamentos() {
        return $this->traemedicamentos;
    }

    public function getDiabetes() {
        return $this->diabetes;
    }

    public function getHipertension() {
        return $this->hipertension;
    }

    public function getAlergias() {
        return $this->alergias;
    }

    public function getOtroCor() {
        return $this->otrocor;
    }

    public function getDetalleAlergias() {
        return $this->detallealergias;
    }

    public function getOtroCorMo() {
        return $this->otrcormo;
    }

    public function getUrgente() {
        return $this->urgente;
    }

    public function getEsquema() {
        return $this->esquema;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCarboplatino() {
        return $this->carboplatino;
    }

    public function getRegistro() {
        return $this->registro;
    }
}
