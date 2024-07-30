/********************************************************************************************************************************* */
var tnm = [];
//Informe Paciente
//agregarDiagnosticoCIE10
function agregarDiagnosticoCIE10(id, nombre) {
  $("#diagnosticocie10").val(nombre);
  $("#idcie10").val(id);
  $("#modaldiagcie10").modal("hide");
}

function agregarDiagnosticos(id, nombre) {
  $("#diagnostico").val(nombre);
  $("#iddiag").val(id);
  $("#modaldiagnosticos").modal("hide");
  cargartnmdiagnostico(1, id);
  cargartnmdiagnostico(2, id);
  cargartnmdiagnostico(3, id);
  limpiartnm();
}

/*************************************************************************************************************************************************************************** */

function addtnm() {
  var t1 = $("#t1").val();
  var t2 = $("#t2").val();
  const t = $("#t").val();
  var ttext = $("#t option:selected").text();
  if (t <= 0) {
    ToastifyError("Debe seleccionar la T");
    return;
  }
  var n1 = $("#n1").val();
  var n = $("#n").val();
  var ntext = $("#n option:selected").text();
  if (n <= 0) {
    ToastifyError("Debe seleccionar la N");
    return;
  }
  var m1 = $("#m1").val();
  var m = $("#m").val();
  var mtext = $("#m option:selected").text();
  if (m <= 0) {
    ToastifyError("Debe seleccionar la M");
    return;
  }
  var m2 = $("#m2").val();
  //Validar si ya existe el tnm
  if (validartnm(t1, t2, t, ttext, n1, n, ntext, m1, m, mtext, m2)) {
    ToastifyError("Ya existe el TNM seleccionado");
    return;
  }
  pushtnm(t1, t2, t, ttext, n1, n, ntext, m1, m, mtext, m2);
  cargartnm();
}

function validartnm(t1, t2, t, ttext, n1, n, ntext, m1, m, mtext, m2) {
  for (var i = 0; i < tnm.length; i++) {
    if (
      tnm[i].t1 == t1 &&
      tnm[i].t2 == t2 &&
      tnm[i].ttext == ttext &&
      tnm[i].n1 == n1 &&
      tnm[i].n == n &&
      tnm[i].ntext == ntext &&
      tnm[i].m1 == m1 &&
      tnm[i].m == m &&
      tnm[i].mtext == mtext &&
      tnm[i].m2 == m2
    ) {
      return true;
    }
  }
  return false;
}

function pushtnm(t1, t2, t, ttext, n1, n, ntext, m1, m, mtext, m2) {
  tnm.push({
    t1: t1,
    t2: t2,
    t: t,
    ttext: ttext,
    n1: n1,
    n: n,
    ntext: ntext,
    m1: m1,
    m: m,
    mtext: mtext,
    m2: m2,
  });
}
function eliminartnm(index) {
  tnm.splice(index, 1);
  cargartnm();
}

function limpiartnm() {
  tnm = [];
  cargartnm();
}

