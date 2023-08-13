

$(document).ready(function () {
    $("#EnterpriseForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var url = "php/insert/empresas.php";
        var data = form.serialize();
        var rut = $("#EnterpriseRut").val();
        if(validarRut(rut) == false){
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut no valido");
            return false;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                if (data == 1 || data == "1") {
                    $("#global-loader").fadeOut("slow");
                    $(".adi").show();
                    $("#EnterpriseRut").attr("disabled", "disabled");
                    $("#EnterpriseNombre").attr("disabled", "disabled");
                    $("#EnterpriseDireccion").attr("disabled", "disabled");
                    $("#EnterpriseRegion").attr("disabled", "disabled");
                    $("#EnterpriseCiudad").attr("disabled", "disabled");
                    $("#EnterpriseComuna").attr("disabled", "disabled");
                    $("#EnterpriseTelefono").attr("disabled", "disabled");
                    $("#EnterpriseCorreo").attr("disabled", "disabled");
                    $("#EnterpriseGiro").attr("disabled", "disabled");
                    ToastifySuccess("Empresa registrada correctamente");
                }else if(data == 0 || data == "0"){
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al registrar la empresa");
                }else if(data == 2 || data == "2"){
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("La empresa ya se encuentra registrada");
                }else{
                    $("#global-loader").fadeOut("slow");
                    ToastifyError(data);
                }
            }
        });
    });
    $("#EnterpriseEditForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var rut = $("#EnterpriseRut").val();
        if(validarRut(rut) == false){
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut no valido");
            return false;
        }
        var form = $(this);
        var url = "php/insert/empresas.php";
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                if (data == 1 || data == "1") {
                    $("#global-loader").fadeOut("slow");
                    $(".adi").show();
                    ToastifySuccess("Datos Actualizados correctamente");
                }else if(data == 0 || data == "0"){
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al Actualizar la empresa");
                }else{
                    $("#global-loader").fadeOut("slow");
                    ToastifyError(data);
                }
            }
        });
    });
    $("#RepresentanteForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var RepresentanteRut = $("#RepresentanteRut").val();
        if(validarRut(RepresentanteRut) == false){
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut no valido");
            return false;
        }
        var form = $(this);
        var url = "php/insert/representante.php";
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                if (data == 1 || data == "1") {
                    $("#global-loader").fadeOut("slow");
                    ToastifySuccess("Representante registrado correctamente");
                    ListarRepresentantes();
                }else if(data == 0 || data == "0"){
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al registrar el representante");
                }else if(data == 2 || data == "2"){
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("El representante ya se encuentra registrado");
                }
                else{
                    $("#global-loader").fadeOut("slow");
                    ToastifyError(data);
                }
            }
        });
    });
});

function ListarRepresentantes(){
    $.ajax({
        type: "POST",
        url: "php/listado/representantes.php",
        success: function (data) {
            $("#tablerepre").html(data);
        }
    });
}

function EliminarRepresentante(id){
    swal.fire({
        title: "¿Está seguro de eliminar el representante?",
        text: "No podrá recuperar la información",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        $("#global-loader").fadeIn("slow");
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/delete/representante.php",
                data: {id:id},
                success: function (data) {
                    if (data == 1 || data == "1") {
                        $("#global-loader").fadeOut("slow");
                        ToastifySuccess("Representante eliminado correctamente");
                        ListarRepresentantes();
                    }else if(data == 0 || data == "0"){
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error al eliminar el representante");
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError(data);
                    }
                }
            });
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyError("Operación cancelada");
        }
    });
}

function Eliminar(id){
    swal.fire({
        title: "¿Está seguro de eliminar la empresa?",
        text: "No podrá recuperar la información",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        $("#global-loader").fadeIn("slow");
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/delete/empresas.php",
                data: {id:id},
                success: function (data) {
                    if (data == 1 || data == "1") {
                        $("#global-loader").fadeOut("slow");
                        ToastifySuccess("Empresa eliminada correctamente");
                        setTimeout(function () {
                            window.location.href = "empresas.php";
                        }, 1000);
                    }else if(data == 0 || data == "0"){
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error al eliminar la empresa");
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError(data);
                    }
                }
            });
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyError("Operación cancelada");
        }
    });
}
function CodigoActividad(id){
    $.ajax({
        type: "POST",
        url: "php/insert/codigoactividad.php",
        data: {id:id},
        success: function (data) {
            $("#global-loader").fadeIn("slow");
            if (data == 1 || data == "1") {
                $("#global-loader").fadeOut("slow");
                ToastifySuccess("Codigo de actividad agregado correctamente");
                ListarCodigoActividad();
            }else if(data == 2 || data == "2"){
                $("#global-loader").fadeOut("slow");
                ToastifyError("El codigo de actividad ya se encuentra registrado");
            }else if(data == 0 || data == "0"){
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al agregar el codigo de actividad");
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError(data);
            }
        }
    });
}

function ListarCodigoActividad(){
    $.ajax({
        type: "POST",
        url: "php/listado/codigoactividad.php",
        success: function (data) {
            $("#tabledata").html(data);
        }
    });
}

function EliminarCodigoActividad(id){
    swal.fire({
        title: "¿Está seguro de eliminar el codigo de actividad?",
        text: "No podrá recuperar la información",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        $("#global-loader").fadeIn("slow");
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/delete/codigoactividad.php",
                data: {id:id},
                success: function (data) {
                    if (data == 1 || data == "1") {
                        $("#global-loader").fadeOut("slow");
                        ToastifySuccess("Codigo de actividad eliminado correctamente");
                        ListarCodigoActividad();
                    }else if(data == 0 || data == "0"){
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error al eliminar el codigo de actividad");
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError(data);
                    }
                }
            });
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyError("Operación cancelada");
        }
    });
}

function guardar(){
    window.location.href = "empresas.php";
}

function asignar(id,empresa){
    $("#global-loader").fadeIn("slow");
    $.ajax({
        type: "POST",
        url: "php/insert/asignarusuario.php",
        data: {usuario:id, id:empresa},
        success: function (data) {
            if (data == 1 || data == "1") {
                $("#global-loader").fadeOut("slow");
                ToastifySuccess("Usuario Asignado Con Exito");
                setTimeout(function(){
                    location.reload();
                },1500);
            }else if(data == 2 || data == "2"){
                $("#global-loader").fadeOut("slow");
                ToastifyError("El usuario ya se encuentra asignado");
            }else if(data == 0 || data == "0"){
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al asignar el usuario");
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError(data);
            }
        }
    });
}

function cambiarestado(id, estado){
    $("#global-loader").fadeIn("slow");
    $.ajax({
        type: "POST",
        url: "php/insert/cambiarestado.php",
        data: {id:id, estado:estado},
        success: function (data) {
            if (data == 1 || data == "1") {
                $("#global-loader").fadeOut("slow");
                ToastifySuccess("Estado cambiado correctamente");
                setTimeout(function(){
                    location.reload();
                },1500);
            }else if(data == 0 || data == "0"){
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al cambiar el estado");
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError(data);
            }
        }
    });
}

function more(id){
    $.ajax({
        type: "POST",
        url: "php/listado/more.php",
        data: {id:id},
        success: function (data) {
            $(".contenido").html(data);
        }
    });
}