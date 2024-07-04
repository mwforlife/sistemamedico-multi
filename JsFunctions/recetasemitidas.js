function motivorechazo(id) {
    $.ajax({
        url: "php/charge/motivorechazo.php",
        type: "POST",
        data: { id: id },
        success: function (data) {
            $(".rechazocontent").html(data);
            $("#modalrechazo").modal("show");
        },
        });
}

function historialreceta(folio, consulta){
    $.ajax({
        url: "php/charge/recetafolio.php",
        type: "POST",
        data: { folio: folio, consulta: consulta },
        success: function (data) {
            try {
                var json = JSON.parse(data);
                if(json.status == true){
                    $(".historialcontent").html(json.content);
                    $("#tablehistorialreceta").DataTable({
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
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true,
                        "responsive": true
                    });
                    $("#modalhistorial").modal("show");
                }else{
                    ToastifyError(json.message);
                }
            } catch (error) {
                ToastifyError(error);
            }
        },
    });
}