function vistapreviainforme(paciente, comite) {
  //Diagnostico
  var diagnostico = $("#iddiag").val();
  var diagnosticotext = $("#diagnostico").val();
  var diagnosticocie10 = $("#idcie10").val();
  var diagnosticocie10text = $("#diagnosticocie10").val();

  //Fecha biopsia
  var fechabiopsia = $("#fechabiopsia").val();
  //Reingreso
  var reingreso = 0;
  if ($("#reingreso").is(":checked")) {
    reingreso = 1;
  }

  //Ecog
  var ecog = $("#ecog").val();
  var ecogtext = $("#ecog option:selected").text();
  //Histologico
  var histologico = $("#histologico").val();
  var histologicotext = $("#histologico option:selected").text();
  //invasiontumoral
  var invasiontumoral = $("#invasiontumoral").val();
  var invasiontumoraltext = $("#invasiontumoral option:selected").text();
  //mitotico
  var mitotico = $("#mitotico").val();

  //TNM
  if (tnm.length <= 0) {
    ToastifyError("Debe ingresar al menos un TNM");
    return;
  }
  var observaciontnm = $("#observaciontnm").val();

  //anamnesis
  var anamnesis = $("#anamnesis").val();

  //Decision tomada
  var cirugia = 0;
  //Validar si se selecciono cirugia
  if ($("#cirugia").is(":checked")) {
    cirugia = $("#cirugia").val();
  }
  var quimioterapia = 0;
  //Validar si se selecciono quimioterapia
  if ($("#quimioterapia").is(":checked")) {
    quimioterapia = $("#quimioterapia").val();
  }
  var radioterapia = 0;
  //Validar si se selecciono radioterapia
  if ($("#radioterapia").is(":checked")) {
    radioterapia = $("#radioterapia").val();
  }
  var otros = 0;
  //Validar si se selecciono otros
  if ($("#otros").is(":checked")) {
    otros = $("#otros").val();
  }
  var seguimiento = 0;
  //Validar si se selecciono seguimiento
  if ($("#seguimiento").is(":checked")) {
    seguimiento = $("#seguimiento").val();
  }
  var completar = 0;
  //Validar si se selecciono completar
  if ($("#completar").is(":checked")) {
    completar = $("#completar").val();
  }
  var revaluacion = 0;
  //Validar si se selecciono revaluacion
  if ($("#revaluacion").is(":checked")) {
    revaluacion = $("#revaluacion").val();
  }
  var estudioclinicno = 0;
  //Validar si se selecciono estudioclinicno
  if ($("#estudioclinico").is(":checked")) {
    estudioclinicno = $("#estudioclinico").val();
  }

  //Validar que se haya seleccionado al menos una decision
  if (
    cirugia == 0 &&
    quimioterapia == 0 &&
    radioterapia == 0 &&
    otros == 0 &&
    seguimiento == 0 &&
    completar == 0 &&
    revaluacion == 0 &&
    estudioclinicno == 0
  ) {
    ToastifyError("Debe seleccionar al menos una decision tomada");
    return;
  }
  var observacionesdecision = $("#observacionesdecision").val();

  //Plan Asistencial
  var consultade = $("#consultade").val();
  var consultadetext = $("#consultade option:selected").text();
  //Validar el consultade
  if (consultade <= 0) {
    ToastifyError("Debe ingresar seleccionar el consultade");
    return;
  }

  var programacion = 0;
  //Validar si se selecciono programacion
  if ($("#programacion").is(":checked")) {
    programacion = $("#programacion").val();
  }
  var traslado = 0;
  //Validar si se selecciono traslado
  if ($("#traslado").is(":checked")) {
    traslado = $("#traslado").val();
  }
  var paliativos = 0;
  //Validar si se selecciono paliativos
  if ($("#paliativos").is(":checked")) {
    paliativos = $("#paliativos").val();
  }
  var ingreso = 0;
  //Validar si se selecciono ingreso
  if ($("#ingreso").is(":checked")) {
    ingreso = $("#ingreso").val();
  }

  var observacionplan = $("#observacionplan").val();
  //SI el observacionplan esta vacia, preguntar si esta seguro de dejarlo vacia

  //Relosucion
  var resolucion = $("#resolucion").val();
  //SI el resolucion esta vacia, preguntar si esta seguro de dejarlo vacia

  //Registrar el informe
  //Registrar el informe
  var informe = {
    paciente: paciente,
    comite: comite,
    diagnostico: diagnostico,
    diagnosticotext: diagnosticotext,
    diagnosticocie10: diagnosticocie10,
    diagnosticocie10text: diagnosticocie10text,
    fechabiopsia: fechabiopsia,
    reingreso: reingreso,
    ecog: ecog,
    ecogtext: ecogtext,
    histologico: histologico,
    histologicotext: histologicotext,
    invasiontumoral: invasiontumoral,
    invasiontumoraltext: invasiontumoraltext,
    mitotico: mitotico,
    tnm: tnm,
    observaciontnm: observaciontnm,
    anamnesis: anamnesis,
    cirugia: cirugia,
    quimioterapia: quimioterapia,
    radioterapia: radioterapia,
    otros: otros,
    seguimiento: seguimiento,
    completar: completar,
    revaluacion: revaluacion,
    estudioclinicno: estudioclinicno,
    observacionesdecision: observacionesdecision,
    consultade: consultade,
    consultadetext: consultadetext,
    programacion: programacion,
    traslado: traslado,
    paliativos: paliativos,
    ingreso: ingreso,
    observacionplan: observacionplan,
    resolucion: resolucion,
  };

  //Cargar la vista previa
  //Cargar los datos en la vista previa
  $("#frameprevia").attr(
    "src",
    "php/reporte/previa/informecomite.php?informe=" + JSON.stringify(informe)
  );
  $("#modalprevia").modal("show");
}

