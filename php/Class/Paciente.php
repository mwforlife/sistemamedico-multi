<?php
class Paciente{
    private $id;
    private $tipoidentificacion;
    private $rut;
    private $identificacion;
    private $nacionalidad;
    private $paisorigen;
    private $email;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $genero;
    private $estadocivil;
    private $fechanacimiento;
    private $horanacimiento;
    private $fonomovil;
    private $fonofijo;
    private $nombresocial;
    private $funcionario;
    private $discapacidad;
    private $reciennacido;
    private $hijode;
    private $pesonacimiento;
    private $tallanacimiento;
    private $tipoparto;
    private $rol;
    private $fechafallecimiento;
    private $horafallecimiento;
    private $estado;
    private $empresa;
    private $registro;

    public function __construct($id, $tipoidentificacion, $rut, $identificacion, $nacionalidad, $paisorigen, $email, $nombre, $apellido1, $apellido2, $genero,$estadocivil, $fechanacimiento, $horanacimiento, $fonomovil, $fonofijo, $nombresocial, $funcionario, $discapacidad, $reciennacido, $hijode, $pesonacimiento,$tallanacimiento, $tipoparto, $rol, $fechafallecimiento, $horafallecimiento, $estado,$empresa, $registro){
        $this->id = $id;
        $this->tipoidentificacion = $tipoidentificacion;
        $this->rut = $rut;
        $this->identificacion = $identificacion;
        $this->nacionalidad = $nacionalidad;
        $this->paisorigen = $paisorigen;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->genero = $genero;
        $this->estadocivil = $estadocivil;
        $this->fechanacimiento = $fechanacimiento;
        $this->horanacimiento = $horanacimiento;
        $this->fonomovil = $fonomovil;
        $this->fonofijo = $fonofijo;
        $this->nombresocial = $nombresocial;
        $this->funcionario = $funcionario;
        $this->discapacidad = $discapacidad;
        $this->reciennacido = $reciennacido;
        $this->hijode = $hijode;
        $this->pesonacimiento = $pesonacimiento;
        $this->tallanacimiento = $tallanacimiento;
        $this->tipoparto = $tipoparto;
        $this->rol = $rol;
        $this->fechafallecimiento = $fechafallecimiento;
        $this->horafallecimiento = $horafallecimiento;
        $this->estado = $estado;
        $this->empresa = $empresa;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getTipoidentificacion(){
        return $this->tipoidentificacion;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getIdentificacion(){
        return $this->identificacion;
    }

    public function getNacionalidad(){
        return $this->nacionalidad;
    }

    public function getPaisorigen(){
        return $this->paisorigen;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido1(){
        return $this->apellido1;
    }

    public function getApellido2(){
        return $this->apellido2;
    }

    public function getGenero(){
        return $this->genero;
    }

    public function getEstadocivil(){
        return $this->estadocivil;
    }

    public function getFechanacimiento(){
        return $this->fechanacimiento;
    }

    public function getHoranacimiento(){
        return $this->horanacimiento;
    }

    public function getFonomovil(){
        return $this->fonomovil;
    }

    public function getFonofijo(){
        return $this->fonofijo;
    }

    public function getNombresocial(){
        return $this->nombresocial;
    }

    public function getFuncionario(){
        return $this->funcionario;
    }

    public function getDiscapacidad(){
        return $this->discapacidad;
    }

    public function getReciennacido(){
        return $this->reciennacido;
    }

    public function getHijode(){
        return $this->hijode;
    }

    public function getPesonacimiento(){
        return $this->pesonacimiento;
    }

    public function getTallanacimiento(){
        return $this->tallanacimiento;
    }

    public function getTipoparto(){
        return $this->tipoparto;
    }

    public function getRol(){
        return $this->rol;
    }

    public function getFechafallecimiento(){
        return $this->fechafallecimiento;
    }

    public function getHorafallecimiento(){
        return $this->horafallecimiento;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getRegistro(){
        return $this->registro;
    }
}