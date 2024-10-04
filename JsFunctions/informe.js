/********************************************************************************************************************************* */
var tnm = [];
$(document).ready(function () {
  cargita();
});
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
  cargita();
}
function cargita() {
  var id = $("#iddiag").val();
  if (id > 0) {
    cargartnmdiagnostico(1, id);
    cargartnmdiagnostico(2, id);
    cargartnmdiagnostico(3, id);
    limpiartnm();
  }
}
/*************************************************************************************************************************************************************************** */

function addtnm() {
  var t1 = $("#t1").val();
  const t = $("#t").val();
  var ttext = $("#t option:selected").text();
  if (t <= 0) {
    ToastifyError("Debe seleccionar la T");
    return;
  }
  var n = $("#n").val();
  var ntext = $("#n option:selected").text();
  if (n <= 0) {
    ToastifyError("Debe seleccionar la N");
    return;
  }
  var m = $("#m").val();
  var mtext = $("#m option:selected").text();
  if (m <= 0) {
    ToastifyError("Debe seleccionar la M");
    return;
  }
  //Validar si ya existe el tnm
  if (validartnm(t1, t, ttext, n, ntext, m, mtext)) {
    ToastifyError("Ya existe el TNM seleccionado");
    return;
  }
  pushtnm(t1, t, ttext, n, ntext, m, mtext);
  cargartnm();
}

function validartnm(t1, t, ttext, n, ntext, m, mtext) {
  for (var i = 0; i < tnm.length; i++) {
    if (
      tnm[i].t1 == t1 &&
      tnm[i].t == t &&
      tnm[i].ttext == ttext &&
      tnm[i].n == n &&
      tnm[i].ntext == ntext &&
      tnm[i].m == m &&
      tnm[i].mtext == mtext
    ) {
      return true;
    }
  }
  return false;
}

