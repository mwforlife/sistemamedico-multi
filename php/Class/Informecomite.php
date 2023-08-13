<?php
class InformeComite
{
    public $id;
    public $paciente;
    public $diagnosticos;
    public $comite;
    public $ecog;
    public $histologico;
    public $invaciontumoral;
    public $mitotico;
    public $tnmprimario;
    public $tnmprimarioid;
    public $observacionprimario;
    public $tnmregionales;
    public $tnmregionalesid;
    public $observacionregionales;
    public $tnmdistancia;
    public $tnmdistanciaid;
    public $observaciondistancia;
    public $anamesis;
    public $cirugia;
    public $quimioterapia;
    public $radioterapia;
    public $tratamientosoncologicos;
    public $seguimientosintratamiento;
    public $completarestudios;
    public $revaluacionposterior;
    public $estudioclinico;
    public $observaciondesicion;
    public $consultade;
    public $consultadeid;
    public $programacionquirurgica;
    public $traslado;
    public $ciudadospaliativos;
    public $ingresohospitalario;
    public $observacionplan;
    public $resolucion;
    public $registro;

    // Constructor para inicializar los datos
    public function __construct($id, $paciente, $diagnosticos, $comite, $ecog, $histologico, $invaciontumoral, $mitotico, $tnmprimario, $tnmprimarioid, $observacionprimario, $tnmregionales, $tnmregionalesid, $observacionregionales, $tnmdistancia, $tnmdistanciaid, $observaciondistancia, $anamesis, $cirugia, $quimioterapia, $radioterapia, $tratamientosoncologicos, $seguimientosintratamiento, $completarestudios, $revaluacionposterior, $estudioclinico, $observaciondesicion, $consultade, $consultadeid, $programacionquirurgica, $traslado, $ciudadospaliativos, $ingresohospitalario, $observacionplan, $resolucion, $registro)
    {
        $this->id = $id;
        $this->paciente = $paciente;
        $this->diagnosticos = $diagnosticos;
        $this->comite = $comite;
        $this->ecog = $ecog;
        $this->histologico = $histologico;
        $this->invaciontumoral = $invaciontumoral;
        $this->mitotico = $mitotico;
        $this->tnmprimario = $tnmprimario;
        $this->tnmprimarioid = $tnmprimarioid;
        $this->observacionprimario = $observacionprimario;
        $this->tnmregionales = $tnmregionales;
        $this->tnmregionalesid = $tnmregionalesid;
        $this->observacionregionales = $observacionregionales;
        $this->tnmdistancia = $tnmdistancia;
        $this->tnmdistanciaid = $tnmdistanciaid;
        $this->observaciondistancia = $observaciondistancia;
        $this->anamesis = $anamesis;
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
        $this->resolucion = $resolucion;
        $this->registro = $registro;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getPaciente()
    {
        return $this->paciente;
    }

    public function getDiagnosticos()
    {
        return $this->diagnosticos;
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

    public function getInvaciontumoral()
    {
        return $this->invaciontumoral;
    }

    public function getMitotico()
    {
        return $this->mitotico;
    }

    public function getTnmprimario()
    {
        return $this->tnmprimario;
    }

    public function getTnmprimarioid()
    {
        return $this->tnmprimarioid;
    }

    public function getObservacionprimario()
    {
        return $this->observacionprimario;
    }

    public function getTnmregionales()
    {
        return $this->tnmregionales;
    }

    public function getTnmregionalesid()
    {
        return $this->tnmregionalesid;
    }

    public function getObservacionregionales()
    {
        return $this->observacionregionales;
    }

    public function getTnmdistancia()
    {
        return $this->tnmdistancia;
    }

    public function getTnmdistanciaid()
    {
        return $this->tnmdistanciaid;
    }

    public function getObservaciondistancia()
    {
        return $this->observaciondistancia;
    }

    public function getAnamesis()
    {
        return $this->anamesis;
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

    public function getTratamientosoncologicos()
    {
        return $this->tratamientosoncologicos;
    }

    public function getSeguimientosintratamiento()
    {
        return $this->seguimientosintratamiento;
    }

    public function getCompletarestudios()
    {
        return $this->completarestudios;
    }

    public function getRevaluacionposterior()
    {
        return $this->revaluacionposterior;
    }

    public function getEstudioclinico()
    {
        return $this->estudioclinico;
    }

    public function getObservaciondesicion()
    {
        return $this->observaciondesicion;
    }

    public function getConsultade()
    {
        return $this->consultade;
    }

    public function getConsultadeid()
    {
        return $this->consultadeid;
    }

    public function getProgramacionquirurgica()
    {
        return $this->programacionquirurgica;
    }

    public function getTraslado()
    {
        return $this->traslado;
    }

    public function getCiudadospaliativos()
    {
        return $this->ciudadospaliativos;
    }

    public function getIngresohospitalario()
    {
        return $this->ingresohospitalario;
    }

    public function getObservacionplan()
    {
        return $this->observacionplan;
    }

    public function getResolucion()
    {
        return $this->resolucion;
    }

    public function getRegistro()
    {
        return $this->registro;
    }


}