function guardarinforme(paciente, comite) {
  //Diagnostico
  var diagnostico = $("#iddiag").val();
  var diagnosticotext = $("#diagnostico").val();
  if (diagnostico <= 0 || diagnosticotext.trim().length <= 0) {
    ToastifyError("Debe seleccionar un diagnostico");
    return;
  }
  var diagnosticocie10 = $("#idcie10").val();
  var diagnosticocie10text = $("#diagnosticocie10").val();
  if (diagnosticocie10 <= 0 || diagnosticocie10text.trim().length <= 0) {
    ToastifyError("Debe seleccionar un diagnostico CIE10");
    return;
  }

  //Fecha biopsia
  var fechabiopsia = $("#fechabiopsia").val();
  //Reingreso
  var reingreso = 0;
  if ($("#reingreso").is(":checked")) {
    reingreso = 1;
  }

  //Ecog
  var ecog = $("#ecog").val();
  var ecogtext = $("#ecog option:selected").text();
  //Histologico
  var histologico = $("#histologico").val();
  var histologicotext = $("#histologico option:selected").text();
  //invasiontumoral
  var invasiontumoral = $("#invasiontumoral").val();
  var invasiontumoraltext = $("#invasiontumoral option:selected").text();
  //mitotico
  var mitotico = $("#mitotico").val();

  //TNM
  if (tnm.length <= 0) {
    ToastifyError("Debe ingresar al menos un TNM");
    return;
  }
  var observaciontnm = $("#observaciontnm").val();

  //anamnesis
  var anamnesis = $("#anamnesis").val();

  //Decision tomada
  var cirugia = 0;
  //Validar si se selecciono cirugia
  if ($("#cirugia").is(":checked")) {
    cirugia = $("#cirugia").val();
  }
  var quimioterapia = 0;
  //Validar si se selecciono quimioterapia
  if ($("#quimioterapia").is(":checked")) {
    quimioterapia = $("#quimioterapia").val();
  }
  var radioterapia = 0;
  //Validar si se selecciono radioterapia
  if ($("#radioterapia").is(":checked")) {
    radioterapia = $("#radioterapia").val();
  }
  var otros = 0;
  //Validar si se selecciono otros
  if ($("#otros").is(":checked")) {
    otros = $("#otros").val();
  }
  var seguimiento = 0;
  //Validar si se selecciono seguimiento
  if ($("#seguimiento").is(":checked")) {
    seguimiento = $("#seguimiento").val();
  }
  var completar = 0;
  //Validar si se selecciono completar
  if ($("#completar").is(":checked")) {
    completar = $("#completar").val();
  }
  var revaluacion = 0;
  //Validar si se selecciono revaluacion
  if ($("#revaluacion").is(":checked")) {
    revaluacion = $("#revaluacion").val();
  }
  var estudioclinicno = 0;
  //Validar si se selecciono estudioclinicno
  if ($("#estudioclinico").is(":checked")) {
    estudioclinicno = $("#estudioclinico").val();
  }

  //Validar que se haya seleccionado al menos una decision
  if (
    cirugia == 0 &&
    quimioterapia == 0 &&
    radioterapia == 0 &&
    otros == 0 &&
    seguimiento == 0 &&
    completar == 0 &&
    revaluacion == 0 &&
    estudioclinicno == 0
  ) {
    ToastifyError("Debe seleccionar al menos una decision tomada");
    return;
  }
  var observacionesdecision = $("#observacionesdecision").val();

  //Plan Asistencial
  var consultade = $("#consultade").val();
  var consultadetext = $("#consultade option:selected").text();
  //Validar el consultade
  if (consultade <= 0) {
    ToastifyError("Debe ingresar seleccionar el consultade");
    return;
  }

  var programacion = 0;
  //Validar si se selecciono programacion
  if ($("#programacion").is(":checked")) {
    programacion = $("#programacion").val();
  }
  var traslado = 0;
  //Validar si se selecciono traslado
  if ($("#traslado").is(":checked")) {
    traslado = $("#traslado").val();
  }
  var paliativos = 0;
  //Validar si se selecciono paliativos
  if ($("#paliativos").is(":checked")) {
    paliativos = $("#paliativos").val();
  }
  var ingreso = 0;
  //Validar si se selecciono ingreso
  if ($("#ingreso").is(":checked")) {
    ingreso = $("#ingreso").val();
  }

  //Revisar si esta chequedar el completereg
  var completar = 0;
  //Validar si se selecciono completar
  if ($("#completereg").is(":checked")) {
    completar = 1;
    var valid = registropoblacional();
    console.log(valid);
    if (valid == false) {
      return;
    }
  }

  var observacionplan = $("#observacionplan").val();
  //SI el observacionplan esta vacia, preguntar si esta seguro de dejarlo vacia

  //Relosucion
  var resolucion = $("#resolucion").val();
  //SI el resolucion esta vacia, preguntar si esta seguro de dejarlo vacia

  var previo = $("#previo").val();

  //Registrar el informe
  //Registrar el informe
  var informe = {
    paciente: paciente,
    comite: comite,
    diagnostico: diagnostico,
    diagnosticotext: diagnosticotext,
    diagnosticocie10: diagnosticocie10,
    diagnosticocie10text: diagnosticocie10text,
    fechabiopsia: fechabiopsia,
    reingreso: reingreso,
    ecog: ecog,
    ecogtext: ecogtext,
    histologico: histologico,
    histologicotext: histologicotext,
    invasiontumoral: invasiontumoral,
    invasiontumoraltext: invasiontumoraltext,
    mitotico: mitotico,
    tnm: tnm,
    observaciontnm: observaciontnm,
    anamnesis: anamnesis,
    cirugia: cirugia,
    quimioterapia: quimioterapia,
    radioterapia: radioterapia,
    otros: otros,
    seguimiento: seguimiento,
    completar: completar,
    revaluacion: revaluacion,
    estudioclinicno: estudioclinicno,
    observacionesdecision: observacionesdecision,
    consultade: consultade,
    consultadetext: consultadetext,
    programacion: programacion,
    traslado: traslado,
    paliativos: paliativos,
    ingreso: ingreso,
    observacionplan: observacionplan,
    resolucion: resolucion,
  };

  //Registrar el informe
  $.ajax({
    url: "php/insert/informe.php",
    type: "POST",
    data: informe,
    success: function (data) {
      try {
        var json = JSON.parse(data);
        if (json.status == true) {
          ToastifySuccess(json.message);
          setTimeout(function () {
            window.location.href = previo;
          }, 500);
        } else {
          ToastifyError(json.message);
        }
      } catch (error) {
        ToastifyError(error);
      }
    },
  });
}

