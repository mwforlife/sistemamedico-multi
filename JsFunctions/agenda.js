//Crear un array llamado fechas
var fechas = new Array();

//Crear un evento mediante el click del boton
$(document).ready(function () {
  $("#adddate").click(function () {
    var date = $("#datecalendar").val();
    //Validar que la fecha no este vacia
    if (date == "") {
      ToastifyError("La fecha no puede estar vacia");
      return;
    }
    //Validar que la fecha no este repetida
    if (fechas.includes(date)) {
      ToastifyError("La fecha ya esta agregada");
      return;
    }
    //Validar que la fecha no sea un dia feriado
    $.ajax({
      url: "php/validation/diasferiados.php",
      type: "POST",
      data: {
        fecha: date,
      },
      success: function (feriado) {
        if (feriado == 1 || feriado == "1") {
          ToastifyError("La fecha no puede ser un dia feriado");
          return;
        } else if (feriado == 2 || feriado == "2") {
          ToastifyError("No se pudo validar si la fecha es un dia feriado");
          return;
        } else if (feriado == 0 || feriado == "0") {
          //Agregar la fecha al array
          fechas.push(date);
          //Listar las fechas agregadas
          listDates();
        } else {
          ToastifyError(feriado);
          return;
        }
      },
      error: function () {
        ToastifyError("Error al validar si la fecha es un dia feriado");
      },
    });
  });
});

//Listar las fechas agregadas
function listDates() {
  var content = "";
  for (var i = 0; i < fechas.length; i++) {
    $fech = fechas[i];
    //Formato de fecha dd-mm-yyyy
    $fech = $fech.split("-");
    content +=
      "<button type='button' class='btn btn-success position-relative m-1'>" +
      $fech[2] +
      "-" +
      $fech[1] +
      "-" +
      $fech[0] +
      "<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger' title='Eliminar' onclick='deleteDate(" +
      i +
      ")'><span class='visually-hidden'>x</span></span></button>";
  }
  $("#dateprint").html(content);
}

//Eliminar una fecha del array
function deleteDate(index) {
  fechas.splice(index, 1);
  ToastifySuccess("Fecha eliminada");
  listDates();
}

//Limpiar el array
function clearDates() {
  fechas = [];
  listDates();
}

//Validar si el array esta vacio
function validateDates() {
  if (fechas.length == 0) {
    return false;
  }
  return true;
}

//Crear un evento mediante el click del boton
$(document).ready(function () {
  $("#dtbtnevent").click(function () {
    //Validar que la fecha no este vacia
    if (!validateDates()) {
      ToastifyError("Debe agregar al menos una fecha");
      return;
    }
    //Horas de la mañana
    var start = $("#mainEventStartTime2").val();
    if (start == "") {
      ToastifyError("Debe seleccionar una hora de inicio");
      return;
    }
    var end = $("#EventEndTime2").val();
    if (end == "") {
      ToastifyError("Debe seleccionar una hora de fin");
      return;
    }

    //Horas de la tarde
    var start1 = $("#mainEventStartTime3").val();
    if (start1 == "") {
      ToastifyError("Debe seleccionar una hora de inicio");
      return;
    }
    var end1 = $("#EventEndTime3").val();
    if (end1 == "") {
      ToastifyError("Debe seleccionar una hora de fin");
      return;
    }

    //Recibir el intervalo de tiempo
    var intervalo2 = $("#intervalo2").val();
    if (intervalo2 == "") {
      ToastifyError("Debe seleccionar un intervalo de tiempo");
      return;
    }

    var idUsuario = $("#idUsuario").val();
    var idEmpresa = $("#idEmpresa").val();
    if (idUsuario <= 0 || idEmpresa <= 0) {
      ToastifyError("Error al obtener el usuario o la empresa");
      return;
    }

    $.ajax({
      url: "php/insert/agenda.php",
      type: "POST",
      data: {
        fechas: fechas,
        start: start,
        end: end,
        start1: start1,
        end1: end1,
        intervalo2: intervalo2,
        idUsuario: idUsuario,
        idEmpresa: idEmpresa,
      },
      success: function (data) {
        //json_encode(array("error" => false, "mensaje" => "Se registró correctamente"));
        //Recibir el JSON
        var json = JSON.parse(data);
        if (json.error == true || json.error == "true") {
          ToastifyError(json.mensaje);
          return;
        } else if (json.error == false || json.error == "false") {
          ToastifySuccess(json.mensaje);
          clearDates();
          return;
        } else {
          ToastifyError(json);
          return;
        }
      },
      error: function () {
        ToastifyError("Error al registrar la agenda");
      },
    });
  });
});
