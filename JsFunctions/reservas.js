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