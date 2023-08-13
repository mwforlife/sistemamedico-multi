<?php
class Signosvital
{
    //	id	paciente	fresp	psist	pdias	sat02	fc	tauxiliar	trect	totra	hgt	peso	registro
    private $id;
    private $paciente;
    private $fresp;
    private $psist;
    private $pdias;
    private $sat02;
    private $fc;
    private $tauxiliar;
    private $trect;
    private $totra;
    private $hgt;
    private $peso;
    private $registro;

    function __construct($id, $paciente, $fresp, $psist, $pdias, $sat02, $fc, $tauxiliar, $trect, $totra, $hgt, $peso, $registro)
    {
        $this->id = $id;
        $this->paciente = $paciente;
        $this->fresp = $fresp;
        $this->psist = $psist;
        $this->pdias = $pdias;
        $this->sat02 = $sat02;
        $this->fc = $fc;
        $this->tauxiliar = $tauxiliar;
        $this->trect = $trect;
        $this->totra = $totra;
        $this->hgt = $hgt;
        $this->peso = $peso;
        $this->registro = $registro;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setPaciente($paciente)
    {
        $this->paciente = $paciente;
    }

    function getPaciente()
    {
        return $this->paciente;
    }

    function setFresp($fresp)
    {
        $this->fresp = $fresp;
    }

    function getFresp()
    {
        return $this->fresp;
    }

    function setPsist($psist)
    {
        $this->psist = $psist;
    }

    function getPsist()
    {
        return $this->psist;
    }

    function setPdias($pdias)
    {
        $this->pdias = $pdias;
    }

    function getPdias()
    {
        return $this->pdias;
    }

    function setSat02($sat02)
    {
        $this->sat02 = $sat02;
    }

    function getSat02()
    {
        return $this->sat02;
    }

    function setFc($fc)
    {
        $this->fc = $fc;
    }

    function getFc()
    {
        return $this->fc;
    }

    function setTauxiliar($tauxiliar)
    {
        $this->tauxiliar = $tauxiliar;
    }

    function getTauxiliar()
    {
        return $this->tauxiliar;
    }

    function setTrect($trect)
    {
        $this->trect = $trect;
    }

    function getTrect()
    {
        return $this->trect;
    }

    function setTotra($totra)
    {
        $this->totra = $totra;
    }

    function getTotra()
    {
        return $this->totra;
    }

    function setHgt($hgt)
    {
        $this->hgt = $hgt;
    }

    function getHgt()
    {
        return $this->hgt;
    }

    function setPeso($peso)
    {
        $this->peso = $peso;
    }

    function getPeso()
    {
        return $this->peso;
    }

    function setRegistro($registro)
    {
        $this->registro = $registro;
    }

    function getRegistro()
    {
        return $this->registro;
    }
}