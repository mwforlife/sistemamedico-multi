
/***Inicio Profesional Comité */
//Crear una clase de profesionales comité
//Atributos
//id, rut, nombre, profesion
//Métodos
//constructor, getters y setters
//Crear un array de objetos de la clase comité

//Creando la clase Profesionales Comite
class Profesionalescomite {
    constructor(id, rut, nombre, profesion,cargo,cargoname) {
        this.id = id;
        this.rut = rut;
        this.nombre = nombre;
        this.profesion = profesion;
        this.cargo = cargo;
        this.cargoname = cargoname;
    }
    get id() {
        return this._id;
    }
    set id(id) {
        this._id = id;
    }
    get rut() {
        return this._rut;
    }
    set rut(rut) {
        this._rut = rut;
    }
    get nombre() {
        return this._nombre;
    }
    set nombre(nombre) {
        this._nombre = nombre;
    }
    get profesion() {
        return this._profesion;
    }
    set profesion(profesion) {
        this._profesion = profesion;
    }
    get cargo() {
        return this._cargo;
    }
    set cargo(cargo) {
        this._cargo = cargo;
    }
    get cargoname() {
        return this._cargoname;
    }
    set cargoname(cargoname) {
        this._cargoname = cargoname;
    }
}

//Crear un array vacio de objetos de la clase Comite
var profesionales = [];

//Función para mostrar el array de objetos de la clase Comite
function mostrarProfesionalesComite() {
    var texto = "";
    //Recorrer el array de objetos de la clase con un foreach
    profesionales.forEach(function (elemento, indice, array) {
        texto += "<tr>";
        texto += "<td>" + elemento.rut + "</td>";
        texto += "<td>" + elemento.nombre + "</td>";
        texto += "<td>" + elemento.profesion + "</td>";
        texto += "<td>" + elemento.cargoname + "</td>";
        //Agregar boton para eliminar
        texto += "<td><button type='button' class='btn btn-outline-danger btn-sm' onclick='eliminarProfesionalesComite(" + elemento.id + ")'><i class='fas fa-trash-alt'></i></button></td>";
        texto += "</tr>";
    });
    $("#profesionalescontent").html(texto);
}

//Función para verificar si existe un id en el array de objetos de la clase Comite
function existeProfesionalesComite(id) {
    var response = false;
    //Recorrer el array de objetos de la clase con un foreach
    profesionales.forEach(function (elemento, indice, array) {
        //Si el id del elemento es igual al id del parametro
        var idcomp = elemento.id;
        //Convertir a int
        idcomp = parseInt(idcomp);
        id = parseInt(id);
        //Si el id del elemento es igual al id del parametro
        if (idcomp == id) {
            //Respuesta verdadera
            response = true;
        }
    });
    //Retornar respuesta
    return response;
}


//Función para agregar un objeto al array de objetos de la clase Comite
function agregarProfesionalesComite(id, rut, nombre, profesion,cargo,cargoname) {
    //Agregar un objeto al array de objetos de la clase Comite
    profesionales.push(new Profesionalescomite(id, rut, nombre, profesion,cargo,cargoname));
    //Mostrar el array de objetos de la clase Comite
    mostrarProfesionalesComite();
}

//Función para eliminar un objeto del array de objetos de la clase Comite
function eliminarProfesionalesComite(id) {
    //Preguntar si esta seguro de eliminar el objeto
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        //Si se confirma la eliminacion
        if (result.isConfirmed) {
            //Recorrer el array de objetos de la clase con un foreach
            profesionales.forEach(function (elemento, indice, array) {
                //Si el id del elemento es igual al id del parametro
                if (elemento.id == id) {
                    //Eliminar el elemento del array
                    profesionales.splice(indice, 1);
                }
            });
            //Mostrar el array de objetos de la clase Comite
            mostrarProfesionalesComite();
            //Mostrar mensaje de confirmacion
            ToastifySuccess('Registro eliminado correctamente');
        } else {
            //Mostrar mensaje de cancelacion
            ToastifyError('Operacion cancelada');
        }
    });
}
/*****Fin Profesionales COmité */
/*************************************************************************************************************************************************************************** */
/***Inicio Pacientes Comité */
//Crear una clase de pacientes comité
//Atributos
//id, rut, nombre, contacto, observaciones
//Métodos
//constructor, getters y setters
//Crear un array de objetos de la clase comité