function pushtnm(t1, t, ttext, n, ntext, m, mtext) {
  tnm.push({
    t1: t1,
    t: t,
    ttext: ttext,
    n: n,
    ntext: ntext,
    m: m,
    mtext: mtext
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
  var peso = $("#peso").val();
  var talla = $("#talla").val();
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
    peso: peso,
    talla: talla
  };

  //Cargar la vista previa
  //Cargar los datos en la vista previa
  $("#frameprevia").attr(
    "src",
    "php/reporte/previa/informecomite.php?informe=" + JSON.stringify(informe)
  );
  $("#modalprevia").modal("show");
}

function calcsup() {
  var peso = $("#peso").val();
  var talla = $("#talla").val();
  if (peso <= 0 || talla <= 0) {
    $("#sup").val(0);
    return;
  }
  var sup = 0.007184 * Math.pow(peso, 0.425) * Math.pow(talla, 0.725);
  sup = sup.toFixed(2);
  $("#sup").val(sup);
}

function guardarinforme(paciente, comite) {
  var peso = $("#peso").val();
  var talla = $("#talla").val();
  var sup = $("#sup").val();
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

  registropoblacional();

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
    peso: peso,
    talla: talla,
    sup: sup
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
          cargarmedidas();
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

  var peso = $("#peso").val();
  var talla = $("#talla").val();

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

  registropoblacional();
  

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
    peso: peso,
    talla: talla
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
          cargarmedidas();
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

function guardarborrador(paciente, comite) {
  var peso = $("#peso").val();
  var talla = $("#talla").val();
  var sup = $("#sup").val();
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

  var observacionesdecision = $("#observacionesdecision").val();

  //Plan Asistencial
  var consultade = $("#consultade").val();
  var consultadetext = $("#consultade option:selected").text();

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

  var resolucion = $("#resolucion").val();


  //Seccion de registro poblacional
  var completereg = 0;
  //Validar si se selecciono completar
  if ($("#completereg").is(":checked")) {
    completereg = $("#completereg").val();
  }
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
  var fichapacex1 = "";
  var fechahospex1 = "";
  var horahospex1 = "";
  var fuente2 = 0;
  var fichapacex2 = "";
  var fechahospex2 = "";
  var horahospex2 = "";
  var fuente3 = 0;
  var fichapacex3 = "";
  var fechahospex3 = "";
  var horahospex3 = "";

  //Ultimos Detalles
  var fechaultimocontacto = $("#fechacontacto").val();
  var estadio = 0;
  if ($("#estadio1").is(":checked")) {
    estadio = 1;
  } else if ($("#estadio2").is(":checked")) {
    estadio = 2;
  } else if ($("#estadio3").is(":checked")) {
    estadio = 3;
  } else {
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
  sp1 = $("#sp1").val();
  sp2 = $("#sp2").val();
  sp3 = $("#sp3").val();
  th1 = $("#th1").val();
  th2 = $("#th2").val();
  th3 = $("#th3").val();
  th4 = $("#th4").val();
  th5 = $("#th5").val();
  comportamiento = $("#comportamiento").val();
  comportamientoobservacion = $("#comportamientoobservaciones").val();

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
    if ($("#baseDiagnostico1").is(":checked")) {
      basediagnostico1 = 1;
    }
    if ($("#baseDiagnostico2").is(":checked")) {
      basediagnostico2 = 1;
    }
    if ($("#baseDiagnostico3").is(":checked")) {
      basediagnostico3 = 1;
    }
    if ($("#baseDiagnostico4").is(":checked")) {
      basediagnostico4 = 1;
    }
    if ($("#baseDiagnostico5").is(":checked")) {
      basediagnostico5 = 1;
    }
    if ($("#baseDiagnostico6").is(":checked")) {
      basediagnostico6 = 1;
    }
    if ($("#baseDiagnostico7").is(":checked")) {
      basediagnostico7 = 1;
    }
    if ($("#baseDiagnostico8").is(":checked")) {
      basediagnostico8 = 1;
    }
    if ($("#baseDiagnostico9").is(":checked")) {
      basediagnostico9 = 1;
    }

  } catch (error) {
    ToastifyError(error);
    return false;
  }

  //Validaciones de Fuente Incidencia
  fuente1 = $("#fuente1").val();
  fichapacex1 = $("#fichaPaciente1").val();
  fechahospex1 = $("#fechaHospital1").val();
  horahospex1 = $("#horaHospital1").val();

  fuente2 = $("#fuente2").val();
  fichapacex2 = $("#fichaPaciente2").val();
  fechahospex2 = $("#fechaHospital2").val();
  horahospex2 = $("#horaHospital2").val();


  fuente3 = $("#fuente3").val();
  fichapacex3 = $("#fichaPaciente3").val();
  fechahospex3 = $("#fechaHospital3").val();
  horahospex3 = $("#horaHospital3").val();
  previo = $("#previo").val();
  //Validaciones de Ultimos Detalles
  try {
    if (estadio == 2) {
      var defuncion = $("#defuncion").val();
      var causa1 = 0;
      var causa2 = 0;
      var causa3 = 0;
      if ($("#causa1").is(":checked")) {
        causa1 = 1;
        causa = 1;
      }
      if ($("#causa2").is(":checked")) {
        causa2 = 1;
        causa = 2;
      }
      if ($("#causa3").is(":checked")) {
        causa3 = 1;
        causa = 3;
      }
    }
  } catch (error) {
    ToastifyError("Pwwww!" + error);
    return false;
  }

  var datos ={
    paciente: paciente,
    comite: comite,
    peso: peso,
    talla: talla,
    sup: sup,
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
    completereg: completereg,
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
    fichapacex1: fichapacex1,
    fechahospex1: fechahospex1,
    horahospex1: horahospex1,
    fuente2: fuente2,
    fichapacex2: fichapacex2,
    fechahospex2: fechahospex2,
    horahospex2: horahospex2,
    fuente3: fuente3,
    fichapacex3: fichapacex3,
    fechahospex3: fechahospex3,
    horahospex3: horahospex3,
    fechaultimocontacto: fechaultimocontacto,
    estadio: estadio,
    defuncion: defuncion,
    causa: causa,
    observacionfinal: observacionfinal
  }

  //Registrar el borrador
  try {
    $.ajax({
      url: "php/insert/borrador_informe.php",
      type: "POST",
      data: datos,
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
  } catch (error) {
    ToastifyError(error);
  }

}

$(document).ready(function () {
  var paciente = $("#pacienteborrador").val();
  var comite = $("#comiteborrador").val();
  cargarborrador(paciente, comite);
});

function cargarborrador(paciente, comite) {
  $.ajax({
    url: "php/charge/borrador_informe.php",
    type: "POST",
    data: { comite: comite, paciente: paciente }, 
    success: function (respuesta) {
      try {
        var data = JSON.parse(respuesta);
        if (data.status == true) {
          var informe = data.informe;
          $("#peso").val(informe.peso);
          $("#talla").val(informe.talla);
          $("#sup").val(informe.sup);
          $("#iddiag").val(informe.diagnostico);
          $("#diagnostico").val(informe.diagnosticotext);
          $("#idcie10").val(informe.diagnosticocie10);
          $("#diagnosticocie10").val(informe.diagnosticocie10text);
          $("#fechabiopsia").val(informe.fechabiopsia);
          if (informe.reingreso == 1) {
            $("#reingreso").prop("checked", true);
          }
          $("#ecog").val(informe.ecog);
          $("#histologico").val(informe.histologico);
          $("#invasiontumoral").val(informe.invasiontumoral);
          $("#mitotico").val(informe.mitotico);
          $("#observaciontnm").val(informe.observaciontnm);
          $("#anamnesis").val(informe.anamnesis);
          if (informe.cirugia == 1) {
            $("#cirugia").prop("checked", true);
          }
          if (informe.quimioterapia == 2){
            $("#quimioterapia").prop("checked", true);
          }

          if (informe.radioterapia == 3){
            $("#radioterapia").prop("checked", true);
          }
        }else{
          console.log(data.message);
        }
      } catch (error) {
        console.log(error);
      }
    }
  });
}


function cargartnm() {
  console.log(tnm);
  var html = "";
  for (var i = 0; i < tnm.length; i++) {
    html += "<tr>";
    html += "<td>" + tnm[i].t1 + "</td>";
    html += "<td>" + tnm[i].ttext + "</td>";
    html += "<td>" + tnm[i].ntext + "</td>";
    html += "<td>" + tnm[i].mtext + "</td>";
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
    url: "php/charge/tnmcomite.php",
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
              tnm[i].t,
              tnm[i].ttexto,
              tnm[i].n,
              tnm[i].ntexto,
              tnm[i].m,
              tnm[i].mtexto
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
