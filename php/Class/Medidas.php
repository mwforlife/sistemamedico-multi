<?php
class Medidas
{
  //id	paciente	peso	talla	pcee	pe	pt	te	imc	clasifimc	pce	clasificacioncintura	registro
  private $id;
  private $paciente;
  private $peso;
  private $talla;
  private $pcee;
  private $pe;
  private $pt;
  private $te;
  private $imc;
  private $clasifimc;
  private $pce;
  private $clasificacioncintura;
  private $registro;

  function __construct($id, $paciente, $peso, $talla, $pcee, $pe, $pt, $te, $imc, $clasifimc, $pce, $clasificacioncintura, $registro)
  {
    $this->id = $id;
    $this->paciente = $paciente;
    $this->peso = $peso;
    $this->talla = $talla;
    $this->pcee = $pcee;
    $this->pe = $pe;
    $this->pt = $pt;
    $this->te = $te;
    $this->imc = $imc;
    $this->clasifimc = $clasifimc;
    $this->pce = $pce;
    $this->clasificacioncintura = $clasificacioncintura;
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

  function setPeso($peso)
  {
    $this->peso = $peso;
  }

  function getPeso()
  {
    return $this->peso;
  }

  function setTalla($talla)
  {
    $this->talla = $talla;
  }

  function getTalla()
  {
    return $this->talla;
  }

  function setPcee($pcee)
  {
    $this->pcee = $pcee;
  }

  function getPcee()
  {
    return $this->pcee;
  }

  function setPe($pe)
  {
    $this->pe = $pe;
  }

  function getPe()
  {
    return $this->pe;
  }

  function setPt($pt)
  {
    $this->pt = $pt;
  }

  function getPt()
  {
    return $this->pt;
  }

  function setTe($te)
  {
    $this->te = $te;
  }

  function getTe()
  {
    return $this->te;
  }

  function setImc($imc)
  {
    $this->imc = $imc;
  }

  function getImc()
  {
    return $this->imc;
  }

  function setClasifimc($clasifimc)
  {
    $this->clasifimc = $clasifimc;
  }

  function getClasifimc()
  {
    return $this->clasifimc;
  }

  function setPce($pce)
  {
    $this->pce = $pce;
  }

  function getPce()
  {
    return $this->pce;
  }

  function setClasificacioncintura($clasificacioncintura)
  {
    $this->clasificacioncintura = $clasificacioncintura;
  }

  function getClasificacioncintura()
  {
    return $this->clasificacioncintura;
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