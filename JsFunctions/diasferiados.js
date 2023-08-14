$(document).ready(function(){
    $("#feriadosform").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/diasferiados.php",
            data: data,
            success: function(data){
                if(data == 1 || data == "1"){
                    $("#global-loader").fadeOut("slow");
                    ToastifySuccess("Registro insertado correctamente");
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al Registrar")
                }
            }
        });
    }
    );
});

//Eliminar Feriado
function Eliminar(id){
    swal.fire({
        title: "¿Estas seguro?",
        text: "Una vez eliminado no se podra recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/diasferiados.php",
                data: {id: id},
                success: function(data){
                    $("#global-loader").fadeOut("slow");
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro eliminado correctamente");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error al eliminar")
                    }
                }
            });
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyInfo("Operacion cancelada");
        }
    });
    
}