
function cargarsignos() {
    var paciente = $("#pacienteid").val();
    $.ajax({
        url: "php/charge/signosvitales.php",
        type: "POST",
        data: { id: paciente },
        success: function (respuesta) {
            $("#signos").html(respuesta);
        }
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
        }
    });
}
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
}

function vistapreviaatencion() {
    let modalidad = $("#modalidad").val();
    if (modalidad <= 0) {
        ToastifyError("Seleccione una modalidad");
        return;
    }
    let diagnosticoid = $("#iddiag").val();
    if (diagnosticoid <= 0) {
        ToastifyError("Seleccione un diagnostico");
        return;
    }
    var diagnosticotext = $("#diagnostico").val();
    let cieo10 = $("#idcie10").val();
    if (cieo10 <= 0) {
        ToastifyError("Seleccione un diagnostico CIE10");
        return;
    }
    var cieo10text = $("#diagnosticocie10").val();
    var tipoatencion = $("#tipoatencion").val();
    if (tipoatencion.trim().length == 0) {
        ToastifyError("Seleccione un tipo de atencion");
        return;
    }
    let ecog = $("#ecog").val();
    if (ecog < 0) {
        ToastifyError("Seleccione un ECOG");
        return;
    }
    //Capturar el texto del select
    var ecogtext = $("#ecog option:selected").text();
    var ingreso = 0;
    if ($("#ingreso").is(':checked')) {
        ingreso = 1;
    }
    var receta = 0;
    if ($("#receta").is(':checked')) {
        receta = 1;
    }
    var reingreso = 0;
    if ($("#reingreso").is(':checked')) {
        reingreso = 1;
    }
    var anamnesis = $("#anamnesis").val();
    if (anamnesis.trim().length == 0) {
        ToastifyError("Ingrese la anamnesis");
        return;
    }
    var estudiocomplementarios = $("#estudiocomplementarios").val();
    if (estudiocomplementarios.trim().length == 0) {
        ToastifyError("Ingrese los estudios complementarios");
        return;
    }

    //Decision tomada 
    var cirugia = 0;
    //Validar si se selecciono cirugia
    if ($("#cirugia").is(':checked')) {
        cirugia = $("#cirugia").val();
    }
    var quimioterapia = 0;
    //Validar si se selecciono quimioterapia
    if ($("#quimioterapia").is(':checked')) {
        quimioterapia = $("#quimioterapia").val();
    }
    var radioterapia = 0;
    //Validar si se selecciono radioterapia
    if ($("#radioterapia").is(':checked')) {
        radioterapia = $("#radioterapia").val();
    }
    var otros = 0;
    //Validar si se selecciono otros
    if ($("#otros").is(':checked')) {
        otros = $("#otros").val();
    }
    var seguimiento = 0;
    //Validar si se selecciono seguimiento
    if ($("#seguimiento").is(':checked')) {
        seguimiento = $("#seguimiento").val();
    }
    var completar = 0;
    //Validar si se selecciono completar
    if ($("#completar").is(':checked')) {
        completar = $("#completar").val();
    }
    var revaluacion = 0;
    //Validar si se selecciono revaluacion
    if ($("#revaluacion").is(':checked')) {
        revaluacion = $("#revaluacion").val();
    }
    var estudioclinicno = 0;
    //Validar si se selecciono estudioclinicno
    if ($("#estudioclinico").is(':checked')) {
        estudioclinicno = $("#estudioclinico").val();
    }
    //Validar si ha seleccionado alguna decision    
    if (cirugia == 0 && quimioterapia == 0 && radioterapia == 0 && otros == 0 && seguimiento == 0 && completar == 0 && revaluacion == 0 && estudioclinicno == 0) {
        ToastifyError("Debe seleccionar alguna decision");
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
    if ($("#programacion").is(':checked')) {
        programacion = $("#programacion").val();
    }
    var traslado = 0;
    //Validar si se selecciono traslado
    if ($("#traslado").is(':checked')) {
        traslado = $("#traslado").val();
    }
    var paliativos = 0;
    //Validar si se selecciono paliativos
    if ($("#paliativos").is(':checked')) {
        paliativos = $("#paliativos").val();
    }
    var ingresohospitalario = 0;
    //Validar si se selecciono ingreso
    if ($("#ingresohospitalario").is(':checked')) {
        ingresohospitalario = $("#ingresohospitalario").val();
    }
    //Validar si ha seleccionado algun plan asistencial
    if (programacion == 0 && traslado == 0 && paliativos == 0 && ingresohospitalario == 0) {
        ToastifyError("Debe seleccionar algun plan asistencial");
        return;
    }
    var observacionplan = $("#observacionplan").val();
    //SI el observacionplan esta vacia, preguntar si esta seguro de dejarlo vacia
    if (observacionplan.trim().length == 0) {
        ToastifyError("Debe ingresar una observacion en el plan asistencial");
        return;
    }

    var atpacienteid = $("#atpacienteid").val();
    var atempresaid = $("#atempresaid").val();
    var atprofesionalid = $("#atprofesionalid").val();
    var atreservaid = $("#atreservaid").val();
    var atfolio = $("#atfolio").val();


    //Cargar los datos en la vista previa
    $("#frameprevia").attr("src", "php/reporte/previa/atencion.php?diagnosticoid=" + diagnosticoid + "&diagnosticotext=" + diagnosticotext + "&cieo10=" + cieo10 + "&cieo10text=" + cieo10text + "&tipoatencion=" + tipoatencion + "&ecog=" + ecog + "&ecogtext=" + ecogtext + "&ingreso=" + ingreso + "&receta=" + receta + "&reingreso=" + reingreso + "&anamnesis=" + anamnesis + "&estudiocomplementarios=" + estudiocomplementarios + "&cirugia=" + cirugia + "&quimioterapia=" + quimioterapia + "&radioterapia=" + radioterapia + "&otros=" + otros + "&seguimiento=" + seguimiento + "&completar=" + completar + "&revaluacion=" + revaluacion + "&estudioclinicno=" + estudioclinicno + "&observacionesdecision=" + observacionesdecision + "&consultade=" + consultade + "&consultadetext=" + consultadetext + "&programacion=" + programacion + "&traslado=" + traslado + "&paliativos=" + paliativos + "&ingresohospitalario=" + ingresohospitalario + "&observacionplan=" + observacionplan + "&atpacienteid=" + atpacienteid + "&atempresaid=" + atempresaid + "&atprofesionalid=" + atprofesionalid + "&atreservaid=" + atreservaid + "&folio=" + atfolio);
    $("#modalprevia").modal("show");
}

function registraratencion() {
    let modalidad = $("#modalidad").val();
    if (modalidad <= 0) {
        ToastifyError("Seleccione una modalidad");
        return;
    }
    let diagnosticoid = $("#iddiag").val();
    if (diagnosticoid <= 0) {
        ToastifyError("Seleccione un diagnostico");
        return;
    }
    var diagnosticotext = $("#diagnostico").val();
    let cieo10 = $("#idcie10").val();
    if (cieo10 <= 0) {
        ToastifyError("Seleccione un diagnostico CIE10");
        return;
    }
    var cieo10text = $("#diagnosticocie10").val();
    var tipoatencion = $("#tipoatencion").val();
    if (tipoatencion.trim().length == 0) {
        ToastifyError("Seleccione un tipo de atencion");
        return;
    }
    let ecog = $("#ecog").val();
    if (ecog < 0) {
        ToastifyError("Seleccione un ECOG");
        return;
    }
    //Capturar el texto del select
    var ecogtext = $("#ecog option:selected").text();
    var ingreso = 0;
    if ($("#ingreso").is(':checked')) {
        ingreso = 1;
    }
    var receta = 0;
    if ($("#receta").is(':checked')) {
        receta = 1;
    }
    var reingreso = 0;
    if ($("#reingreso").is(':checked')) {
        reingreso = 1;
    }
    var anamnesis = $("#anamnesis").val();
    if (anamnesis.trim().length == 0) {
        ToastifyError("Ingrese la anamnesis");
        return;
    }
    var estudiocomplementarios = $("#estudiocomplementarios").val();
    if (estudiocomplementarios.trim().length == 0) {
        ToastifyError("Ingrese los estudios complementarios");
        return;
    }

    //Decision tomada 
    var cirugia = 0;
    //Validar si se selecciono cirugia
    if ($("#cirugia").is(':checked')) {
        cirugia = $("#cirugia").val();
    }
    var quimioterapia = 0;
    //Validar si se selecciono quimioterapia
    if ($("#quimioterapia").is(':checked')) {
        quimioterapia = $("#quimioterapia").val();
    }
    var radioterapia = 0;
    //Validar si se selecciono radioterapia
    if ($("#radioterapia").is(':checked')) {
        radioterapia = $("#radioterapia").val();
    }
    var otros = 0;
    //Validar si se selecciono otros
    if ($("#otros").is(':checked')) {
        otros = $("#otros").val();
    }
    var seguimiento = 0;
    //Validar si se selecciono seguimiento
    if ($("#seguimiento").is(':checked')) {
        seguimiento = $("#seguimiento").val();
    }
    var completar = 0;
    //Validar si se selecciono completar
    if ($("#completar").is(':checked')) {
        completar = $("#completar").val();
    }
    var revaluacion = 0;
    //Validar si se selecciono revaluacion
    if ($("#revaluacion").is(':checked')) {
        revaluacion = $("#revaluacion").val();
    }
    var estudioclinicno = 0;
    //Validar si se selecciono estudioclinicno
    if ($("#estudioclinico").is(':checked')) {
        estudioclinicno = $("#estudioclinico").val();
    }

    //Validar si ha seleccionado alguna decision    
    if (cirugia == 0 && quimioterapia == 0 && radioterapia == 0 && otros == 0 && seguimiento == 0 && completar == 0 && revaluacion == 0 && estudioclinicno == 0) {
        ToastifyError("Debe seleccionar alguna decision");
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
    if ($("#programacion").is(':checked')) {
        programacion = $("#programacion").val();
    }
    var traslado = 0;
    //Validar si se selecciono traslado
    if ($("#traslado").is(':checked')) {
        traslado = $("#traslado").val();
    }
    var paliativos = 0;
    //Validar si se selecciono paliativos
    if ($("#paliativos").is(':checked')) {
        paliativos = $("#paliativos").val();
    }
    var ingresohospitalario = 0;
    //Validar si se selecciono ingreso
    if ($("#ingresohospitalario").is(':checked')) {
        ingresohospitalario = $("#ingresohospitalario").val();
    }

    //Validar si ha seleccionado algun plan asistencial
    if (programacion == 0 && traslado == 0 && paliativos == 0 && ingresohospitalario == 0) {
        ToastifyError("Debe seleccionar algun plan asistencial");
        return;
    }

    var observacionplan = $("#observacionplan").val();
    //SI el observacionplan esta vacia, preguntar si esta seguro de dejarlo vacia
    if (observacionplan.trim().length == 0) {
        ToastifyError("Debe ingresar una observacion en el plan asistencial");
        return;
    }

    var atpacienteid = $("#atpacienteid").val();
    var atempresaid = $("#atempresaid").val();
    var atprofesionalid = $("#atprofesionalid").val();
    var atreservaid = $("#atreservaid").val();
    var previo = $("#previo").val();
    var atfolio = $("#atfolio").val();

    $.ajax({
        url: "php/insert/atencion.php",
        type: "POST",
        data: { modalidad:modalidad, diagnosticoid: diagnosticoid, diagnosticotext: diagnosticotext, cieo10: cieo10, cieo10text: cieo10text, tipoatencion: tipoatencion, ecog: ecog, ecogtext: ecogtext, ingreso: ingreso, receta: receta, reingreso: reingreso, anamnesis: anamnesis, estudiocomplementarios: estudiocomplementarios, cirugia: cirugia, quimioterapia: quimioterapia, radioterapia: radioterapia, otros: otros, seguimiento: seguimiento, completar: completar, revaluacion: revaluacion, estudioclinicno: estudioclinicno, observacionesdecision: observacionesdecision, consultade: consultade, consultadetext: consultadetext, programacion: programacion, traslado: traslado, paliativos: paliativos, ingresohospitalario: ingresohospitalario, observacionplan: observacionplan, atpacienteid: atpacienteid, atempresaid: atempresaid, atprofesionalid: atprofesionalid, atreservaid: atreservaid, folio: atfolio },
        success: function (respuesta) {
            try {
                var json = JSON.parse(respuesta);
                if (json.status == true) {
                    ToastifySuccess(json.message);
                    setTimeout(function () {
                        //Redireccionar a la pagina anterior
                        window.location.href = previo;
                    }, 500);
                } else {
                    ToastifyError(json.message);
                }
            } catch (error) {
                ToastifyError(error);
            }
        }
    });
}