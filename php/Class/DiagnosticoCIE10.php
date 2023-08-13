<?php
class DiagnosticoCIE10{
    private $id;
    private $codigo;
    private $descripcion;
    private $nodo_final;
    private $manifestacion_no_dp;
    private $perinatal;
    private $pediatrico;
    private $obstetrico;
    private $adulto;
    private $mujer;
    private $hombre;
    private $poa_exempto;
    private $dp_no_principal;
    private $vcdp;
    private $registro;

    public function __construct($id, $codigo, $descripcion, $nodo_final, $manifestacion_no_dp, $perinatal, $pediatrico, $obstetrico, $adulto, $mujer, $hombre, $poa_exempto, $dp_no_principal, $vcdp, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->nodo_final = $nodo_final;
        $this->manifestacion_no_dp = $manifestacion_no_dp;
        $this->perinatal = $perinatal;
        $this->pediatrico = $pediatrico;
        $this->obstetrico = $obstetrico;
        $this->adulto = $adulto;
        $this->mujer = $mujer;
        $this->hombre = $hombre;
        $this->poa_exempto = $poa_exempto;
        $this->dp_no_principal = $dp_no_principal;
        $this->vcdp = $vcdp;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getNodoFinal(){
        return $this->nodo_final;
    }

    public function getManifestacionNoDP(){
        return $this->manifestacion_no_dp;
    }

    public function getPerinatal(){
        return $this->perinatal;
    }

    public function getPediatrico(){
        return $this->pediatrico;
    }

    public function getObstetrico(){
        return $this->obstetrico;
    }

    public function getAdulto(){
        return $this->adulto;
    }

    public function getMujer(){
        return $this->mujer;
    }

    public function getHombre(){
        return $this->hombre;
    }

    public function getPoaExempto(){
        return $this->poa_exempto;
    }

    public function getDPNoPrincipal(){
        return $this->dp_no_principal;
    }

    public function getVCDP(){
        return $this->vcdp;
    }

    public function getRegistro(){
        return $this->registro;
    }
}