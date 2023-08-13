$(function () {
   'use strict'

   $('#example1').DataTable({
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

   $('#tabl1').DataTable({
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

   $('#tabl2').DataTable({
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

   $('#example3').DataTable({
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

   $('#example4').DataTable({
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

  



   //Data table example
   var table = $('#exportexample').DataTable({
      lengthChange: false,
      buttons: ['copy', 'excel', 'pdf']
   });
   table.buttons().container()
      .appendTo('#exportexample_wrapper .col-md-6:eq(0)');


   $('#example2').DataTable({
      responsive: true,
      language: {
         searchPlaceholder: 'Search...',
         sSearch: '',
         lengthMenu: '_MENU_ items/page',
      }
   });

   $('#example5').DataTable({
      responsive: {
         details: {
            display: $.fn.dataTable.Responsive.display.modal({
               header: function (row) {
                  var data = row.data();
                  return 'Details for ' + data[0] + ' ' + data[1];
               }
            }),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
               tableClass: 'table'
            })
         }
      }
   });

   /*Input Datatable*/
   var table = $('#example-input').DataTable({
      'columnDefs': [
         {
            'targets': [1, 2, 3, 4, 5],
            'render': function (data, type, row, meta) {
               if (type === 'display') {
                  var api = new $.fn.dataTable.Api(meta.settings);

                  var $el = $('input, select, textarea', api.cell({ row: meta.row, column: meta.col }).node());

                  var $html = $(data).wrap('<div/>').parent();

                  if ($el.prop('tagName') === 'INPUT') {
                     $('input', $html).attr('value', $el.val());
                     if ($el.prop('checked')) {
                        $('input', $html).attr('checked', 'checked');
                     }
                  } else if ($el.prop('tagName') === 'TEXTAREA') {
                     $('textarea', $html).html($el.val());

                  } else if ($el.prop('tagName') === 'SELECT') {
                     $('option:selected', $html).removeAttr('selected');
                     $('option', $html).filter(function () {
                        return ($(this).attr('value') === $el.val());
                     }).attr('selected', 'selected');
                  }

                  data = $html.html();
               }

               return data;
            }
         }
      ],
      'responsive': true
   });
   $('#example-input tbody').on('keyup change', '.child input, .child select, .child textarea', function (e) {
      var $el = $(this);
      var rowIdx = $el.closest('ul').data('dtr-index');
      var colIdx = $el.closest('li').data('dtr-index');
      var cell = table.cell({ row: rowIdx, column: colIdx }).node();
      $('input, select, textarea', cell).val($el.val());
      if ($el.is(':checked')) {
         $('input', cell).prop('checked', true);
      } else {
         $('input', cell).removeProp('checked');
      }
   });





});