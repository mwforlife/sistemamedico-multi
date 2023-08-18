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
    $("#global-loader").fadeIn(1000);
    //Validar que la fecha no este vacia
    if (!validateDates()) {
      $("#global-loader").fadeOut(1000);
      ToastifyError("Debe agregar al menos una fecha");
      return;
    }
    //Horas de la mañana
    var start = $("#mainEventStartTime2").val();
    var end = $("#EventEndTime2").val();
   

    //Horas de la tarde
    var start1 = $("#mainEventStartTime3").val();
    var end1 = $("#EventEndTime3").val();

    if((start == "" || end == "") && (start1 == "" || end1 == "")){
      $("#global-loader").fadeOut(1000);
      ToastifyError("Debe seleccionar seleccionar al menos una Jornada");
      return;
    }
    

    //Recibir el intervalo de tiempo
    var intervalo2 = $("#intervalo2").val();
    if (intervalo2 == "") {
      $("#global-loader").fadeOut(1000);
      ToastifyError("Debe seleccionar un intervalo de tiempo");
      return;
    }

    var idUsuario = $("#idUsuario").val();
    var idEmpresa = $("#idEmpresa").val();
    if (idUsuario <= 0 || idEmpresa <= 0) {
      $("#global-loader").fadeOut(1000);
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
        $("#global-loader").fadeOut(1000);
        //Recibir el JSON
        var json = JSON.parse(data);
        if (json.error == true || json.error == "true") {
          ToastifyError(json.mensaje);
          return;
        } else if (json.error == false || json.error == "false") {
          ToastifySuccess(json.mensaje);
          clearDates();
          location.reload();
          return;
        } else {
          ToastifyError(json);
          return;
        }
      },
      error: function () {
        $("#global-loader").fadeOut(1000);
        ToastifyError("Error al registrar la agenda");
      },
    });
  });
});



//Creacion de eventos de eliminacion de eventos
$(document).ready(function () {
  $("#deleteEvent").click(function () {
    $("#modalCalendarEvent").modal("hide");
    //Preguntar si desea eliminar el evento
    swal.fire({
      title: "¿Desea eliminar el evento?",
      text: "Esta acción no se puede revertir",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "No, cancelar",
      reverseButtons: true,
    }).then(function (result) {
      if (result.value) {
        $id = $("#event-id").val();
        if ($id == "" || $id == 0) {
          ToastifyError("Error al obtener el id del evento");
          return;
        }
        $.ajax({
          url: "php/delete/agenda.php",
          type: "POST",
          data: {
            id: $id,
          },
          success: function (data) {
            ToastifySuccess("Se eliminó correctamente");
            location.reload();
          }
        });
      }
    });
  });

});


//Creacion de eventos de registro de horario mensual
$(document).ready(function() {
  $("#dtbtneventmonth").click(function() {
    $("#global-loader").fadeIn(1000);
      var periodo = $("#periodo").val();
      var diasSeleccionados = [];
      $("input[name='bloque']:checked").each(function() {
          diasSeleccionados.push($(this).val());
      });
      var horaInicioMatutina = $("#mainEventStartTime").val();
      var horaFinMatutina = $("#EventEndTime").val();
      var horaInicioTarde = $("#mainEventStartTime1").val();
      var horaFinTarde = $("#EventEndTime1").val();
      var intervalo = $("#intervalo").val();
      
        // Realización de validaciones aquí
        //Validar que la fecha no este vacia
        if (periodo == "") {
          $("#global-loader").fadeOut(1000);
          ToastifyError("El periodo no puede estar vacio");
          return;
        }
        //Validar que este seleccionado al menos un día
        if (diasSeleccionados.length === 0) {
          $("#global-loader").fadeOut(1000);
          ToastifyError("Debe seleccionar al menos un día.");
          return;
       }

      if((horaInicioMatutina == "" || horaFinMatutina == "") && (horaInicioTarde == "" || horaFinTarde == "")){
        $("#global-loader").fadeOut(1000);
        ToastifyError("Debe seleccionar seleccionar al menos una Jornada");
        return;
      }

      //Validar el intervalo
      if (intervalo == "") {
        $("#global-loader").fadeOut(1000);
        ToastifyError("Debe seleccionar un intervalo de tiempo");
        return;
      }    
      
    var idUsuario = $("#idUsuario").val();
    var idEmpresa = $("#idEmpresa").val();

      var datosHorario = {
        periodo: periodo,
        diasSeleccionados: diasSeleccionados,
        horaInicioMatutina: horaInicioMatutina,
        horaFinMatutina: horaFinMatutina,
        horaInicioTarde: horaInicioTarde,
        horaFinTarde: horaFinTarde,
        intervalo: intervalo,
        idUsuario: idUsuario,
        idEmpresa: idEmpresa
    };

    $.ajax({
      url: "php/insert/agenda1.php",
      type: "POST",
      data: {
        datosHorario: datosHorario
      },
      success: function (data) {
        $("#global-loader").fadeOut(1000);
        //Comprobar si es un JSON
        try {
        //Recibir el JSON
        var json = JSON.parse(data);
        if (json.error == true || json.error == "true") {
          ToastifyError(json.mensaje);
          return;
        } else if (json.error == false || json.error == "false") {
          ToastifySuccess(json.mensaje);
          setTimeout(function () {
          location.reload();
          }, 3000);
          return;
        } else {
          ToastifyError(json);
          return;
        }
      } catch (error) {
        ToastifyError(data);
      }
      },
      error: function () {
        $("#global-loader").fadeOut(1000);
        ToastifyError("Error al registrar la agenda");
      }
    });
  });
});
