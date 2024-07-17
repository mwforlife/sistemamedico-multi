<?php
class Consulta
{
    private $id;
    private $paciente;
    private $usuario;
    private $empresa;
    private $atencion;
    private $folio;
    private $diagnostico;
    private $diagnosticotexto;
    private $diagnosticocie10;
    private $diagnosticocie10texto;
    private $tipodeatencion;
    private $ecog;
    private $ecogtexto;
    private $ingreso;
    private $receta;
    private $reingreso;
    private $anamesis;
    private $estudiocomplementarios;
    private $cirugia;
    private $quimioterapia;
    private $radioterapia;
    private $tratamientosoncologicos;
    private $seguimientosintratamiento;
    private $completarestudios;
    private $revaluacionposterior;
    private $estudioclinico;
    private $observaciondesicion;
    private $consultade;
    private $consultadeid;
    private $programacionquirurgica;
    private $traslado;
    private $ciudadospaliativos;
    private $ingresohospitalario;
    private $observacionplan;
    private $modalidad;
    private $registro;

    public function __construct($id, $paciente, $usuario, $empresa, $atencion, $folio, $diagnostico, $diagnosticotexto, $diagnosticocie10, $diagnosticocie10texto, $tipodeatencion, $ecog, $ecogtexto, $ingreso, $receta, $reingreso, $anamesis, $estudiocomplementarios, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $modalidad, $registro){
        $this->id = $id;
        $this->paciente = $paciente;
        $this->usuario = $usuario;
        $this->empresa = $empresa;
        $this->atencion = $atencion;
        $this->folio = $folio;
        $this->diagnostico = $diagnostico;
        $this->diagnosticotexto = $diagnosticotexto;
        $this->diagnosticocie10 = $diagnosticocie10;
        $this->diagnosticocie10texto = $diagnosticocie10texto;
        $this->tipodeatencion = $tipodeatencion;
        $this->ecog = $ecog;
        $this->ecogtexto = $ecogtexto;
        $this->ingreso = $ingreso;
        $this->receta = $receta;
        $this->reingreso = $reingreso;
        $this->anamesis = $anamesis;
        $this->estudiocomplementarios = $estudiocomplementarios;
        $this->cirugia = $cirugia;
        $this->quimioterapia = $quimioterapia;
        $this->radioterapia = $radioterapia;
        $this->tratamientosoncologicos = $tratamientosoncologicos;
        $this->seguimientosintratamiento = $seguimientosintratamiento;
        $this->completarestudios = $completarestudios;
        $this->revaluacionposterior = $revaluacionposterior;
        $this->estudioclinico = $estudioclinico;
        $this->observaciondesicion = $observaciondesicion;
        $this->consultade = $consultade;
        $this->consultadeid = $consultadeid;
        $this->programacionquirurgica = $programacionquirurgica;
        $this->traslado = $traslado;
        $this->ciudadospaliativos = $ciudadospaliativos;
        $this->ingresohospitalario = $ingresohospitalario;
        $this->observacionplan = $observacionplan;
        $this->modalidad = $modalidad;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPaciente(){
        return $this->paciente;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getAtencion(){
        return $this->atencion;
    }

    public function getFolio(){
        return $this->folio;
    }

    public function getDiagnostico(){
        return $this->diagnostico;
    }

    public function getDiagnosticotexto(){
        return $this->diagnosticotexto;
    }

    public function getDiagnosticocie10(){
        return $this->diagnosticocie10;
    }

    public function getDiagnosticocie10texto(){
        return $this->diagnosticocie10texto;
    }

    public function getTipodeatencion(){
        return $this->tipodeatencion;
    }

    public function getEcog(){
        return $this->ecog;
    }

    public function getEcogtexto(){
        return $this->ecogtexto;
    }

    public function getIngreso(){
        return $this->ingreso;
    }

    public function getReceta(){
        return $this->receta;
    }

    public function getReingreso(){
        return $this->reingreso;
    }

    public function getAnamesis(){
        return $this->anamesis;
    }

    public function getEstudiocomplementarios(){
        return $this->estudiocomplementarios;
    }

    public function getCirugia(){
        return $this->cirugia;
    }

    public function getQuimioterapia(){
        return $this->quimioterapia;
    }

    public function getRadioterapia(){
        return $this->radioterapia;
    }

    public function getTratamientosoncologicos(){
        return $this->tratamientosoncologicos;
    }

    public function getSeguimientosintratamiento(){
        return $this->seguimientosintratamiento;
    }

    public function getCompletarestudios(){
        return $this->completarestudios;
    }

    public function getRevaluacionposterior(){
        return $this->revaluacionposterior;
    }

    public function getEstudioclinico(){
        return $this->estudioclinico;
    }

    public function getObservaciondesicion(){
        return $this->observaciondesicion;
    }

    public function getConsultade(){
        return $this->consultade;
    }

    public function getConsultadeid(){
        return $this->consultadeid;
    }

    public function getProgramacionquirurgica(){
        return $this->programacionquirurgica;
    }

    public function getTraslado(){
        return $this->traslado;
    }

    public function getCiudadospaliativos(){
        return $this->ciudadospaliativos;
    }

    public function getIngresohospitalario(){
        return $this->ingresohospitalario;
    }

    public function getObservacionplan(){
        return $this->observacionplan;
    }

    public function getModalidad(){
        return $this->modalidad;
    }

    public function getRegistro(){
        return $this->registro;
    }
}
