function sessionReserva() {
    var id = $("#idUsuario").val();
    if (id > 0) {
        $.ajax({
            url: "php/validation/sessions.php",
            type: "POST",
            data: { action: 'sessionReserva', id: id },
            success: function (data) {
                location.reload();
            },
        });
    } else {
        console.log("No se pude crear la session");
    }
}

function cargarHorario($id) {
    $.ajax({
        url: "php/charge/horario.php",
        type: "POST",
        data: { action: 'cargarHorario', id: $id },
        success: function (data) {
            //Recorrer el array de datos
            var datos = JSON.parse(data);
            var horario = "";
            for (var i = 0; i < datos.length; i++) {
                if (datos[i].estado == 1) {
                    //Dispobible
                    horario += "<div class='col-md-2 col-sm-6 col-xs-12'>";
                    horario += "<input type='radio' class='btn-check' title='Disponible' name='hora' id='hora" + datos[i].id + "' autocomplete='off' value='" + datos[i].id + "'>";
                    horario += "<label class='btn btn-outline-primary btn-block w-100 mt-2' title='Disponible' for='hora" + datos[i].id + "'>" + datos[i].start + " - " + datos[i].end + "</label>";
                    horario += "</div>";
                } else if (datos[i].estado == 2) {
                    //Reservado
                    horario += "<div class='col-md-2 col-sm-6 col-xs-12' title='Reservada'>";
                    horario += "<input type='radio' class='btn-check' title='Reservada' name='hora' id='hora" + datos[i].id + "' autocomplete='off' value='" + datos[i].id + "' disabled>";
                    horario += "<label class='btn btn-success btn-block w-100 mt-2' title='Reservada' for='hora" + datos[i].id + "'>" + datos[i].start + " - " + datos[i].end + "</label>";
                    horario += "</div>";
                } else if (datos[i].estado == 3) {
                    //Cancelado
                    horario += "<div class='col-md-2 col-sm-6 col-xs-12' title='No Disponible'> ";
                    horario += "<input type='radio' class='btn-check' title='No Disponible' name='hora' id='hora" + datos[i].id + "' autocomplete='off' value='" + datos[i].id + "' disabled>";
                    horario += "<label class='btn btn-secondary btn-block w-100 mt-2' title='No Disponible' for='hora" + datos[i].id + "'>" + datos[i].start + " - " + datos[i].end + "</label>";
                    horario += "</div>";
                }

            }

            $(".horario").html(horario);
        },
    });
}

function buscarpacienterun(element) {
    var run = element.value;
    //VAlidar run
    if (run.length > 9) {
        if (validarRut(run)) {
            $.ajax({
                url: "php/charge/paciente.php",
                type: "POST",
                data: { action: 'buscarpacienterun', run: run },
                success: function (data) {
                    var datos = JSON.parse(data);
                    if (datos.error == false) {
                        var paciente = "";
                        paciente += "<div class='alert alert-success' role='alert'>";
                        paciente += "<div class='alert-heading d-flex align-items-center'>";
                        paciente += "<svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg>";
                        paciente += "<div>";
                        paciente += "Información del paciente";
                        paciente += "</div>";
                        paciente += "</div>";
                        paciente += "<hr>";
                        paciente += "<p><strong>Rut: </strong>" + datos.pacientes.rut + "</p>";
                        paciente += "<p><strong>Nombre: </strong>" + datos.pacientes.nombre + " " + datos.pacientes.apellido1 + " " + datos.pacientes.apellido2 + "</p>"
                        //Fecha de nacimiento en formato dd-mm-yyyy
                        paciente += "<p><strong>Fecha de Nacimiento: </strong>" + datos.pacientes.fechanacimiento + "</p>";
                        paciente += "<p><strong>Telefono: </strong>" + datos.pacientes.fonomovil + "</p>";
                        paciente += "<p><strong>Email: </strong>" + datos.pacientes.email + "</p>";
                        paciente += "</div>";
                        paciente += "<div class='row'>";
                        paciente += "<div class='col-md-12 text-end'>";
                        paciente += "<button class='btn btn-outline-success'  id='btnReservar' onclick='reservar()' ><i class='fa fa-calendar'></i> Reservar Hora</button>";
                        paciente += "</div>";
                        paciente += "</div>";
                        $("#idPaciente").val(datos.pacientes.id);
                        $(".details").html(paciente);
                        $("#tipoidentificacion").attr("disabled", true);
                        $("#rut").attr("disabled", true);
                        $("#documentoadd").attr("disabled", true);
                        $(".btnotro").removeClass("d-none");
                        $("#btnReservar").attr("disabled", false);
                    } else {

                    }
                },
            });
        } else {
            console.log("El rut no es valido");
        }
    }
}

