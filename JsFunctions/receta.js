var carbovalid = false;
function cargarMedicamentoesquema() {
    var id = $("#esquema").val();
    $.ajax({
        type: "POST",
        url: "php/charge/cargaresquemamed.php",
        data: { id: id },
        success: function (data) {
            try {
                var medicamento = JSON.parse(data);
                if (medicamento.status == true) {
                    $("#medi").html(medicamento.contenido);
                    if (medicamento.carbo == true) {
                        carbovalid = true;
                        $(".carbo").removeClass("d-none");
                        $(".carbo input").attr("required", true);
                    } else {
                        carbovalid = false;
                        $(".carbo").addClass("d-none");
                        $(".carbo input").attr("required", false);
                    }
                } else {
                    carbovalid = false;
                    $("#medi").html("<div class='alert alert-danger'>UPS! Hubo un error al cargar los medicamentos</div>");
                    $("#carbo").addClass("d-none");
                    $("#carbo input").attr("required", false);
                }
            } catch (error) {
                carbovalid = false;
                $("#medi").html("<div class='alert alert-danger'>UPS! Hubo un error al cargar los medicamentos</div>");
                $("#carbo").addClass("d-none");
                $("#carbo input").attr("required", false);
            }
        }
    });
}

function cargarMedicamentoesquema1(receta) {
    var id = $("#esquema").val();
    var scorporal = $("#scorporal").val();

    $.ajax({
        type: "POST",
        url: "php/charge/cargaresquemamed1.php",
        data: { id: id, receta: receta },
        success: function (data) {
            try {
                var medicamento = JSON.parse(data);
                if (medicamento.status == true) {
                    $("#medi").html(medicamento.contenido);
                    if (medicamento.carbo == true) {
                        carbovalid = true;
                        $(".carbo").removeClass("d-none");
                        $(".carbo input").attr("required", true);
                    } else {
                        carbovalid = false;
                        $(".carbo").addClass("d-none");
                        $(".carbo input").attr("required", false);
                    }
                } else {
                    carbovalid = false;
                    $("#medi").html("<div class='alert alert-danger'>UPS! Hubo un error al cargar los medicamentos</div>");
                    $("#carbo").addClass("d-none");
                    $("#carbo input").attr("required", false);
                }
            } catch (error) {
                carbovalid = false;
                $("#medi").html("<div class='alert alert-danger'>UPS! Hubo un error al cargar los medicamentos</div>");
                $("#carbo").addClass("d-none");
                $("#carbo input").attr("required", false);
            }
        }
    });
}
function calcularBSA() {
    var peso = $("#peso").val();
    var talla = $("#talla").val();
    var bsa = calculateBSA(talla, peso);
    $("#scorporal").val(bsa);
}
//Javascript Function
function calculateBSA(Height, Weight) {
    var BSA = 0.007184 * Math.pow(Height, 0.725) * Math.pow(Weight, 0.425);
    return BSA.toFixed(2);
}
function vistaprevia(paciente, medico, empresa, consulta, receta, folio) {
    var estadio = $("#estadio").val();
    var nivel = $("#nivel").val();
    var ges = $("#ges").val();
    var peso = $("#peso").val();
    var talla = $("#talla").val();
    var scorporal = $("#scorporal").val();
    var creatinina = $("#creatinina").val();
    var auc = $("#auc").val();
    var fechaadmin = $("#fechaadmin").val();
    var examen = $("#examen").val();
    var ciclo = $("#ciclo").val();
    var anticipada = $("#anticipada").val();
    var curativo = 0;
    if ($("#curativo").is(':checked')) {
        curativo = 1;
    }
    var paliativo = 0;
    if ($("#paliativo").is(':checked')) {
        paliativo = 1;
    }
    var adyuvante = 0;
    if ($("#adyuvante").is(':checked')) {
        adyuvante = 1;
    }
    var concomitante = 0;
    if ($("#concomitante").is(':checked')) {
        concomitante = 1;
    }
    var neoadyuvante = 0;
    if ($("#neoadyuvante").is(':checked')) {
        neoadyuvante = 1;
    }
    var primera = 0;
    if ($("#primera").is(':checked')) {
        primera = 1;
    }
    var traemedicamentos = 0;
    if ($("#traemedicamentos").is(':checked')) {
        traemedicamentos = 1;
    }
    var diabetes = 0;
    if ($("#diabetes").is(':checked')) {
        diabetes = 1;
    }
    var hipertension = 0;
    if ($("#hipertension").is(':checked')) {
        hipertension = 1;
    }
    var alergia = 0;
    if ($("#alergia").is(':checked')) {
        alergia = 1;
    }

    var alergiadetalle = $("#alergiadetalle").val();
    var urgente = $("#urgente").val();
    //Validar datos
    if (estadio == 0) {
        ToastifyError("Seleccione un estadio");
        $("#estadio").focus();
        return false;
    }

    if (nivel == 0) {
        ToastifyError("Seleccione un nivel");
        $("#nivel").focus();
        return false;
    }

    if (ges == 0) {
        ToastifyError("Seleccione un GES");
        $("#ges").focus();
        return false;
    }

    if (peso.trim().length == 0) {
        ToastifyError("El peso no puede estar vacio");
        $("#peso").focus();
        return false;
    }

    if (talla.trim().length == 0) {
        ToastifyError("La talla no puede estar vacia");
        $("#talla").focus();
        return false;
    }

    if (scorporal.trim().length == 0) {
        ToastifyError("El S. Corporal no puede estar vacio");
        $("#scorporal").focus();
        return false;
    }

    if (fechaadmin.trim().length == 0) {
        ToastifyError("La fecha de administracion no puede estar vacia");
        $("#fechaadmin").focus();
        return false;
    }

    if (examen.trim().length == 0) {
        ToastifyError("El examen no puede estar vacio");
        $("#examen").focus();
        return false;
    }

    if (ciclo.trim().length == 0) {
        ToastifyError("El ciclo no puede estar vacio");
        $("#ciclo").focus();
        return false;
    }

    if (anticipada.trim().length == 0) {
        ToastifyError("La anticipada no puede estar vacia");
        $("#anticipada").focus();
        return false;
    }

    if (urgente.trim().length == 0) {
        ToastifyError("Debe seleccionar si es urgente o no");
        $("#urgente").focus();
        return false;
    }

    //Validar alergia
    if (alergia == 1) {
        if (alergiadetalle.trim().length == 0) {
            ToastifyError("Debe ingresar el detalle de la alergia");
            $("#alergiadetalle").focus();
            return false;
        }
    }




    var creatinina = 0;
    var auc = 0;

    //Comprobar si el creatinina y el auc esta con la propiedad required
    if ($("#creatinina").prop("required")) {
        creatinina = $("#creatinina").val();
        if (creatinina <= 0) {
            ToastifyError("La creatinina no puede ser menor o igual a 0");
            $("#creatinina").focus();
            return false;
        }
    }

    if ($("#auc").prop("required")) {
        auc = $("#auc").val();
        if (auc <= 0) {
            ToastifyError("El AUC no puede ser menor o igual a 0");
            $("#auc").focus();
            return false;
        }
    }

    var esquema = $("#esquema").val();

    if (esquema == 0) {
        ToastifyError("Seleccione un esquema");
        $("#esquema").focus();
        return false;
    }
    var otrcormo = "";
    var otrocor = 0;
    if ($("#otrocor").is(':checked')) {
        otrocor = 1;
        otrcormo = $("#otrcormo").val();
        if (otrcormo.trim().length == 0) {
            ToastifyError("Debe ingresar la otra comorbilidad");
            $("#otrcormo").focus();
            return false;
        }
    }

    //Captura de medicamentos seleccionados
    const medicamentoscheck = [];

    try {
        $("#medicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var medicamentoname = $(this).find("span[name^='medicamentoname']").text();
            const porcentajeSelect = $(this).find("select");
            var carboplatinoval = $(this).find("input[name^='carboplatino']").val();
            const medidaInput = $(this).find("input[name^='medida']");
            const totalMgInput = $(this).find("input[name^='totalmg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const itCheckbox = $(this).find("input[name^='it']");
            const biccadCheckbox = $(this).find("input[name^='biccad']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var porcentaje = porcentajeSelect.val();
                var medida = medidaInput.val();
                //Validar que la medida no sea menor o igual a 0
                if (medida <= 0) {
                    ToastifyError("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var totalMg = totalMgInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (totalMg <= 0) {
                    ToastifyError("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }
                var it = 0;
                if (itCheckbox.prop("checked")) {
                    it = 1;
                }
                var biccad = 0;
                if (biccadCheckbox.prop("checked")) {
                    biccad = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0 && it == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    throw new Error("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    return;
                }

                var observacion = observacionInput.val();
                const data = {
                    medicamento: checkbox.val(),
                    porcentaje: porcentaje,
                    carboplatinoval: carboplatinoval,
                    medida: medida,
                    totalMg: totalMg,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    it: it,
                    biccad: biccad,
                    observacion: observacion
                };
                medicamentoscheck.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar los medicamentos seleccionados");
        return;
    }


    //Captura de Premedicacion
    const premedicaciones = [];
    try {
        $("#premedicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var premedicacionname = $(this).find("span[name^='premedicacionname']").text();
            const dosisInput = $(this).find("input[name^='dosismg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var dosis = dosisInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (dosis <= 0) {
                    ToastifyError("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    throw new Error("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    throw new Error("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    return;
                }

                var observacion = observacionInput.val();

                const data = {
                    premedicacion: checkbox.val(),
                    dosis: dosis,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    observacion: observacion
                };
                premedicaciones.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar las premedicaciones seleccionadas");
        return;
    }

    //Estimulador
    var estimulador = 0;
    var cantidades = 0;
    var rango = 0;
    if ($("#estimulador").is(':checked')) {
        estimulador = 1;
        cantidades = $("#cantidades").val();
        rango = $("#rango").val();
    }

    //Observaciones
    var anamnesis = $("#anamnesis").val();
    var observaciones = $("#observacion").val();

    //Validar medicamentos
    if (medicamentoscheck.length == 0) {
        ToastifyError("Debe seleccionar al menos un medicamento");
        return;
    }

    //Validar premedicaciones
    if (premedicaciones.length == 0) {
        ToastifyError("Debe seleccionar al menos una premedicacion");
        return;
    }

    //Validar estimulador
    if (estimulador == 1) {
        if (cantidades.trim().length == 0) {
            ToastifyError("La cantidad no puede estar vacia");
            $("#cantidades").focus();
            return;
        }

        if (rango.trim().length == 0) {
            ToastifyError("El rango no puede estar vacio");
            $("#rango").focus();
            return;
        }
    }

    if (observaciones.trim().length == 0) {
        ToastifyError("Las observaciones no pueden estar vacias");
        $("#observacion").focus();
        return;
    }

    $("#frameprevia").attr("src", "php/reporte/previa/receta.php?paciente=" + paciente + "&medico=" + medico + "&empresa=" + empresa + "&consulta=" + consulta + "&estadio=" + estadio + "&nivel=" + nivel + "&ges=" + ges + "&peso=" + peso + "&talla=" + talla + "&scorporal=" + scorporal + "&creatinina=" + creatinina + "&auc=" + auc + "&fechaadmin=" + fechaadmin + "&examen=" + examen + "&ciclo=" + ciclo + "&anticipada=" + anticipada + "&curativo=" + curativo + "&paliativo=" + paliativo + "&adyuvante=" + adyuvante + "&concomitante=" + concomitante + "&neoadyuvante=" + neoadyuvante + "&primera=" + primera + "&traemedicamentos=" + traemedicamentos + "&diabetes=" + diabetes + "&hipertension=" + hipertension + "&alergia=" + alergia + "&alergiadetalle=" + alergiadetalle + "&otrocor=" + otrocor + "&otrcormo=" + otrcormo + "&urgente=" + urgente + "&esquema=" + esquema + "&medicamentoscheck=" + JSON.stringify(medicamentoscheck) + "&premedicaciones=" + JSON.stringify(premedicaciones) + "&estimulador=" + estimulador + "&cantidades=" + cantidades + "&rango=" + rango + "&observaciones=" + observaciones + "&receta=" + receta + "&folio=" + folio + "&carbovalid=" + carbovalid);
    $("#modalprevia").modal("show");
}

function generarreceta(paciente, medico, empresa, consulta) {
    var previo = $("#previo").val();
    var estadio = $("#estadio").val();
    var nivel = $("#nivel").val();
    var ges = $("#ges").val();
    var peso = $("#peso").val();
    var talla = $("#talla").val();
    var scorporal = $("#scorporal").val();
    var creatinina = $("#creatinina").val();
    var auc = $("#auc").val();
    var fechaadmin = $("#fechaadmin").val();
    var examen = $("#examen").val();
    var ciclo = $("#ciclo").val();
    var anticipada = $("#anticipada").val();
    var curativo = 0;
    if ($("#curativo").is(':checked')) {
        curativo = 1;
    }
    var paliativo = 0;
    if ($("#paliativo").is(':checked')) {
        paliativo = 1;
    }
    var adyuvante = 0;
    if ($("#adyuvante").is(':checked')) {
        adyuvante = 1;
    }
    var concomitante = 0;
    if ($("#concomitante").is(':checked')) {
        concomitante = 1;
    }
    var neoadyuvante = 0;
    if ($("#neoadyuvante").is(':checked')) {
        neoadyuvante = 1;
    }
    var primera = 0;
    if ($("#primera").is(':checked')) {
        primera = 1;
    }
    var traemedicamentos = 0;
    if ($("#traemedicamentos").is(':checked')) {
        traemedicamentos = 1;
    }
    var diabetes = 0;
    if ($("#diabetes").is(':checked')) {
        diabetes = 1;
    }
    var hipertension = 0;
    if ($("#hipertension").is(':checked')) {
        hipertension = 1;
    }
    var alergia = 0;
    if ($("#alergia").is(':checked')) {
        alergia = 1;
    }

    var alergiadetalle = $("#alergiadetalle").val();
    var urgente = $("#urgente").val();
    //Validar datos
    if (estadio == 0) {
        ToastifyError("Seleccione un estadio");
        $("#estadio").focus();
        return false;
    }

    if (nivel == 0) {
        ToastifyError("Seleccione un nivel");
        $("#nivel").focus();
        return false;
    }

    if (ges == 0) {
        ToastifyError("Seleccione un GES");
        $("#ges").focus();
        return false;
    }

    if (peso.trim().length == 0) {
        ToastifyError("El peso no puede estar vacio");
        $("#peso").focus();
        return false;
    }

    if (talla.trim().length == 0) {
        ToastifyError("La talla no puede estar vacia");
        $("#talla").focus();
        return false;
    }

    if (scorporal.trim().length == 0) {
        ToastifyError("El S. Corporal no puede estar vacio");
        $("#scorporal").focus();
        return false;
    }

    if (fechaadmin.trim().length == 0) {
        ToastifyError("La fecha de administracion no puede estar vacia");
        $("#fechaadmin").focus();
        return false;
    }

    if (examen.trim().length == 0) {
        ToastifyError("El examen no puede estar vacio");
        $("#examen").focus();
        return false;
    }

    if (ciclo.trim().length == 0) {
        ToastifyError("El ciclo no puede estar vacio");
        $("#ciclo").focus();
        return false;
    }

    if (anticipada.trim().length == 0) {
        ToastifyError("La anticipada no puede estar vacia");
        $("#anticipada").focus();
        return false;
    }

    if (urgente.trim().length == 0) {
        ToastifyError("Debe seleccionar si es urgente o no");
        $("#urgente").focus();
        return false;
    }

    //Validar alergia
    if (alergia == 1) {
        if (alergiadetalle.trim().length == 0) {
            ToastifyError("Debe ingresar el detalle de la alergia");
            $("#alergiadetalle").focus();
            return false;
        }
    }




    var creatinina = 0;
    var auc = 0;

    //Comprobar si el creatinina y el auc esta con la propiedad required
    if ($("#creatinina").prop("required")) {
        creatinina = $("#creatinina").val();
        if (creatinina <= 0) {
            ToastifyError("La creatinina no puede ser menor o igual a 0");
            $("#creatinina").focus();
            return false;
        }
    }

    if ($("#auc").prop("required")) {
        auc = $("#auc").val();
        if (auc <= 0) {
            ToastifyError("El AUC no puede ser menor o igual a 0");
            $("#auc").focus();
            return false;
        }
    }

    var esquema = $("#esquema").val();

    if (esquema == 0) {
        ToastifyError("Seleccione un esquema");
        $("#esquema").focus();
        return false;
    }
    var otrcormo = "";
    var otrocor = 0;
    if ($("#otrocor").is(':checked')) {
        otrocor = 1;
        otrcormo = $("#otrcormo").val();
        if (otrcormo.trim().length == 0) {
            ToastifyError("Debe ingresar la otra comorbilidad");
            $("#otrcormo").focus();
            return false;
        }
    }

    //Captura de medicamentos seleccionados
    const medicamentoscheck = [];

    try {
        $("#medicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var medicamentoname = $(this).find("span[name^='medicamentoname']").text();
            const porcentajeSelect = $(this).find("select");
            var carboplatinoval = $(this).find("input[name^='carboplatino']").val();
            const medidaInput = $(this).find("input[name^='medida']");
            const totalMgInput = $(this).find("input[name^='totalmg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const itCheckbox = $(this).find("input[name^='it']");
            const biccadCheckbox = $(this).find("input[name^='biccad']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var porcentaje = porcentajeSelect.val();
                var medida = medidaInput.val();
                //Validar que la medida no sea menor o igual a 0
                if (medida <= 0) {
                    ToastifyError("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var totalMg = totalMgInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (totalMg <= 0) {
                    ToastifyError("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }
                var it = 0;
                if (itCheckbox.prop("checked")) {
                    it = 1;
                }
                var biccad = 0;
                if (biccadCheckbox.prop("checked")) {
                    biccad = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0 && it == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    throw new Error("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    return;
                }

                var observacion = observacionInput.val();
                const data = {
                    medicamento: checkbox.val(),
                    porcentaje: porcentaje,
                    carboplatinoval: carboplatinoval,
                    medida: medida,
                    totalMg: totalMg,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    it: it,
                    biccad: biccad,
                    observacion: observacion
                };
                medicamentoscheck.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar los medicamentos seleccionados");
        return;
    }


    //Captura de Premedicacion
    const premedicaciones = [];
    try {
        $("#premedicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var premedicacionname = $(this).find("span[name^='premedicacionname']").text();
            const dosisInput = $(this).find("input[name^='dosismg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var dosis = dosisInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (dosis <= 0) {
                    ToastifyError("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    throw new Error("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    throw new Error("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    return;
                }

                var observacion = observacionInput.val();

                const data = {
                    premedicacion: checkbox.val(),
                    dosis: dosis,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    observacion: observacion
                };
                premedicaciones.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar las premedicaciones seleccionadas");
        return;
    }

    //Estimulador
    var estimulador = 0;
    var cantidades = 0;
    var rango = 0;
    if ($("#estimulador").is(':checked')) {
        estimulador = 1;
        cantidades = $("#cantidades").val();
        rango = $("#rango").val();
    }

    //Observaciones
    var anamnesis = $("#anamnesis").val();
    var observaciones = $("#observacion").val();

    //Validar medicamentos
    if (medicamentoscheck.length == 0) {
        ToastifyError("Debe seleccionar al menos un medicamento");
        return;
    }

    //Validar premedicaciones
    if (premedicaciones.length == 0) {
        ToastifyError("Debe seleccionar al menos una premedicacion");
        return;
    }

    //Validar estimulador
    if (estimulador == 1) {
        if (cantidades.trim().length == 0) {
            ToastifyError("La cantidad no puede estar vacia");
            $("#cantidades").focus();
            return;
        }

        if (rango.trim().length == 0) {
            ToastifyError("El rango no puede estar vacio");
            $("#rango").focus();
            return;
        }
    }

    if (observaciones.trim().length == 0) {
        ToastifyError("Las observaciones no pueden estar vacias");
        $("#observacion").focus();
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/insert/receta.php",
        data: { paciente: paciente, medico: medico, empresa: empresa, consulta: consulta, estadio: estadio, nivel: nivel, ges: ges, peso: peso, talla: talla, scorporal: scorporal, creatinina: creatinina, auc: auc, fechaadmin: fechaadmin, examen: examen, ciclo: ciclo, anticipada: anticipada, curativo: curativo, paliativo: paliativo, adyuvante: adyuvante, concomitante: concomitante, neoadyuvante: neoadyuvante, primera: primera, traemedicamentos: traemedicamentos, diabetes: diabetes, hipertension: hipertension, alergia: alergia, alergiadetalle: alergiadetalle, otrocor: otrocor, otrcormo: otrcormo, urgente: urgente, esquema: esquema, medicamentoscheck: medicamentoscheck, premedicaciones: premedicaciones, estimulador: estimulador, cantidades: cantidades, rango: rango, observaciones: observaciones, carbovalid: carbovalid },
        success: function (respuesta) {
            try {
                var receta = JSON.parse(respuesta);
                //si el elemento error = true, mostrar error
                if (receta.error == true) {
                    ToastifyError(receta.message);
                } else if (receta.error == false) {
                    ToastifySuccess(receta.message);
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        //Volver a la pagina anterior
                        location.href = previo;
                    }, 500);
                }
            } catch (error) {
                ToastifyError(respuesta);

            }
        },
        error: function (error) {
            ToastifyError(error);
        }
    });
}
function editarreceta(paciente, medico, empresa, consulta, receta, folio) {
    var previo = $("#previo").val();
    var estadio = $("#estadio").val();
    var nivel = $("#nivel").val();
    var ges = $("#ges").val();
    var peso = $("#peso").val();
    var talla = $("#talla").val();
    var scorporal = $("#scorporal").val();
    var creatinina = $("#creatinina").val();
    var auc = $("#auc").val();
    var fechaadmin = $("#fechaadmin").val();
    var examen = $("#examen").val();
    var ciclo = $("#ciclo").val();
    var anticipada = $("#anticipada").val();
    var curativo = 0;
    if ($("#curativo").is(':checked')) {
        curativo = 1;
    }
    var paliativo = 0;
    if ($("#paliativo").is(':checked')) {
        paliativo = 1;
    }
    var adyuvante = 0;
    if ($("#adyuvante").is(':checked')) {
        adyuvante = 1;
    }
    var concomitante = 0;
    if ($("#concomitante").is(':checked')) {
        concomitante = 1;
    }
    var neoadyuvante = 0;
    if ($("#neoadyuvante").is(':checked')) {
        neoadyuvante = 1;
    }
    var primera = 0;
    if ($("#primera").is(':checked')) {
        primera = 1;
    }
    var traemedicamentos = 0;
    if ($("#traemedicamentos").is(':checked')) {
        traemedicamentos = 1;
    }
    var diabetes = 0;
    if ($("#diabetes").is(':checked')) {
        diabetes = 1;
    }
    var hipertension = 0;
    if ($("#hipertension").is(':checked')) {
        hipertension = 1;
    }
    var alergia = 0;
    if ($("#alergia").is(':checked')) {
        alergia = 1;
    }

    var alergiadetalle = $("#alergiadetalle").val();
    var urgente = $("#urgente").val();
    //Validar datos
    if (estadio == 0) {
        ToastifyError("Seleccione un estadio");
        $("#estadio").focus();
        return false;
    }

    if (nivel == 0) {
        ToastifyError("Seleccione un nivel");
        $("#nivel").focus();
        return false;
    }

    if (ges == 0) {
        ToastifyError("Seleccione un GES");
        $("#ges").focus();
        return false;
    }

    if (peso.trim().length == 0) {
        ToastifyError("El peso no puede estar vacio");
        $("#peso").focus();
        return false;
    }

    if (talla.trim().length == 0) {
        ToastifyError("La talla no puede estar vacia");
        $("#talla").focus();
        return false;
    }

    if (scorporal.trim().length == 0) {
        ToastifyError("El S. Corporal no puede estar vacio");
        $("#scorporal").focus();
        return false;
    }

    if (fechaadmin.trim().length == 0) {
        ToastifyError("La fecha de administracion no puede estar vacia");
        $("#fechaadmin").focus();
        return false;
    }

    if (examen.trim().length == 0) {
        ToastifyError("El examen no puede estar vacio");
        $("#examen").focus();
        return false;
    }

    if (ciclo.trim().length == 0) {
        ToastifyError("El ciclo no puede estar vacio");
        $("#ciclo").focus();
        return false;
    }

    if (anticipada.trim().length == 0) {
        ToastifyError("La anticipada no puede estar vacia");
        $("#anticipada").focus();
        return false;
    }

    if (urgente.trim().length == 0) {
        ToastifyError("Debe seleccionar si es urgente o no");
        $("#urgente").focus();
        return false;
    }

    //Validar alergia
    if (alergia == 1) {
        if (alergiadetalle.trim().length == 0) {
            ToastifyError("Debe ingresar el detalle de la alergia");
            $("#alergiadetalle").focus();
            return false;
        }
    }




    var creatinina = 0;
    var auc = 0;

    //Comprobar si el creatinina y el auc esta con la propiedad required
    if ($("#creatinina").prop("required")) {
        creatinina = $("#creatinina").val();
        if (creatinina <= 0) {
            ToastifyError("La creatinina no puede ser menor o igual a 0");
            $("#creatinina").focus();
            return false;
        }
    }

    if ($("#auc").prop("required")) {
        auc = $("#auc").val();
        if (auc <= 0) {
            ToastifyError("El AUC no puede ser menor o igual a 0");
            $("#auc").focus();
            return false;
        }
    }

    var esquema = $("#esquema").val();

    if (esquema == 0) {
        ToastifyError("Seleccione un esquema");
        $("#esquema").focus();
        return false;
    }
    var otrcormo = "";
    var otrocor = 0;
    if ($("#otrocor").is(':checked')) {
        otrocor = 1;
        otrcormo = $("#otrcormo").val();
        if (otrcormo.trim().length == 0) {
            ToastifyError("Debe ingresar la otra comorbilidad");
            $("#otrcormo").focus();
            return false;
        }
    }

    //Captura de medicamentos seleccionados
    const medicamentoscheck = [];

    try {
        $("#medicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var medicamentoname = $(this).find("span[name^='medicamentoname']").text();
            const porcentajeSelect = $(this).find("select");
            var carboplatinoval = $(this).find("input[name^='carboplatino']").val();
            const medidaInput = $(this).find("input[name^='medida']");
            const totalMgInput = $(this).find("input[name^='totalmg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const itCheckbox = $(this).find("input[name^='it']");
            const biccadCheckbox = $(this).find("input[name^='biccad']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var porcentaje = porcentajeSelect.val();
                var medida = medidaInput.val();
                //Validar que la medida no sea menor o igual a 0
                if (medida <= 0) {
                    ToastifyError("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La Dosis MG Esquema no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var totalMg = totalMgInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (totalMg <= 0) {
                    ToastifyError("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    throw new Error("La dosis Total MG no puede ser menor o igual a 0 para el medicamento " + medicamentoname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }
                var it = 0;
                if (itCheckbox.prop("checked")) {
                    it = 1;
                }
                var biccad = 0;
                if (biccadCheckbox.prop("checked")) {
                    biccad = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0 && it == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    throw new Error("Debe seleccionar al menos una via de administracion para el medicamento " + medicamentoname);
                    return;
                }

                var observacion = observacionInput.val();
                const data = {
                    medicamento: checkbox.val(),
                    porcentaje: porcentaje,
                    carboplatinoval: carboplatinoval,
                    medida: medida,
                    totalMg: totalMg,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    it: it,
                    biccad: biccad,
                    observacion: observacion
                };
                medicamentoscheck.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar los medicamentos seleccionados");
        return;
    }


    //Captura de Premedicacion
    const premedicaciones = [];
    try {
        $("#premedicamentoscharge tr.m-0").each(function () {
            const checkbox = $(this).find("input[type='checkbox']");
            var premedicacionname = $(this).find("span[name^='premedicacionname']").text();
            const dosisInput = $(this).find("input[name^='dosismg']");
            const oralCheckbox = $(this).find("input[name^='oral']");
            const evCheckbox = $(this).find("input[name^='ev']");
            const scCheckbox = $(this).find("input[name^='sc']");
            const observacionInput = $(this).find("input[name^='observacion']");

            if (checkbox.prop("checked")) {
                var dosis = dosisInput.val();
                //Validar que la dosis no sea menor o igual a 0
                if (dosis <= 0) {
                    ToastifyError("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    throw new Error("La dosis no puede ser menor o igual a 0 para la premedicacion " + premedicacionname);
                    return;
                }
                var oral = 0;
                if (oralCheckbox.prop("checked")) {
                    oral = 1;
                }
                var ev = 0;
                if (evCheckbox.prop("checked")) {
                    ev = 1;
                }
                var sc = 0;
                if (scCheckbox.prop("checked")) {
                    sc = 1;
                }

                //Validar que se haya seleccionado la via de administracion
                if (oral == 0 && ev == 0 && sc == 0) {
                    ToastifyError("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    throw new Error("Debe seleccionar al menos una via de administracion para la premedicacion " + premedicacionname);
                    return;
                }

                var observacion = observacionInput.val();

                const data = {
                    premedicacion: checkbox.val(),
                    dosis: dosis,
                    oral: oral,
                    ev: ev,
                    sc: sc,
                    observacion: observacion
                };
                premedicaciones.push(data);
            }
        });
    } catch (error) {
        console.log("Error al capturar las premedicaciones seleccionadas");
        return;
    }

    //Estimulador
    var estimulador = 0;
    var cantidades = 0;
    var rango = 0;
    if ($("#estimulador").is(':checked')) {
        estimulador = 1;
        cantidades = $("#cantidades").val();
        rango = $("#rango").val();
    }

    //Observaciones
    var anamnesis = $("#anamnesis").val();
    var observaciones = $("#observacion").val();

    //Validar medicamentos
    if (medicamentoscheck.length == 0) {
        ToastifyError("Debe seleccionar al menos un medicamento");
        return;
    }

    //Validar premedicaciones
    if (premedicaciones.length == 0) {
        ToastifyError("Debe seleccionar al menos una premedicacion");
        return;
    }

    //Validar estimulador
    if (estimulador == 1) {
        if (cantidades.trim().length == 0) {
            ToastifyError("La cantidad no puede estar vacia");
            $("#cantidades").focus();
            return;
        }

        if (rango.trim().length == 0) {
            ToastifyError("El rango no puede estar vacio");
            $("#rango").focus();
            return;
        }
    }

    if (observaciones.trim().length == 0) {
        ToastifyError("Las observaciones no pueden estar vacias");
        $("#observacion").focus();
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/insert/receta1.php",
        data: { paciente: paciente, medico: medico, empresa: empresa, consulta: consulta, estadio: estadio, nivel: nivel, ges: ges, peso: peso, talla: talla, scorporal: scorporal, creatinina: creatinina, auc: auc, fechaadmin: fechaadmin, examen: examen, ciclo: ciclo, anticipada: anticipada, curativo: curativo, paliativo: paliativo, adyuvante: adyuvante, concomitante: concomitante, neoadyuvante: neoadyuvante, primera: primera, traemedicamentos: traemedicamentos, diabetes: diabetes, hipertension: hipertension, alergia: alergia, alergiadetalle: alergiadetalle, otrocor: otrocor, otrcormo: otrcormo, urgente: urgente, esquema: esquema, medicamentoscheck: medicamentoscheck, premedicaciones: premedicaciones, estimulador: estimulador, cantidades: cantidades, rango: rango, observaciones: observaciones, receta: receta, folio: folio, carbovalid: carbovalid },
        success: function (respuesta) {
            try {
                var receta = JSON.parse(respuesta);
                //si el elemento error = true, mostrar error
                if (receta.error == true) {
                    ToastifyError(receta.message);
                } else if (receta.error == false) {
                    ToastifySuccess(receta.message);
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        //Volver a la pagina anterior
                        location.href = previo;
                    }, 500);
                }
            } catch (error) {
                ToastifyError(respuesta);

            }
        },
        error: function (error) {
            ToastifyError(error);
        }
    });
}
function calc(id) {
    let carbop = $("#carboplatino" + id).val();
    if (carbop == 0 || carbop == 2) {
        if ($("#medicamento" + id).prop("checked") == true) {
            var dosis = $("#medida" + id).val();
            var porcentaje = $("#porcentaje" + id).val();
            var scorporal = $("#scorporal").val();

            if (dosis.trim().length == 0) {
                dosis = 0;
                $("#totalmg" + id).val(0);
                return;
            }

            if (porcentaje.trim().length == 0) {
                porcentaje = 0;
            }

            if (scorporal.trim().length == 0) {
                scorporal = 0;
            }

            var totalmg = ((dosis * porcentaje) / 100) * scorporal;
            var totalMg = totalmg.toFixed(1);
            $("#totalmg" + id).val(totalMg);
        } else {
            $("#totalmg" + id).val(0);
        }
    } else {

    }
}