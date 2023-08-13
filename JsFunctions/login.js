//Validar TIpo de Usuario
$("#tiposesion").on("change", function () {
    var tiposesion = $("#tiposesion").val();
    if (tiposesion == 1) {
        $("#User").attr("placeholder", "Correo Electronico");
        $("#User").val("");
        $("#User").removeAttr("onkeyup");
        $("#User").removeAttr("maxlength");
        $("#User").attr("type", "email");
    }
    else {
        $("#User").attr("placeholder", "Ingrese su Rut");
        $("#User").val("");
        $("#User").attr("onkeyup", "formatRut(this)");
        $("#User").attr("maxlength", "12");
        $("#User").attr("type", "text");
    }
});


//Form Ejecution
$("#LoginForm").on("submit", function (e) {
    e.preventDefault();
    var tiposesion = $("#tiposesion").val();
    if(tiposesion == 2){
        var rut = $("#User").val();
        if(validarRut(rut) == false){
            ToastifyError("Rut Invalido");
            return false;
        }
    }
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        type: "POST",
        url: "php/validation/login.php",
        data: data,
        success: function (response) {
            if (response == 1) {
                window.location.href = "index.php";
            }
            else {
                ToastifyError(response);
            }
        }
    });
});

//Form Ejecution
$("#LockForm").on("submit", function (e) {
    e.preventDefault();
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        type: "POST",
        url: "php/validation/login.php",
        data: data,
        success: function (response) {
            if (response == 1) {
                window.location.href = "index.php";
            }
            else {
                ToastifyError(response);
            }
        }
    });
});

