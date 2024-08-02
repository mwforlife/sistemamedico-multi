<?php
class InformeComite
{
    private $id;
    private $folio;
    private $paciente;
    private $comite;
    private $ecog;
    private $histologico;
    private $invasiontumoral;
    private $mitotico;
    private $observaciontnm;
    private $anamnesis;
    private $cirugia;
    private $quimioterapia;
    private $radioterapia;
    private $otros;
    private $seguimiento;
    private $completar;
    private $revaluacion;
    private $estudioclinicno;
    private $observacionesdecision;
    private $consultadetext;
    private $consultade;
    private $programacion;
    private $traslado;
    private $paliativos;
    private $ingreso;
    private $observacionplan;
    private $resolucion;
    private $empresa;
    private $registro;

    public function __construct($id, $folio, $paciente, $comite, $ecog, $histologico, $invasiontumoral, $mitotico,$observaciontnm, $anamnesis, $cirugia, $quimioterapia, $radioterapia, $otros, $seguimiento, $completar, $revaluacion, $estudioclinicno, $observacionesdecision, $consultadetext, $consultade, $programacion, $traslado, $paliativos, $ingreso, $observacionplan, $resolucion, $empresa, $registro)
    {
        $this->id = $id;
        $this->folio = $folio;
        $this->paciente = $paciente;
        $this->comite = $comite;
        $this->ecog = $ecog;
        $this->histologico = $histologico;
        $this->invasiontumoral = $invasiontumoral;
        $this->mitotico = $mitotico;
        $this->observaciontnm = $observaciontnm;
        $this->anamnesis = $anamnesis;
        $this->cirugia = $cirugia;
        $this->quimioterapia = $quimioterapia;
        $this->radioterapia = $radioterapia;
        $this->otros = $otros;
        $this->seguimiento = $seguimiento;
        $this->completar = $completar;
        $this->revaluacion = $revaluacion;
        $this->estudioclinicno = $estudioclinicno;
        $this->observacionesdecision = $observacionesdecision;
        $this->consultadetext = $consultadetext;
        $this->consultade = $consultade;
        $this->programacion = $programacion;
        $this->traslado = $traslado;
        $this->paliativos = $paliativos;
        $this->ingreso = $ingreso;
        $this->observacionplan = $observacionplan;
        $this->resolucion = $resolucion;
        $this->empresa = $empresa;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFolio()
    {
        return $this->folio;
    }

    public function getPaciente()
    {
        return $this->paciente;
    }

    public function getComite()
    {
        return $this->comite;
    }

    public function getEcog()
    {
        return $this->ecog;
    }

    public function getHistologico()
    {
        return $this->histologico;
    }

    public function getInvasionTumoral()
    {
        return $this->invasiontumoral;
    }

    public function getMitotico()
    {
        return $this->mitotico;
    }

    public function getObservacionTnm()
    {
        return $this->observaciontnm;
    }

    public function getAnamnesis()
    {
        return $this->anamnesis;
    }

    public function getCirugia()
    {
        return $this->cirugia;
    }

    public function getQuimioterapia()
    {
        return $this->quimioterapia;
    }

    public function getRadioterapia()
    {
        return $this->radioterapia;
    }

    public function getOtros()
    {
        return $this->otros;
    }

    public function getSeguimiento()
    {
        return $this->seguimiento;
    }

    public function getCompletar()
    {
        return $this->completar;
    }

    public function getRevaluacion()
    {
        return $this->revaluacion;
    }

    public function getEstudioClinico()
    {
        return $this->estudioclinicno;
    }

    public function getObservacionesDecision()
    {
        return $this->observacionesdecision;
    }

    public function getConsultaDeText()
    {
        return $this->consultadetext;
    }

    public function getConsultaDe()
    {
        return $this->consultade;
    }

    public function getProgramacion()
    {
        return $this->programacion;
    }

    public function getTraslado()
    {
        return $this->traslado;
    }

    public function getPaliativos()
    {
        return $this->paliativos;
    }

    public function getIngreso()
    {
        return $this->ingreso;
    }

    public function getObservacionPlan()
    {
        return $this->observacionplan;
    }

    public function getResolucion()
    {
        return $this->resolucion;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getRegistro()
    {
        return $this->registro;
    }


}