function buscarpacientepasaporte(element) {
    var pasaporte = element.value;
    //VAlidar run
    if (pasaporte.length > 4) {
        $.ajax({
            url: "php/charge/paciente.php",
            type: "POST",
            data: { action: 'buscarpacientepasaporte', pasaporte: pasaporte },
            success: function (data) {
                //Recorrer el array de datos
                var datos = JSON.parse(data);

                if (datos.error == false) {
                    var paciente = "";
                    paciente += "<div class='alert alert-success' role='alert'>";
                    paciente += "<div class='alert-heading d-flex align-items-center'>";
                    paciente += "<svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg>";
                    paciente += "<div>";
                    paciente += "Información del paciente";
                    paciente += "</div>";
                    paciente += "</div>";
                    paciente += "<hr>";
                    paciente += "<p><strong>Rut: </strong>" + datos.pacientes.rut + "</p>";
                    paciente += "<p><strong>Nombre: </strong>" + datos.pacientes.nombre + " " + datos.pacientes.apellido1 + " " + datos.pacientes.apellido2 + "</p>"
                    //Fecha de nacimiento en formato dd-mm-yyyy
                    paciente += "<p><strong>Fecha de Nacimiento: </strong>" + datos.pacientes.fechanacimiento + "</p>";
                    paciente += "<p><strong>Telefono: </strong>" + datos.pacientes.fonomovil + "</p>";
                    paciente += "<p><strong>Email: </strong>" + datos.pacientes.email + "</p>";
                    paciente += "</div>";
                    $("#idPaciente").val(datos.pacientes.id);
                    $(".details").html(paciente);
                    $("#tipoidentificacion").attr("disabled", true);
                    $("#rut").attr("disabled", true);
                    $("#documentoadd").attr("disabled", true);
                    $(".btnotro").removeClass("d-none");
                    $("#btnReservar").attr("disabled", false);
                } else {

                }
            },
        });
    }
}

function otroPaciente() {
    $("#rut").val("");
    $("#idPaciente").val("");
    $(".details").html("");
    $("#tipoidentificacion").attr("disabled", false);
    $("#rut").attr("disabled", false);
    $("#documentoadd").attr("disabled", true);
    $("#documentoadd").val("");
    $(".rut").removeClass("d-none");
    $(".idotro").addClass("d-none");
    //Seleccionar la opcion 1 en el select
    $("#tipoidentificacion option[value='1']").attr("selected", true);
    $(".btnotro").addClass("d-none");
    $("#btnReservar").attr("disabled", true);
}

function reservar() {
    var idPaciente = $("#idPaciente").val();
    //Comprobar si se selecciono una hora
    var hora = document.getElementsByName("hora");
    var horaSeleccionada = false;
    var horaId = 0;
    for (var i = 0; i < hora.length; i++) {
        if (hora[i].checked) {
            horaSeleccionada = true;
            horaId = hora[i].value;
            break;
        }
    }
    if (horaSeleccionada) {
        if (idPaciente > 0) {
            $.ajax({
                url: "php/insert/reserva.php",
                type: "POST",
                data: { action: 'reservar', idPaciente: idPaciente , hora: horaId},
                success: function (data) {
                    //Recorrer el array de datos
                    var datos = JSON.parse(data);
                    if (datos.status == true) {
                        ToastifySuccess(datos.message);
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    } else {
                        ToastifyError(datos.message);
                    }
                },
            });
        } else {
            ToastifyError("Debe seleccionar un paciente");
        }
    } else {
        ToastifyError("Debe seleccionar una hora");
    }
}
