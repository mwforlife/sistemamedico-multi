/********************************************************************************************************************************* */
//Informe Paciente
//agregarDiagnosticoCIEO Topografico
function agregarDiagnosticoCIEOtopograficos(id, nombre) {
    $("#diagnosticocieotop").val(nombre);
    $("#idcieotop").val(id);
    $("#modaldiagcieotop").modal("hide");
}

//agregarDiagnosticoCIEO Morfologicos
function agregarDiagnosticoCIEOmorfologicos(id, nombre) {
    $("#diagnosticocieomor").val(nombre);
    $("#idcieomor").val(id);
    $("#modaldiagcieomor").modal("hide");
}


//agregarDiagnosticoCIE10
function agregarDiagnosticoCIE10(id, nombre) {  
    $("#diagnosticocie10").val(nombre);
    $("#idcie10").val(id);
    $("#modaldiagcie10").modal("hide");
}

function agregarDiagnosticos(id, nombre){
    $("#diagnostico").val(nombre);
    $("#iddiag").val(id);
    $("#modaldiagnosticos").modal("hide");
    cargartnm(id);
}

function cargartnm(id){
    tnmprimario(id);
    tnmregionales(id);
    tnmdistantes(id);
}

//TNM Primario
function tnmprimario(id){
    $.ajax({
        type: "POST",
        url: "php/charge/tnmsearch.php",
        data: {tipo:1, diagnostico:id},
        success: function (response) {
            $("#primarioclinico").html(response);
        }
    });
}

//TNM Regionales
function tnmregionales(id){
    $.ajax({
        type: "POST",
        url: "php/charge/tnmsearch.php",
        data: {tipo:2, diagnostico:id},
        success: function (response) {
            $("#regionalesclinico").html(response);
        }
    });
}

//TNM Distantes
function tnmdistantes(id){
    $.ajax({
        type: "POST",
        url: "php/charge/tnmsearch.php",
        data: {tipo:3, diagnostico:id},
        success: function (response) {
            $("#distanciaclinico").html(response);
        }
    });
}


