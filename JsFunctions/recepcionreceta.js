function aprobar(id){
    swal.fire({
        title: '¿Está seguro de aprobar la receta?',
        text: "¡No podrá revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'php/update/aprobarreceta.php',
                data: { id: id },
                type: 'POST',
                success: function (response) {
                   try {
                    var json = JSON.parse(response);
                    if(json.status==true){
                        ToastifySuccess(json.message);
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }else{
                        ToastifyError(json.message);
                    
                    }
                   } catch (error) {
                    ToastifyError(error);
                   }
                }
            });
        }
    });
}
function rechazar(id){
    swal.fire({
        title: '¿Está seguro de rechazar la receta?',
        text: "¡No podrá revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#idreceta").val(id);
            $("#modalrechazo").modal("show");
        }
    });
}

function vertratamiento(tratamiento){
    $("#tratamiento").html(tratamiento);
    $("#modaltratamiento").modal("show");
}