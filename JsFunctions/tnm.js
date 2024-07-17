
//TNM
//Registro de TNM
$(document).ready(function () {
    $("#tnmform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/tnm.php",
            data: datos,
            success: function (data) {
                try {
                    var json = JSON.parse(data);
                    if(json.status == true){
                        ToastifySuccess(json.message);
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    }else{
                        ToastifyError(json.message);
                    }
                } catch (error) {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar TNM
function EliminarTNM(id) {
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
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/tnm.php",
                data: { id: id },
                success: function (data) {
                    try {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            ToastifySuccess(json.message);
                            setTimeout(function () {
                                location.reload();
                            }, 500);
                        }else{
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarTNM(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/tnm.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarTNM(id) {
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/tnm.php",
        data: { id: id, descripcion: descripcion},
        success: function (data) {
            try {
                var json = JSON.parse(data);
                if(json.status == true){
                    ToastifySuccess(json.message);
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                }else{
                    ToastifyError(json.message);
                }
            } catch (error) {
                ToastifyError(data);
            }
        }
    });
}