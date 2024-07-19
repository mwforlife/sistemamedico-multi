function newregispoblacional() {
  if(registropoblacional()==true){
    setTimeout(function(){
      location.reload();
    }, 500);
  }else{
    return false;
  }
}
function registropoblacional() {
  var idpaciente = $("#pacientepoblacional").val();
  var provenencia = $("#proveniencia").val();
  //Variables Rama
  var rama1 = 0;
  var rama2 = 0;
  var rama3 = 0;
  var rama4 = 0;
  var rama5 = 0;
  var rama6 = 0;
  var rama7 = 0;
  var rama8 = 0;
  var rama9 = 0;
  var rama10 = 0;

  //Variables Ocupacion
  var ocupacion1 = 0;
  var ocupacion2 = 0;
  var ocupacion3 = 0;
  var ocupacion4 = 0;
  var ocupacion5 = 0;
  var ocupacion6 = 0;
  var ocupacion7 = 0;
  var ocupacion8 = 0;
  var ocupacion9 = 0;
  var ocupacion10 = 0;
  var ocupacion11 = 0;

  //Variables Caracteristicas del Cancer
  var sp1 = 0;
  var sp2 = 0;
  var sp3 = 0;
  var th1 = 0;
  var th2 = 0;
  var th3 = 0;
  var th4 = 0;
  var th5 = 0;
  var comportamiento = "";
  var comportamientoobservacion = $("#comportamientoobservaciones").val();

  //Variables Grado
  var grado1 = 0;
  var grado2 = 0;
  var grado3 = 0;
  var grado4 = 0;
  var grado5 = 0;

  //Variables Extension
  var extension1 = 0;
  var extension2 = 0;
  var extension3 = 0;
  var extension4 = 0;
  var extension5 = 0;

  //Variables Lateralidad
  var lateralidad1 = 0;
  var lateralidad2 = 0;
  var lateralidad3 = 0;
  var lateralidad4 = 0;
  var lateralidad5 = 0;

  //Incidencia y Basde del diagnóstico
  var fechaincidencia = $("#fechaIncidencia").val();
  var horaincidencia = $("#horaIncidencia").val();
  var basediagnostico1 = 0;
  var basediagnostico2 = 0;
  var basediagnostico3 = 0;
  var basediagnostico4 = 0;
  var basediagnostico5 = 0;
  var basediagnostico6 = 0;
  var basediagnostico7 = 0;
  var basediagnostico8 = 0;
  var basediagnostico9 = 0;

  //Fuente Incidencia
  var fuente1 = 0;
  var fechapacex1 = "";
  var fechahospex1 = "";
  var horahospex1 = "";
  var fuente2 = 0;
  var fechapacex2 = "";
  var fechahospex2 = "";
  var horahospex2 = "";
  var fuente3 = 0;
  var fechapacex3 = "";
  var fechahospex3 = "";
  var horahospex3 = "";

  //Ultimos Detalles
  var fechaultimocontacto = $("#fechacontacto").val();
  var estadio = 0;
  if($("#estadio1").is(":checked")){
    estadio = 1;
  }else if($("#estadio2").is(":checked")){
    estadio = 2;
  }else if($("#estadio3").is(":checked")){
    estadio = 3;
  }else{
    estadio = 0;
  }
  var defuncion = "";
  var causa = 0;
  var observacionfinal = $("#observacionfinal").val();

  //Validaciones de Rama
  try {
    if ($("#rama1").is(":checked")) {
      rama1 = 1;
    }
    if ($("#rama2").is(":checked")) {
      rama2 = 1;
    }
    if ($("#rama3").is(":checked")) {
      rama3 = 1;
    }
    if ($("#rama4").is(":checked")) {
      rama4 = 1;
    }
    if ($("#rama5").is(":checked")) {
      rama5 = 1;
    }
    if ($("#rama6").is(":checked")) {
      rama6 = 1;
    }
    if ($("#rama7").is(":checked")) {
      rama7 = 1;
    }
    if ($("#rama8").is(":checked")) {
      rama8 = 1;
    }
    if ($("#rama9").is(":checked")) {
      rama9 = 1;
    }
    if ($("#rama10").is(":checked")) {
      rama10 = 1;
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Ocupacion
  try {
    if ($("#ocupacion1").is(":checked")) {
      ocupacion1 = 1;
    }
    if ($("#ocupacion2").is(":checked")) {
      ocupacion2 = 1;
    }
    if ($("#ocupacion3").is(":checked")) {
      ocupacion3 = 1;
    }
    if ($("#ocupacion4").is(":checked")) {
      ocupacion4 = 1;
    }
    if ($("#ocupacion5").is(":checked")) {
      ocupacion5 = 1;
    }
    if ($("#ocupacion6").is(":checked")) {
      ocupacion6 = 1;
    }
    if ($("#ocupacion7").is(":checked")) {
      ocupacion7 = 1;
    }
    if ($("#ocupacion8").is(":checked")) {
      ocupacion8 = 1;
    }
    if ($("#ocupacion9").is(":checked")) {
      ocupacion9 = 1;
    }
    if ($("#ocupacion10").is(":checked")) {
      ocupacion10 = 1;
    }
    if ($("#ocupacion11").is(":checked")) {
      ocupacion11 = 1;
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Caracteristicas del Cancer
  try {
    if ($("#sp1").is(":checked")) {
      sp1 = 1;
    }
    if ($("#sp2").is(":checked")) {
      sp2 = 1;
    }
    if ($("#sp3").is(":checked")) {
      sp3 = 1;
    }
    if ($("#th1").is(":checked")) {
      th1 = 1;
    }
    if ($("#th2").is(":checked")) {
      th2 = 1;
    }
    if ($("#th3").is(":checked")) {
      th3 = 1;
    }
    if ($("#th4").is(":checked")) {
      th4 = 1;
    }
    if ($("#th5").is(":checked")) {
      th5 = 1;
    }
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Grado
  try {
    if ($("#grado1").is(":checked")) {
      grado1 = 1;
    }
    if ($("#grado2").is(":checked")) {
      grado2 = 1;
    }
    if ($("#grado3").is(":checked")) {
      grado3 = 1;
    }
    if ($("#grado4").is(":checked")) {
      grado4 = 1;
    }
    if ($("#grado5").is(":checked")) {
      grado5 = 1;
    }
    //Validar que se haya seleccionado al menos un grado
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Extension
  try {
    if ($("#extension1").is(":checked")) {
      extension1 = 1;
    }
    if ($("#extension2").is(":checked")) {
      extension2 = 1;
    }
    if ($("#extension3").is(":checked")) {
      extension3 = 1;
    }
    if ($("#extension4").is(":checked")) {
      extension4 = 1;
    }
    if ($("#extension5").is(":checked")) {
      extension5 = 1;
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Lateralidad
  try {
    if ($("#lateralidad1").is(":checked")) {
      lateralidad1 = 1;
    }
    if ($("#lateralidad2").is(":checked")) {
      lateralidad2 = 1;
    }
    if ($("#lateralidad3").is(":checked")) {
      lateralidad3 = 1;
    }
    if ($("#lateralidad4").is(":checked")) {
      lateralidad4 = 1;
    }
    if ($("#lateralidad5").is(":checked")) {
      lateralidad5 = 1;
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Incidencia y Base del Diagnóstico
  try {
    if ($("#basediagnostico1").is(":checked")) {
      basediagnostico1 = 1;
    }
    if ($("#basediagnostico2").is(":checked")) {
      basediagnostico2 = 1;
    }
    if ($("#basediagnostico3").is(":checked")) {
      basediagnostico3 = 1;
    }
    if ($("#basediagnostico4").is(":checked")) {
      basediagnostico4 = 1;
    }
    if ($("#basediagnostico5").is(":checked")) {
      basediagnostico5 = 1;
    }
    if ($("#basediagnostico6").is(":checked")) {
      basediagnostico6 = 1;
    }
    if ($("#basediagnostico7").is(":checked")) {
      basediagnostico7 = 1;
    }
    if ($("#basediagnostico8").is(":checked")) {
      basediagnostico8 = 1;
    }
    if ($("#basediagnostico9").is(":checked")) {
      basediagnostico9 = 1;
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Fuente Incidencia
  try {
    if ($("#fuente1").is(":checked")) {
      fuente1 = 1;
      fechapacex1 = $("#fechapacex1").val();
      fechahospex1 = $("#fechahospex1").val();
      horahospex1 = $("#horahospex1").val();
    }
    if ($("#fuente2").is(":checked")) {
      fuente2 = 1;
      fechapacex2 = $("#fechapacex2").val();
      fechahospex2 = $("#fechahospex2").val();
      horahospex2 = $("#horahospex2").val();
    }
    if ($("#fuente3").is(":checked")) {
      fuente3 = 1;
      fechapacex3 = $("#fechapacex3").val();
      fechahospex3 = $("#fechahospex3").val();
      horahospex3 = $("#horahospex3").val();
    }
    
  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Ultimos Detalles
  try {
    if (estadio == 2) {
      var defuncion = $("#defuncion").val();
      if (defuncion.trim().length < 10) {
        ToastifyError("Debe ingresar la fecha de defunción");
        $("#defuncion").focus();
        return false;
      }
      var causa1 = 0;
      var causa2 = 0;
      var causa3 = 0;
      if($("#causa1").is(":checked")){
        causa1 = 1;
        causa = 1;
      }
      if($("#causa2").is(":checked")){
        causa2 = 1;
        causa = 2;
      }
      if($("#causa3").is(":checked")){
        causa3 = 1;
        causa = 3;
      }
      if(causa1==0 && causa2==0 && causa3==0){
        ToastifyError("Debe seleccionar una causa");
        return false;
      }
    }
  } catch (error) {
    ToastifyError("Pwwww!"+error);
    return false;
  }

  //Enviar Datos
  try {
    $.ajax({
      url: "php/insert/registropoblacional.php",
      type: "POST",
      data: {
        idpaciente: idpaciente,
        provenencia: provenencia,
        rama1: rama1,
        rama2: rama2,
        rama3: rama3,
        rama4: rama4,
        rama5: rama5,
        rama6: rama6,
        rama7: rama7,
        rama8: rama8,
        rama9: rama9,
        rama10: rama10,
        ocupacion1: ocupacion1,
        ocupacion2: ocupacion2,
        ocupacion3: ocupacion3,
        ocupacion4: ocupacion4,
        ocupacion5: ocupacion5,
        ocupacion6: ocupacion6,
        ocupacion7: ocupacion7,
        ocupacion8: ocupacion8,
        ocupacion9: ocupacion9,
        ocupacion10: ocupacion10,
        ocupacion11: ocupacion11,
        sp1: sp1,
        sp2: sp2,
        sp3: sp3,
        th1: th1,
        th2: th2,
        th3: th3,
        th4: th4,
        th5: th5,
        comportamiento: comportamiento,
        comportamientoobservacion: comportamientoobservacion,
        grado1: grado1,
        grado2: grado2,
        grado3: grado3,
        grado4: grado4,
        grado5: grado5,
        extension1: extension1,
        extension2: extension2,
        extension3: extension3,
        extension4: extension4,
        extension5: extension5,
        lateralidad1: lateralidad1,
        lateralidad2: lateralidad2,
        lateralidad3: lateralidad3,
        lateralidad4: lateralidad4,
        lateralidad5: lateralidad5,
        fechaincidencia: fechaincidencia,
        horaincidencia: horaincidencia,
        basediagnostico1: basediagnostico1,
        basediagnostico2: basediagnostico2,
        basediagnostico3: basediagnostico3,
        basediagnostico4: basediagnostico4,
        basediagnostico5: basediagnostico5,
        basediagnostico6: basediagnostico6,
        basediagnostico7: basediagnostico7,
        basediagnostico8: basediagnostico8,
        basediagnostico9: basediagnostico9,
        fuente1: fuente1,
        fechapacex1: fechapacex1,
        fechahospex1: fechahospex1,
        horahospex1: horahospex1,
        fuente2: fuente2,
        fechapacex2: fechapacex2,
        fechahospex2: fechahospex2,
        horahospex2: horahospex2,
        fuente3: fuente3,
        fechapacex3: fechapacex3,
        fechahospex3: fechahospex3,
        horahospex3: horahospex3,
        fechaultimocontacto: fechaultimocontacto,
        estadio: estadio,
        defuncion: defuncion,
        causa: causa,
        observacionfinal: observacionfinal,
      },
      success: function (data) {
        try {
          var json = JSON.parse(data);
          if(json.status==true){
              ToastifySuccess(json.message);
              return true;
          }else{
              ToastifyError(json.message);
              return false;
          }
        } catch (error) {
          ToastifyError("Ups!"+error);
          return false;
          
        }
      },
      error: function (data) {
        ToastifyError("Ups2!"+"Error al guardar el registro poblacional");
        return false;
      },
    });
  } catch (error) {
    ToastifyError("Ups3!"+error);
    return false;
    
  }
  
}

function actualizarregistropoblacional() {
    var idregistro = $("#idregistropoblacional").val();
    var provenencia = $("#proveniencia").val();
    //Variables Rama
    var rama1 = 0;
    var rama2 = 0;
    var rama3 = 0;
    var rama4 = 0;
    var rama5 = 0;
    var rama6 = 0;
    var rama7 = 0;
    var rama8 = 0;
    var rama9 = 0;
    var rama10 = 0;
  
    //Variables Ocupacion
    var ocupacion1 = 0;
    var ocupacion2 = 0;
    var ocupacion3 = 0;
    var ocupacion4 = 0;
    var ocupacion5 = 0;
    var ocupacion6 = 0;
    var ocupacion7 = 0;
    var ocupacion8 = 0;
    var ocupacion9 = 0;
    var ocupacion10 = 0;
    var ocupacion11 = 0;
  
    //Variables Caracteristicas del Cancer
    var sp1 = 0;
    var sp2 = 0;
    var sp3 = 0;
    var th1 = 0;
    var th2 = 0;
    var th3 = 0;
    var th4 = 0;
    var th5 = 0;
    var comportamiento = "";
    var comportamientoobservacion = "";
  
    //Variables Grado
    var grado1 = 0;
    var grado2 = 0;
    var grado3 = 0;
    var grado4 = 0;
    var grado5 = 0;
  
    //Variables Extension
    var extension1 = 0;
    var extension2 = 0;
    var extension3 = 0;
    var extension4 = 0;
    var extension5 = 0;
  
    //Variables Lateralidad
    var lateralidad1 = 0;
    var lateralidad2 = 0;
    var lateralidad3 = 0;
    var lateralidad4 = 0;
    var lateralidad5 = 0;
  
    //Incidencia y Basde del diagnóstico
    var fechaincidencia = $("#fechaIncidencia").val();
    var horaincidencia = $("#horaIncidencia").val();
    var basediagnostico1 = 0;
    var basediagnostico2 = 0;
    var basediagnostico3 = 0;
    var basediagnostico4 = 0;
    var basediagnostico5 = 0;
    var basediagnostico6 = 0;
    var basediagnostico7 = 0;
    var basediagnostico8 = 0;
    var basediagnostico9 = 0;
  
    //Fuente Incidencia
    var fuente1 = 0;
    var fechapacex1 = "";
    var fechahospex1 = "";
    var horahospex1 = "";
    var fuente2 = 0;
    var fechapacex2 = "";
    var fechahospex2 = "";
    var horahospex2 = "";
    var fuente3 = 0;
    var fechapacex3 = "";
    var fechahospex3 = "";
    var horahospex3 = "";
  
    //Ultimos Detalles
    var fechaultimocontacto = $("#fechacontacto").val();
    var estadio = document.getElementsByName("estadio");
    var defuncion = "";
    var causa = 0;
    var observacionfinal = $("#observacionfinal").val();
  
    //Validaciones de Rama
    try {
      if ($("#rama1").is(":checked")) {
        rama1 = 1;
      }
      if ($("#rama2").is(":checked")) {
        rama2 = 1;
      }
      if ($("#rama3").is(":checked")) {
        rama3 = 1;
      }
      if ($("#rama4").is(":checked")) {
        rama4 = 1;
      }
      if ($("#rama5").is(":checked")) {
        rama5 = 1;
      }
      if ($("#rama6").is(":checked")) {
        rama6 = 1;
      }
      if ($("#rama7").is(":checked")) {
        rama7 = 1;
      }
      if ($("#rama8").is(":checked")) {
        rama8 = 1;
      }
      if ($("#rama9").is(":checked")) {
        rama9 = 1;
      }
      if ($("#rama10").is(":checked")) {
        rama10 = 1;
      }
      //Validar que se haya seleccionado al menos una rama
      if (
        rama1 == 0 &&
        rama2 == 0 &&
        rama3 == 0 &&
        rama4 == 0 &&
        rama5 == 0 &&
        rama6 == 0 &&
        rama7 == 0 &&
        rama8 == 0 &&
        rama9 == 0 &&
        rama10 == 0
      ) {
        ToastifyError("Debe seleccionar al menos una Rama de actividad");
        return false;
      }
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Ocupacion
    try {
      if ($("#ocupacion1").is(":checked")) {
        ocupacion1 = 1;
      }
      if ($("#ocupacion2").is(":checked")) {
        ocupacion2 = 1;
      }
      if ($("#ocupacion3").is(":checked")) {
        ocupacion3 = 1;
      }
      if ($("#ocupacion4").is(":checked")) {
        ocupacion4 = 1;
      }
      if ($("#ocupacion5").is(":checked")) {
        ocupacion5 = 1;
      }
      if ($("#ocupacion6").is(":checked")) {
        ocupacion6 = 1;
      }
      if ($("#ocupacion7").is(":checked")) {
        ocupacion7 = 1;
      }
      if ($("#ocupacion8").is(":checked")) {
        ocupacion8 = 1;
      }
      if ($("#ocupacion9").is(":checked")) {
        ocupacion9 = 1;
      }
      if ($("#ocupacion10").is(":checked")) {
        ocupacion10 = 1;
      }
      if ($("#ocupacion11").is(":checked")) {
        ocupacion11 = 1;
      }
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Caracteristicas del Cancer
    try {
      if ($("#sp1").is(":checked")) {
        sp1 = 1;
      }
      if ($("#sp2").is(":checked")) {
        sp2 = 1;
      }
      if ($("#sp3").is(":checked")) {
        sp3 = 1;
      }
      if ($("#th1").is(":checked")) {
        th1 = 1;
      }
      if ($("#th2").is(":checked")) {
        th2 = 1;
      }
      if ($("#th3").is(":checked")) {
        th3 = 1;
      }
      if ($("#th4").is(":checked")) {
        th4 = 1;
      }
      if ($("#th5").is(":checked")) {
        th5 = 1;
      }
      comportamientoobservacion = $("#comportamientoobservacion").val();
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Grado
    try {
      if ($("#grado1").is(":checked")) {
        grado1 = 1;
      }
      if ($("#grado2").is(":checked")) {
        grado2 = 1;
      }
      if ($("#grado3").is(":checked")) {
        grado3 = 1;
      }
      if ($("#grado4").is(":checked")) {
        grado4 = 1;
      }
      if ($("#grado5").is(":checked")) {
        grado5 = 1;
      }
      //Validar que se haya seleccionado al menos un grado
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Extension
    try {
      if ($("#extension1").is(":checked")) {
        extension1 = 1;
      }
      if ($("#extension2").is(":checked")) {
        extension2 = 1;
      }
      if ($("#extension3").is(":checked")) {
        extension3 = 1;
      }
      if ($("#extension4").is(":checked")) {
        extension4 = 1;
      }
      if ($("#extension5").is(":checked")) {
        extension5 = 1;
      }
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Lateralidad
    try {
      if ($("#lateralidad1").is(":checked")) {
        lateralidad1 = 1;
      }
      if ($("#lateralidad2").is(":checked")) {
        lateralidad2 = 1;
      }
      if ($("#lateralidad3").is(":checked")) {
        lateralidad3 = 1;
      }
      if ($("#lateralidad4").is(":checked")) {
        lateralidad4 = 1;
      }
      if ($("#lateralidad5").is(":checked")) {
        lateralidad5 = 1;
      }
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Incidencia y Base del Diagnóstico
    try {
      if ($("#basediagnostico1").is(":checked")) {
        basediagnostico1 = 1;
      }
      if ($("#basediagnostico2").is(":checked")) {
        basediagnostico2 = 1;
      }
      if ($("#basediagnostico3").is(":checked")) {
        basediagnostico3 = 1;
      }
      if ($("#basediagnostico4").is(":checked")) {
        basediagnostico4 = 1;
      }
      if ($("#basediagnostico5").is(":checked")) {
        basediagnostico5 = 1;
      }
      if ($("#basediagnostico6").is(":checked")) {
        basediagnostico6 = 1;
      }
      if ($("#basediagnostico7").is(":checked")) {
        basediagnostico7 = 1;
      }
      if ($("#basediagnostico8").is(":checked")) {
        basediagnostico8 = 1;
      }
      if ($("#basediagnostico9").is(":checked")) {
        basediagnostico9 = 1;
      }
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Fuente Incidencia
    try {
      if ($("#fuente1").is(":checked")) {
        fuente1 = 1;
        fechapacex1 = $("#fechapacex1").val();
        fechahospex1 = $("#fechahospex1").val();
        horahospex1 = $("#horahospex1").val();
      }
      if ($("#fuente2").is(":checked")) {
        fuente2 = 1;
        fechapacex2 = $("#fechapacex2").val();
        fechahospex2 = $("#fechahospex2").val();
        horahospex2 = $("#horahospex2").val();
      }
      if ($("#fuente3").is(":checked")) {
        fuente3 = 1;
        fechapacex3 = $("#fechapacex3").val();
        fechahospex3 = $("#fechahospex3").val();
        horahospex3 = $("#horahospex3").val();
      }
      
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Validaciones de Ultimos Detalles
    try {
      if (estadio == 2) {
        var defuncion = $("#defuncion").val();
        if (defuncion.trim().length < 10) {
          ToastifyError("Debe ingresar la fecha de defunción");
          return false;
        }
        if ($("#causa").val() == "") {
          ToastifyError("Debe seleccionar una causa");
          return false;
        }
        causa = $("#causa").val();
        if (observacionfinal.trim().length == 0) {
          ToastifyError("Debe ingresar una observación final");
          return false;
        }
      }
    } catch (error) {
      ToastifyError(error);
      return false;
    }
  
    //Enviar Datos
    $.ajax({
      url: "php/update/registropoblacional.php",
      type: "POST",
      data: {
        idregistro: idregistro,
        provenencia: provenencia,
        rama1: rama1,
        rama2: rama2,
        rama3: rama3,
        rama4: rama4,
        rama5: rama5,
        rama6: rama6,
        rama7: rama7,
        rama8: rama8,
        rama9: rama9,
        rama10: rama10,
        ocupacion1: ocupacion1,
        ocupacion2: ocupacion2,
        ocupacion3: ocupacion3,
        ocupacion4: ocupacion4,
        ocupacion5: ocupacion5,
        ocupacion6: ocupacion6,
        ocupacion7: ocupacion7,
        ocupacion8: ocupacion8,
        ocupacion9: ocupacion9,
        ocupacion10: ocupacion10,
        ocupacion11: ocupacion11,
        sp1: sp1,
        sp2: sp2,
        sp3: sp3,
        th1: th1,
        th2: th2,
        th3: th3,
        th4: th4,
        th5: th5,
        comportamiento: comportamiento,
        comportamientoobservacion: comportamientoobservacion,
        grado1: grado1,
        grado2: grado2,
        grado3: grado3,
        grado4: grado4,
        grado5: grado5,
        extension1: extension1,
        extension2: extension2,
        extension3: extension3,
        extension4: extension4,
        extension5: extension5,
        lateralidad1: lateralidad1,
        lateralidad2: lateralidad2,
        lateralidad3: lateralidad3,
        lateralidad4: lateralidad4,
        lateralidad5: lateralidad5,
        fechaincidencia: fechaincidencia,
        horaincidencia: horaincidencia,
        basediagnostico1: basediagnostico1,
        basediagnostico2: basediagnostico2,
        basediagnostico3: basediagnostico3,
        basediagnostico4: basediagnostico4,
        basediagnostico5: basediagnostico5,
        basediagnostico6: basediagnostico6,
        basediagnostico7: basediagnostico7,
        basediagnostico8: basediagnostico8,
        basediagnostico9: basediagnostico9,
        fuente1: fuente1,
        fechapacex1: fechapacex1,
        fechahospex1: fechahospex1,
        horahospex1: horahospex1,
        fuente2: fuente2,
        fechapacex2: fechapacex2,
        fechahospex2: fechahospex2,
        horahospex2: horahospex2,
        fuente3: fuente3,
        fechapacex3: fechapacex3,
        fechahospex3: fechahospex3,
        horahospex3: horahospex3,
        fechaultimocontacto: fechaultimocontacto,
        estadio: estadio,
        defuncion: defuncion,
        causa: causa,
        observacionfinal: observacionfinal,
      },
      success: function (data) {
        try {
          var json = JSON.parse(data);
          if(json.status==true){
              ToastifySuccess(json.message);
              return true;
          }else{
              ToastifyError(json.message);
              return false;
          }
        } catch (error) {
          ToastifyError(error);
          return false;
          
        }
      },
      error: function (data) {
        ToastifyError("Error al Actualizar el registro poblacional");
        return false;
      },
    });
  }
  