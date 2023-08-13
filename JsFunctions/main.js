function cambiarempresa(elemento){
    var id = elemento.value;
    var url = "php/validation/change_empresa.php";
    $.ajax({
        type: "POST",
        url: url,
        data: { id: id },
        success: function (data) {
            if(data == 1){
                location.reload();
            }else{
                ToastifyError("No se pudo cambiar de empresa");
            }
        }
    });
}

function setenterprise(){
    var entrepriseselect = $("#entrepriseselect").val();
        if(entrepriseselect > 0){
        var url = "php/validation/change_empresa.php";
        $.ajax({
            type: "POST",
            url: url,
            data: { id: entrepriseselect },
            success: function (data) {
                if(data==0){
                    ToastifyError("No se pudo definir el hospital");
                }
            }
        });
    }
}

setenterprise();