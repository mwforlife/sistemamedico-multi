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
    private $plantratamiento;
    private $modalidad;
    private $registro;

    public function __construct($id, $paciente, $usuario, $empresa, $atencion, $folio, $diagnostico, $diagnosticotexto, $diagnosticocie10, $diagnosticocie10texto, $tipodeatencion, $ecog, $ecogtexto, $ingreso, $receta, $reingreso, $anamesis, $estudiocomplementarios, $plantratamiento, $modalidad, $registro)
    {
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
        $this->plantratamiento = $plantratamiento;
        $this->modalidad = $modalidad;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPaciente()
    {
        return $this->paciente;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getAtencion()
    {
        return $this->atencion;
    }

    public function getFolio()
    {
        return $this->folio;
    }

    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    public function getDiagnosticotexto()
    {
        return $this->diagnosticotexto;
    }

    public function getDiagnosticocie10()
    {
        return $this->diagnosticocie10;
    }

    public function getDiagnosticocie10texto()
    {
        return $this->diagnosticocie10texto;
    }

    public function getTipodeatencion()
    {
        return $this->tipodeatencion;
    }

    public function getEcog()
    {
        return $this->ecog;
    }

    public function getEcogtexto()
    {
        return $this->ecogtexto;
    }

    public function getIngreso()
    {
        return $this->ingreso;
    }

    public function getReceta()
    {
        return $this->receta;
    }

    public function getReingreso()
    {
        return $this->reingreso;
    }

    public function getAnamesis()
    {
        return $this->anamesis;
    }

    public function getEstudiocomplementarios()
    {
        return $this->estudiocomplementarios;
    }

    public function getPlantratamiento()
    {
        return $this->plantratamiento;
    }

    public function getModalidad()
    {
        return $this->modalidad;
    }

    public function getRegistro()
    {
        return $this->registro;
    }
}
