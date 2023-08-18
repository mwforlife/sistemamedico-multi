function sessionReserva() {
    var id = $("#idUsuario").val();
    if(id>0){
    $.ajax({
        url: "php/validation/sessions.php",
        type: "POST",
        data: {action: 'sessionReserva', id: id},
        success: function (data) {
            location.reload();
        },
    });
    }else{
        console.log("No se pude crear la session");
    }
}

function cargarHorario($id) {
    $.ajax({
        url: "php/charge/horario.php",
        type: "POST",
        data: {action: 'cargarHorario', id: $id},
        success: function (data) {
            //Recorrer el array de datos
            var datos = JSON.parse(data);
            var horario ="";
            for (var i = 0; i < datos.length; i++) {
                horario += "<div class='col-md-3 col-sm-6 col-xs-12'>";
                horario += "<input type='radio' class='btn-check' name='hora' id='hora" + datos[i].id + "' autocomplete='off' value='" + datos[i].id + "'>";
                horario += "<label class='btn btn-outline-primary btn-block w-100 mt-2' for='hora" + datos[i].id + "'>" + datos[i].start + " - " + datos[i].end + "</label>";
                horario += "</div>";
            }

            $(".horario").html(horario);
        },
    });
}

function buscarpacienterun(element){
    var run = element.value;
    //VAlidar run
    if(run.length>9){
        if(validarRut(run)){
            $.ajax({
                url: "php/charge/paciente.php",
                type: "POST",
                data: {action: 'buscarpacienterun', run: run},
                success: function (data) {
                    //Recorrer el array de datos
                    var datos = JSON.parse(data);
                    if(datos.length>0){
                    }
                },
            });
        }else{
            console.log("El rut no es valido");
        }
    }
}

function buscarpacientepasaporte(element){
    var pasaporte = element.value;
    //VAlidar run
    if(pasaporte.length>4){
        $.ajax({
            url: "php/charge/paciente.php",
            type: "POST",
            data: {action: 'buscarpacientepasaporte', pasaporte: pasaporte},
            success: function (data) {
                //Recorrer el array de datos
                var datos = JSON.parse(data);
                if(datos.length>0){
                    
                }
            },
        });
    }
}