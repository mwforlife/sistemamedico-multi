function motivorechazo(id) {
    $.ajax({
        url: "php/charge/motivorechazo.php",
        type: "POST",
        data: { id: id },
        success: function (data) {
            $(".rechazocontent").html(data);
            $("#modalrechazo").modal("show");
        },
        });
}