//Creando la clase Pacientes Comite
class Pacientescomite {
    constructor(id, rut, nombre, contacto, profesionalid, profesional, observaciones) {
        this.id = id;
        this.rut = rut;
        this.nombre = nombre;
        this.contacto = contacto;
        this.profesionalid = profesionalid;
        this.profesional = profesional;
        this.observaciones = observaciones;
    }
    get id() {
        return this._id;
    }
    set id(id) {
        this._id = id;
    }
    get rut() {
        return this._rut;
    }
    set rut(rut) {
        this._rut = rut;
    }
    get nombre() {
        return this._nombre;
    }
    set nombre(nombre) {
        this._nombre = nombre;
    }
    get contacto() {
        return this._contacto;
    }
    set contacto(contacto) {
        this._contacto = contacto;
    }
    get profesionalid() {
        return this._profesionalid;
    }
    set profesionalid(profesionalid) {
        this._profesionalid = profesionalid;
    }
    get profesional() {
        return this._profesional;
    }
    set profesional(profesional) {
        this._profesional = profesional;
    }
    get observaciones() {
        return this._observaciones;
    }
    set observaciones(observaciones) {
        this._observaciones = observaciones;
    }
}

//Crear un array vacio de objetos de la clase Comite
var pacientes = [];


//Función para mostrar el array de objetos de la clase Comite
function mostrarPacientesComite() {
    var texto = "";
    //Recorrer el array de objetos de la clase con un foreach
    pacientes.forEach(function (elemento, indice, array) {
        texto += "<tr>";
        texto += "<td>" + elemento.rut + "</td>";
        texto += "<td>" + elemento.nombre + "</td>";
        texto += "<td>" + elemento.contacto + "</td>";
        texto += "<td>" + elemento.profesional + "</td>";
        texto += "<td>" + elemento.observaciones + "</td>";
        //Agregar boton para eliminar
        texto += "<td><button type='button' class='btn btn-outline-danger btn-sm' onclick='eliminarPacientesComite(" + elemento.id + ")'><i class='fas fa-trash-alt'></i></button></td>";
        texto += "</tr>";
    });
    $("#pacientescontent").html(texto);
}

//Función para verificar si existe un id en el array de objetos de la clase Comite
function existePacientesComite(id) {
    //Respuesta por defecto
    var response = false;
    //Recorrer el array de objetos de la clase con un foreach
    pacientes.forEach(function (elemento, indice, array) {
        //Si el id del elemento es igual al id del parametro
        var idcomp = elemento.id;
        //Convertir a int
        idcomp = parseInt(idcomp);
        id = parseInt(id);
        //Si el id del elemento es igual al id del parametro
        if (idcomp == id) {
            //Respuesta verdadera
            response = true;
        }
    });
    //Retornar respuesta
    return response;
}

//Función para agregar un objeto al array de objetos de la clase Comite
function agregarPacientesComite(id, rut, nombre, contacto, profesionalid, profesional, observaciones) {
    //Agregar un objeto al array de objetos de la clase Comite
    pacientes.push(new Pacientescomite(id, rut, nombre, contacto, profesionalid, profesional, observaciones));
    //Mostrar el array de objetos de la clase Comite
    mostrarPacientesComite();
}

//Función para eliminar un objeto del array de objetos de la clase Comite
function eliminarPacientesComite(id) {
    //Preguntar si esta seguro de eliminar el objeto
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        //Si se confirma la eliminacion
        if (result.isConfirmed) {
            //Recorrer el array de objetos de la clase con un foreach
            pacientes.forEach(function (elemento, indice, array) {
                //Si el id del elemento es igual al id del parametro
                if (elemento.id == id) {
                    //Eliminar el elemento del array
                    pacientes.splice(indice, 1);
                }
            });
            //Mostrar el array de objetos de la clase Comite
            mostrarPacientesComite();
            //Mostrar mensaje de confirmacion
            ToastifySuccess('Registro eliminado correctamente');
        } else {
            //Mostrar mensaje de cancelacion
            ToastifyError('Operacion cancelada');
        }
    });
}
/*****Fin Pacientes COmité */
/*************************************************************************************************************************************************************************** */
function listardatos() {
    mostrarProfesionalesComite();
    mostrarPacientesComite();
}