/*************************************************************************************************************************************************************************** */
function guardarinforme(paciente, comite){
    //Diagnostico
    var diagnostico = $("#iddiag").val();
    var diagnosticotext = $("#diagnostico").val();
    var diagnosticocieomor = $("#idcieomor").val();
    var diagnosticocieomortext = $("#diagnosticocieomor").val();
    var diagnosticocieotop = $("#idcieotop").val();
    var diagnosticocieotoptext = $("#diagnosticocieotop").val();
    var diagnosticocie10 = $("#idcie10").val();
    var diagnosticocie10text = $("#diagnosticocie10").val();

    //Fecha biopsia
    var fechabiopsia = $("#fechabiopsia").val();
    //Reingreso
    var reingreso = 0;
    if($("#reingreso").is(':checked')){
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
    var primarioclinico = $("#primarioclinico").val();
    var primarioclinicotext = $("#primarioclinico option:selected").text();
    var observacionprimario = $("#observacionprimario").val();
    var regionalesclinico = $("#regionalesclinico").val();
    var regionalesclinicotext = $("#regionalesclinico option:selected").text();
    var observacionregional = $("#observacionregional").val();
    var distanciaclinico = $("#distanciaclinico").val();
    var distanciaclinicotext = $("#distanciaclinico option:selected").text();
    var observaciondistancia = $("#observaciondistancia").val();

    //anamnesis
    var anamnesis = $("#anamnesis").val();

    //Decision tomada 
    var cirugia =0;
    //Validar si se selecciono cirugia
    if($("#cirugia").is(':checked')){
        cirugia = $("#cirugia").val();
    }
    var quimioterapia =0;
    //Validar si se selecciono quimioterapia
    if($("#quimioterapia").is(':checked')){
        quimioterapia = $("#quimioterapia").val();
    }
    var radioterapia =0;
    //Validar si se selecciono radioterapia
    if($("#radioterapia").is(':checked')){
        radioterapia = $("#radioterapia").val();
    }
    var otros =0;
    //Validar si se selecciono otros
    if($("#otros").is(':checked')){
        otros = $("#otros").val();
    }
    var seguimiento =0;
    //Validar si se selecciono seguimiento
    if($("#seguimiento").is(':checked')){
        seguimiento = $("#seguimiento").val();
    }
    var completar =0;
    //Validar si se selecciono completar
    if($("#completar").is(':checked')){
        completar = $("#completar").val();
    }
    var revaluacion =0;
    //Validar si se selecciono revaluacion
    if($("#revaluacion").is(':checked')){
        revaluacion = $("#revaluacion").val();
    }
    var estudioclinicno =0;
    //Validar si se selecciono estudioclinicno
    if($("#estudioclinico").is(':checked')){
        estudioclinicno = $("#estudioclinico").val();
    }

    var observacionesdecision = $("#observacionesdecision").val();
    //Plan Asistencial
    var consultade = $("#consultade").val();
    var consultadetext = $("#consultade option:selected").text();
    //Validar el consultade
    if(consultade<=0){
        ToastifyError("Debe ingresar seleccionar el consultade");
        return;
    }

    var programacion =0;
    //Validar si se selecciono programacion
    if($("#programacion").is(':checked')){
        programacion = $("#programacion").val();
    }
    var traslado =0;
    //Validar si se selecciono traslado
    if($("#traslado").is(':checked')){
        traslado = $("#traslado").val();
    }
    var paliativos =0;
    //Validar si se selecciono paliativos
    if($("#paliativos").is(':checked')){
        paliativos = $("#paliativos").val();
    }
    var ingreso =0;
    //Validar si se selecciono ingreso
    if($("#ingreso").is(':checked')){
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
        diagnosticocieomor: diagnosticocieomor,
        diagnosticocieomortext: diagnosticocieomortext,
        diagnosticocieotop: diagnosticocieotop,
        diagnosticocieotoptext: diagnosticocieotoptext,
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
        primarioclinico: primarioclinico,
        primarioclinicotext: primarioclinicotext,
        observacionprimario: observacionprimario,
        regionalesclinico: regionalesclinico,
        regionalesclinicotext: regionalesclinicotext,
        observacionregional: observacionregional,
        distanciaclinico: distanciaclinico,
        distanciaclinicotext: distanciaclinicotext,
        observaciondistancia: observaciondistancia,
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
        resolucion: resolucion
    };
    //Registrar el informe
    $.ajax({
        url: "php/insert/informe.php",
        type: "POST",
        data: informe,
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta==1){
                ToastifySuccess("Se registro el informe correctamente");
                setTimeout(function(){
                    //Volver a la pagina anterior visitada
                    window.history.back();
                },1500);
            }else{
               ToastifyError(respuesta);
            }
        }
    });
}

$(document).ready(function(){
//Evento al cambiar el el estado de checkbox de citacion
$("#citacion").on("change",function(){
    if($("#citacion").is(':checked')){
        $(".consulta").show();
        $("#consultade").attr("required",true);
    }else{
        $(".consulta").hide();
        $("#consultade").attr("required",false);
    }
});

$("#formsignos").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "php/insert/signos.php",
        type: "POST",
        data: $("#formsignos").serialize(),
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta==1){
                ToastifySuccess("Se registro los signos vitales correctamente");
                cargarsignos();
            }else{
               ToastifyError(respuesta);
            }
        
        }
    });   
});
$("#formmedidas").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "php/insert/medidas.php",
        type: "POST",
        data: $("#formmedidas").serialize(),
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta==1){
                ToastifySuccess("Se registro las medidas correctamente");
                cargarmedidas();
            }else{
               ToastifyError(respuesta);
            }
        
        }
    });   
});
});

function cargarsignos(){
    var paciente = $("#pacienteid").val();
    $.ajax({
        url: "php/charge/signosvitales.php",
        type: "POST",
        data: {id:paciente},
        success: function(respuesta){
            $("#signos").html(respuesta);
        }
    });
}

function cargarmedidas(){
    var paciente = $("#pacienteid").val();
    $.ajax({
        url: "php/charge/medidas.php",
        type: "POST",
        data: {id:paciente},
        success: function(respuesta){
            $("#medidas").html(respuesta);
        }
    });
}
