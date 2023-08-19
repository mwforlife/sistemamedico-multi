$(document).ready(function(){
    $("#reserveevent").click(function(){
        var id = $("#reserve-id").val();
        var observacion = $("#observacion").val();
        var estado = $("#estado").val();

        $.ajax({
            url: "php/update/atencion.php",
            type: "POST",
            data: {id: id, observacion: observacion, estado: estado},
            success: function(data){
                if(data == 1){
                    ToastifySuccess("Registrado con exito");
                    setTimeout(function(){location.reload();}, 1500);
                }else{
                    ToastifyError("Error al registrar");
                }
            }
        });
    }
    );
});



function atender(id){
    $("#reserveeventmodal").modal("show");
    $("#reserve-id").val(id);
}

function atencion(id){
    $.ajax({
        url: "php/update/atencion.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            if(data == 1){
                ToastifySuccess("Atendida");
                setTimeout(function(){location.reload();}, 1500);
            }else{
                ToastifyError("Error al atender");
            }
        }
    });
}

function Finalizaratencion(id){
    $.ajax({
        url: "php/update/finalizaratencion.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            if(data == 1){
                ToastifySuccess("Finalizada");
                setTimeout(function(){location.reload();}, 1500);
            }else{
                ToastifyError("Error al finalizar");
            }
        }
    });
}