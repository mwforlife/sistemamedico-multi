$(document).ready(function(){
    $("#reserveevent").click(function(){
        var id = $("#reserve-id").val();
        var observacion = $("#observacion").val();
        var estado = $("#estado").val();

        $.ajax({
            url: "php/update/atencion.php",
            type: "POST",
            data: {id: id, observacion: observacion, estado: estado},
            success: function(data){
                try {
                    var json = JSON.parse(data);
                    if(json.status == true){
                        ToastifySuccess(json.message);
                        setTimeout(function(){location.reload();}, 500);
                    }else{
                        ToastifyError(json.mensage);
                    }
                } catch (error) {
                    ToastifyError(error);   
                }
            }
        });
    }
    );
});



function atender(id){
    $("#reserveeventmodal").modal("show");
    $("#reserve-id").val(id);
}

function atencion(id){
    $.ajax({
        url: "php/charge/atencion.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            //Comporbar si es un json
            try{
                var json = JSON.parse(data);
                if(json.error==false){
                    window.location.href = "detallepaciente.php?r="+json.id+"&p="+json.paciente;
                }else{
                    ToastifyError(json.mensaje);
                }
            }catch{
                ToastifyError("Error al cargar");
            }
        }
    });
}

function Finalizaratencion(id){
    $.ajax({
        url: "php/update/finalizaratencion.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            if(data == 1){
                ToastifySuccess("Finalizada");
                setTimeout(function(){location.reload();}, 1500);
            }else{
                ToastifyError("Error al finalizar");
            }
        }
    });
}

function cargarreservas(){
    var fechainicio = $("#desde").val();
    var fechatermino = $("#hasta").val();
    $.ajax({
        url: "php/charge/reservas.php",
        type: "POST",
        data: { action: 'cargarreservas', fechainicio: fechainicio, fechatermino: fechatermino },
        success: function (data) {
            try {
                var json = JSON.parse(data);
                if(json.status == true){
                    $(".table-reserve").html(json.table);
                    $("#example1").DataTable({
                        language: {
                            searchPlaceholder: 'Buscar..',
                            sSearch: '',
                            lengthMenu: '_MENU_ datos/página',
                            zeroRecords: 'No se encontraron resultados',
                            info: 'Mostrando página _PAGE_ de _PAGES_',
                            infoEmpty: 'No hay datos disponibles',
                            infoFiltered: '(filtrado de _MAX_ datos totales)',
                            paginate: {
                               first: 'Primero',
                               previous: 'Anterior',
                               next: 'Siguiente',
                               last: 'Último'
                            },
                         },
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         buttons: ['copy', 'excel', 'pdf']
                    });
                }else{
                    $(".table-reserve").html("<div class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i> "+json.message+"</div>");
                }
            } catch (error) {
                $(".table-reserve").html("<div class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i> "+error+"</div>");
            }
        },
    });
}

function cargarreservasdoc(){
    var fechainicio = $("#desde").val();
    var fechatermino = $("#hasta").val();
    $.ajax({
        url: "php/charge/reservasmedico.php",
        type: "POST",
        data: { action: 'cargarreservas', fechainicio: fechainicio, fechatermino: fechatermino },
        success: function (data) {
            try {
                var json = JSON.parse(data);
                if(json.status == true){
                    $(".table-reserve").html(json.table);
                    $("#example1").DataTable({
                        language: {
                            searchPlaceholder: 'Buscar..',
                            sSearch: '',
                            lengthMenu: '_MENU_ datos/página',
                            zeroRecords: 'No se encontraron resultados',
                            info: 'Mostrando página _PAGE_ de _PAGES_',
                            infoEmpty: 'No hay datos disponibles',
                            infoFiltered: '(filtrado de _MAX_ datos totales)',
                            paginate: {
                               first: 'Primero',
                               previous: 'Anterior',
                               next: 'Siguiente',
                               last: 'Último'
                            },
                         },
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         buttons: ['copy', 'excel', 'pdf']
                    });
                }else{
                    $(".table-reserve").html("<div class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i> "+json.message+"</div>");
                }
            } catch (error) {
                $(".table-reserve").html("<div class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i> "+error+"</div>");
            }
        },
    });
}

function historial(id){
    $.ajax({
        url: "php/charge/historialestado.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            try {
                var json = JSON.parse(data);
                if(json.status == true){
                    $("#historialbody").html(json.historial);
                    $("#modalhistorial").modal("show");
                }else{
                    ToastifyError(json.message);
                }
            } catch (error) {
                ToastifyError(error);
            }
        }
    });
}