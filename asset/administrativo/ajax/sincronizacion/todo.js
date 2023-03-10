$(document).ready(function() {
    tablaSincronizacion();
});

function tablaSincronizacion() {

    $.ajax({
        type: "POST",
        url: link_site + '/administrativo/ControladorSincronizar/tabla',
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaSincro').DataTable({
                "data": data,
                "bDestroy": true,
                "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todo"]
                ],
                "searching": true,
                "autoWidth": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "initComplete": function() {
                    //Apply text search
                    this.api().columns([0, 2, 4]).every(function() {
                        var title = $(this.footer()).text();

                        $(this.footer()).html('<input type="text" class="form-control-sm "  placeholder="Buscar..." />');
                        var that = this;
                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });

                    });

                    this.api().columns([3]).every(function() {
                        var title = $(this.footer()).text();

                        $(this.footer()).html('<input type="date" class="form-control-sm "  placeholder="Buscar..." />');
                        var that = this;
                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });

                    });



                    this.api().columns([1, 5]).every(function() {
                        var column = this;
                        var select = $('<select class="form-control selectdos" style="width:100%;"><option value="">Todo</option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                    });

                    $('.selectdos').select2();

                },
                "columns": [
                    { "data": "s_id" },
                    { "data": "s_nombre" },
                    { "data": "s_und" },
                    { "data": "fecha" },
                    { "data": "time" },
                    { "data": "usuario" },
                ],
                buttons: [
                    /* {
                            extend: 'excelHtml5',
                            title: 'Estados',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                        
                        },*/
                ]
            });
        }
    });

}

$('#btnSincronizar').on('click', function() {

    alertify.confirm('Mesaje de confirmacion', 'Deseas realizar una sincronizacion?',
        function() {

            $('#main-content').waitMe({

                effect: 'stretch',
                text: 'Sincronizando Categorias...',
                bg: '#797979',
                color: '#FFFFFF'
            });

            $.ajax({
                type: "POST",
                url: link_site + '/administrativo/ControladorSincronizar/api',
                dataType: "JSON",
                data: '',
                //contentType: false,
                //processData: false,
                success: function(data) {

                    if (data == 0) {
                        alertify
                            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se encontraron categorias nuevas.</h5>", function() {

                                tablaSincronizacion();
                                $('#main-content').waitMe("hide");
                                sincronizarProductos();

                            });


                    } else {
                        alertify
                            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se actualizaron " + data + " categorias.</h5>", function() {

                                tablaSincronizacion();
                                $('#main-content').waitMe("hide");
                                sincronizarProductos();

                            });
                    }


                }
            });
        },
        function() { alertify.error('Operacion cancelada') }).set('labels', { ok: 'SI', cancel: 'NO' });

});

function sincronizarProductos() {

    $('#main-content').waitMe({

        effect: 'stretch',
        text: 'Sincronizando Productos...',
        bg: '#797979',
        color: '#FFFFFF'
    });

    $.ajax({
        type: "POST",
        url: link_site + '/administrativo/ControladorSincronizar/api2',
        dataType: "JSON",
        data: '',
        //contentType: false,
        //processData: false,
        success: function(data) {

            if (data == 0) {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se encontraron articulos nuevos.</h5>", function() {

                        tablaSincronizacion();
                        $('#main-content').waitMe("hide");

                    });
            } else {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se actualizaron " + data + " articulos.</h5>", function() {

                        tablaSincronizacion();
                        $('#main-content').waitMe("hide");

                    });
            }


        }
    });
}