//Agregar Paciente
function agregarpaciente(id, rut, nombre, contacto) {
    var result = existePacientesComite(id);
    if (result == true) {
        ToastifyError("El paciente ya se encuentra agregado");
        return;
    }
    $("#idpaciente").val(id);
    $("#rutpaciente").val(rut);
    $("#nombrepaciente").val(nombre);
    $("#contactopaciente").val(contacto);
    $("#modalpacientes1").modal("show");
}

function buscarmedico() {
    $("#modalmedico").modal("show");
}

function agregarmedico(id, rut, nombre, profesion) {
    $("#idmedicoresponsable").val(id);
    $("#medicoresponsable").val(nombre);
    $("#modalmedico").modal("hide");
}

function guardarpaciente() {
    var observacionespaciente = $("#observacion").val();
    if (observacionespaciente.trim().length <= 0) {
        ToastifyError("Debe ingresar una observación");
        return;
    }

    var idpaciente = $("#idpaciente").val();
    var rutpaciente = $("#rutpaciente").val();
    var nombrepaciente = $("#nombrepaciente").val();
    var contactopaciente = $("#contactopaciente").val();
    var idmedicoresponsable = $("#idmedicoresponsable").val();
    var medicoresponsable = $("#medicoresponsable").val();
    var observacionespaciente = $("#observacion").val();

    if (idmedicoresponsable > 0) {

        var result = existePacientesComite(idpaciente);
        if (result == true) {
            ToastifyError("El paciente ya se encuentra agregado");
        } else {
            agregarPacientesComite(idpaciente, rutpaciente, nombrepaciente, contactopaciente, idmedicoresponsable, medicoresponsable, observacionespaciente);
            //Limpiar campos
            $("#observacion").val("");
            $("#idpaciente").val("");
            $("#rutpaciente").val("");
            $("#nombrepaciente").val("");
            $("#contactopaciente").val("");
            $("#idmedicoresponsable").val("");
            $("#medicoresponsable").val("");
            $("#observacionespaciente").val("");
            $("#modalpacientes1").modal("hide");
            mostrarPacientesComite();
            ToastifySuccess("Paciente agregado correctamente");

        }
    } else {
        ToastifyError("Debe seleccionar un profesional");
        $("#modalmedico").modal("show");
    }
}

function finalizarcomite(){
    var idcomite = $("#idcomite").val();
    if(idcomite<=0){
        ToastifyError("Debe seleccionar o Registrar un comité");
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/insert/finalizarcomite.php",
        data: {
            idcomite: idcomite,
            profesionales: profesionales,
            pacientes: pacientes
        },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Comité finalizado correctamente");
                setTimeout(function () {
                   window.location.href = "listadocomite.php";
                }, 1000);
            } else  {
                ToastifyError(response);
            }
        }
    });
}


function actualizarcomite(){
    var idcomite = $("#idcomite").val();
    if(idcomite<=0){
        ToastifyError("Debe seleccionar o Registrar un comité");
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/insert/finalizarcomite.php",
        data: {
            idcomite: idcomite,
            profesionales: profesionales,
            pacientes: pacientes
        },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Datos actualizados correctamente");
                setTimeout(function () {
                   window.location.href = "listadocomite.php";
                }, 1000);
            } else {
                ToastifyError(response);
            }
        }
    });
}

/****************************************************************Cargar datos profesionales pacientes ********************************************************/
function cargarprofesionales(id){
    $.ajax({
        type: "POST",
        url: "php/listado/cargarprofesionales.php",
        data: {
            idcomite: id
        },
        success: function (response) {
            //Recibir el JSON
            var info = JSON.parse(response);info.forEach(function (elemento, indice, array) {
                //Agregar el elemento al array de profesionales
                agregarProfesionalesComite(elemento._id, elemento._rut, elemento._nombre, elemento._profesion,elemento._cargo,elemento._cargoname);
            }
            );
            //Mostrar el array de objetos de la clase Comite
            mostrarProfesionalesComite();
        }
    });
}
function cargarpacientes(id){
    $.ajax({
        type: "POST",
        url: "php/listado/cargarpacientes.php",
        data: {
            idcomite: id
        },
        success: function (response) {
            //Recibir el JSON
            var info = JSON.parse(response);
            info.forEach(function (elemento, indice, array) {
                //Agregar el elemento al array de pacientes
                agregarPacientesComite(elemento._id, elemento._rut, elemento._nombre, elemento._contacto, elemento._profesionalid, elemento._profesional, elemento._observaciones);
            });
            //Mostrar el array de objetos de la clase Comite
            mostrarPacientesComite();
        }
    });
}