function editarinforme(paciente, comite) {
  var id = $("#idinforme").val();
  var folio = $("#folio").val();
  //Diagnostico
  var diagnostico = $("#iddiag").val();
  var diagnosticotext = $("#diagnostico").val();
  if (diagnostico <= 0 || diagnosticotext.trim().length <= 0) {
    ToastifyError("Debe seleccionar un diagnostico");
    return;
  }
  var diagnosticocie10 = $("#idcie10").val();
  var diagnosticocie10text = $("#diagnosticocie10").val();
  if (diagnosticocie10 <= 0 || diagnosticocie10text.trim().length <= 0) {
    ToastifyError("Debe seleccionar un diagnostico CIE10");
    return;
  }

  //Fecha biopsia
  var fechabiopsia = $("#fechabiopsia").val();
  //Reingreso
  var reingreso = 0;
  if ($("#reingreso").is(":checked")) {
    reingreso = 1;
  }

  //Ecog
  var ecog = $("#ecog").val();
  var ecogtext = $("#ecog option:selected").text();
  //Histologico
  var histologico = $("#histologico").val();
  var histologicotext = $("#histologico option:selected").text();
  //invasiontumoral
  var invasiontumoral = $("#invasiontumoral").val();
  var invasiontumoraltext = $("#invasiontumoral option:selected").text();
  //mitotico
  var mitotico = $("#mitotico").val();

  //TNM
  if (tnm.length <= 0) {
    ToastifyError("Debe ingresar al menos un TNM");
    return;
  }
  var observaciontnm = $("#observaciontnm").val();

  //anamnesis
  var anamnesis = $("#anamnesis").val();

  //Decision tomada
  var cirugia = 0;
  //Validar si se selecciono cirugia
  if ($("#cirugia").is(":checked")) {
    cirugia = $("#cirugia").val();
  }
  var quimioterapia = 0;
  //Validar si se selecciono quimioterapia
  if ($("#quimioterapia").is(":checked")) {
    quimioterapia = $("#quimioterapia").val();
  }
  var radioterapia = 0;
  //Validar si se selecciono radioterapia
  if ($("#radioterapia").is(":checked")) {
    radioterapia = $("#radioterapia").val();
  }
  var otros = 0;
  //Validar si se selecciono otros
  if ($("#otros").is(":checked")) {
    otros = $("#otros").val();
  }
  var seguimiento = 0;
  //Validar si se selecciono seguimiento
  if ($("#seguimiento").is(":checked")) {
    seguimiento = $("#seguimiento").val();
  }
  var completar = 0;
  //Validar si se selecciono completar
  if ($("#completar").is(":checked")) {
    completar = $("#completar").val();
  }
  var revaluacion = 0;
  //Validar si se selecciono revaluacion
  if ($("#revaluacion").is(":checked")) {
    revaluacion = $("#revaluacion").val();
  }
  var estudioclinicno = 0;
  //Validar si se selecciono estudioclinicno
  if ($("#estudioclinico").is(":checked")) {
    estudioclinicno = $("#estudioclinico").val();
  }

  //Validar que se haya seleccionado al menos una decision
  if (
    cirugia == 0 &&
    quimioterapia == 0 &&
    radioterapia == 0 &&
    otros == 0 &&
    seguimiento == 0 &&
    completar == 0 &&
    revaluacion == 0 &&
    estudioclinicno == 0
  ) {
    ToastifyError("Debe seleccionar al menos una decision tomada");
    return;
  }
  var observacionesdecision = $("#observacionesdecision").val();

  //Plan Asistencial
  var consultade = $("#consultade").val();
  var consultadetext = $("#consultade option:selected").text();
  //Validar el consultade
  if (consultade <= 0) {
    ToastifyError("Debe ingresar seleccionar el consultade");
    return;
  }

  var programacion = 0;
  //Validar si se selecciono programacion
  if ($("#programacion").is(":checked")) {
    programacion = $("#programacion").val();
  }
  var traslado = 0;
  //Validar si se selecciono traslado
  if ($("#traslado").is(":checked")) {
    traslado = $("#traslado").val();
  }
  var paliativos = 0;
  //Validar si se selecciono paliativos
  if ($("#paliativos").is(":checked")) {
    paliativos = $("#paliativos").val();
  }
  var ingreso = 0;
  //Validar si se selecciono ingreso
  if ($("#ingreso").is(":checked")) {
    ingreso = $("#ingreso").val();
  }

  //Revisar si esta chequedar el completereg
  var completar = 0;
  //Validar si se selecciono completar
  if ($("#completereg").is(":checked")) {
    completar = 1;
    var valid = registropoblacional();
    console.log(valid);
    if (valid == false) {
      return;
    }
  }

  var observacionplan = $("#observacionplan").val();
  //SI el observacionplan esta vacia, preguntar si esta seguro de dejarlo vacia

  //Relosucion
  var resolucion = $("#resolucion").val();
  //SI el resolucion esta vacia, preguntar si esta seguro de dejarlo vacia

  var previo = $("#previo").val();

  //Registrar el informe
  //Registrar el informe
  var informe = {
    id: id,
    folio: folio,
    paciente: paciente,
    comite: comite,
    diagnostico: diagnostico,
    diagnosticotext: diagnosticotext,
    diagnosticocie10: diagnosticocie10,
    diagnosticocie10text: diagnosticocie10text,
    fechabiopsia: fechabiopsia,
    reingreso: reingreso,
    ecog: ecog,
    ecogtext: ecogtext,
    histologico: histologico,
    histologicotext: histologicotext,
    invasiontumoral: invasiontumoral,
    invasiontumoraltext: invasiontumoraltext,
    mitotico: mitotico,
    tnm: tnm,
    observaciontnm: observaciontnm,
    anamnesis: anamnesis,
    cirugia: cirugia,
    quimioterapia: quimioterapia,
    radioterapia: radioterapia,
    otros: otros,
    seguimiento: seguimiento,
    completar: completar,
    revaluacion: revaluacion,
    estudioclinicno: estudioclinicno,
    observacionesdecision: observacionesdecision,
    consultade: consultade,
    consultadetext: consultadetext,
    programacion: programacion,
    traslado: traslado,
    paliativos: paliativos,
    ingreso: ingreso,
    observacionplan: observacionplan,
    resolucion: resolucion,
  };

  //Registrar el informe
  $.ajax({
    url: "php/update/informe.php",
    type: "POST",
    data: informe,
    success: function (data) {
      try {
        var json = JSON.parse(data);
        if (json.status == true) {
          ToastifySuccess(json.message);
          setTimeout(function () {
            window.location.href = previo;
          }, 500);
        } else {
          ToastifyError(json.message);
        }
      } catch (error) {
        ToastifyError(error);
      }
    },
  });
}

