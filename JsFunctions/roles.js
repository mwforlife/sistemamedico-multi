function asignarRol(rol, empresa, usuario) {
    $.ajax({
        type: "POST",
        url: "php/insert/rol.php",
        data: { rol: rol, empresa: empresa, usuario: usuario },
        success: function (response) {
            //Recibimos el JSON
            var jsonData = JSON.parse(response);
            //Si el error es falso, mostramos el mensaje y 
            if (jsonData.error == false) {
                ToastifySuccess(jsonData.message);
                listarroles();
            } else {
                ToastifyError(jsonData.message);
            }
        }
    });
}

function eliminarRol(rol, empresa, usuario) {
    //Preguntamos si esta seguro
    swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '¡Sí, bórralo!',
        cancelButtonText: '¡No, cancela!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/delete/rol.php",
                data: { rol: rol, empresa: empresa, usuario: usuario },
                success: function (response) {
                    //Recibimos el JSON
                    var jsonData = JSON.parse(response);
                    //Si el error es falso, mostramos el mensaje y 
                    if (jsonData.error == false) {
                        ToastifySuccess(jsonData.message);
                        listarroles();
                    } else {
                        ToastifyError(jsonData.message);
                    }
                }
            });
        } else {
            ToastifyError('Operación cancelada');
        }
    });
}

function listarroles(){
    var enterprise = $("#enterprise").val();
    var user = $("#user").val();
    $.ajax({
        type: "POST",
        url: "php/listado/roles.php",
        data: { enterprise: enterprise, user: user },
        success: function (response) {
            $("#tableroles").html(response);
        }
    });
}

$(document).ready(function () {
    listarroles();
});