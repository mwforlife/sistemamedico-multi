<?php
class Usuario{
    private $id;
    private $rut;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $email;
    private $direccion;
    private $region;
    private $comuna;
    private $profesion;
    private $proveniencia;
    private $telefono;
    private $password;
    private $registro;
    private $estado;

    public function __construct($id, $rut, $nombre, $apellido1, $apellido2, $email, $direccion, $region, $comuna, $profesion,$proveniencia, $telefono, $password, $registro,$estado){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->region = $region;
        $this->comuna = $comuna;
        $this->profesion = $profesion;
        $this->proveniencia = $proveniencia;
        $this->telefono = $telefono;
        $this->password = $password;
        $this->registro = $registro;
        $this->estado = $estado;
    }

    public function getId(){
        return $this->id;
    }

    public function getRut(){
        return $this->rut;
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

    public function getEmail(){
        return $this->email;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getComuna(){
        return $this->comuna;
    }

    public function getProfesion(){
        return $this->profesion;
    }

    public function getProveniencia(){
        return $this->proveniencia;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function getEstado(){
        return $this->estado;
    }
}