function cargartnm() {
  console.log(tnm);
  var html = "";
  for (var i = 0; i < tnm.length; i++) {
    html += "<tr>";
    html += "<td>" + tnm[i].t1 + "</td>";
    html += "<td>" + tnm[i].t2 + "</td>";
    html += "<td>" + tnm[i].ttext + "</td>";
    html += "<td>" + tnm[i].n1 + "</td>";
    html += "<td>" + tnm[i].ntext + "</td>";
    html += "<td>" + tnm[i].m1 + "</td>";
    html += "<td>" + tnm[i].mtext + "</td>";
    html += "<td>" + tnm[i].m2 + "</td>";
    html +=
      "<td><button type='button' class='btn btn-danger' onclick='eliminartnm(" +
      i +
      ")'><i class='fas fa-trash-alt'></i></button></td>";
    html += "</tr>";
  }
  $("#tnmbody").html(html);
}

function cargartnm1() {
  var id = $("#idinforme").val();
  $.ajax({
    url: "php/charge/tnm.php",
    type: "POST",
    data: { id: id },
    success: function (respuesta) {
      try {
        var data = JSON.parse(respuesta);
        if (data.status == true) {
          var tnm = data.tnm;
          for (var i = 0; i < tnm.length; i++) {
            pushtnm(
              tnm[i].t1,
              tnm[i].t2,
              tnm[i].t,
              tnm[i].ttexto,
              tnm[i].n1,
              tnm[i].n,
              tnm[i].ntexto,
              tnm[i].m1,
              tnm[i].m,
              tnm[i].mtexto,
              tnm[i].m2
            );
          }
          cargartnm();
        } else {
          ToastifyError(data.message);
        }
      } catch (error) {
        ToastifyError(error);
      }
    },
  });
}

$(document).ready(function () {
  //Evento al cambiar el el estado de checkbox de citacion
  $("#citacion").on("change", function () {
    if ($("#citacion").is(":checked")) {
      $(".consulta").show();
      $("#consultade").attr("required", true);
    } else {
      $(".consulta").hide();
      $("#consultade").attr("required", false);
    }
  });

  $("#formsignos").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "php/insert/signos.php",
      type: "POST",
      data: $("#formsignos").serialize(),
      success: function (respuesta) {
        respuesta = respuesta.trim();
        if (respuesta == 1) {
          ToastifySuccess("Se registro los signos vitales correctamente");
          cargarsignos();
        } else {
          ToastifyError(respuesta);
        }
      },
    });
  });
  $("#formmedidas").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "php/insert/medidas.php",
      type: "POST",
      data: $("#formmedidas").serialize(),
      success: function (respuesta) {
        respuesta = respuesta.trim();
        if (respuesta == 1) {
          ToastifySuccess("Se registro las medidas correctamente");
          cargarmedidas();
        } else {
          ToastifyError(respuesta);
        }
      },
    });
  });
});

function cargarsignos() {
  var paciente = $("#pacienteid").val();
  $.ajax({
    url: "php/charge/signosvitales.php",
    type: "POST",
    data: { id: paciente },
    success: function (respuesta) {
      $("#signos").html(respuesta);
    },
  });
}

function cargarmedidas() {
  var paciente = $("#pacienteid").val();
  $.ajax({
    url: "php/charge/medidas.php",
    type: "POST",
    data: { id: paciente },
    success: function (respuesta) {
      $("#medidas").html(respuesta);
    },
  });
}
