$(document).ready(function() {

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>';

    $("#image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="' + urlArticulosblanco + 'asset/administrativo/imgarticulos/imgblanco.png" alt="Your Avatar"><h6 class="text-muted">Click para seleccionar</h6>',
        layoutTemplates: { main2: '{preview} ' + btnCust + ' {remove} {browse}' },
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

    $.ajax({
        type: "POST",
        url: urlArticulosTabla,
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaArticulos').DataTable({
                "data": data,
                "bDestroy": true,
                "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
                "order": [
                    [0, "asc"]
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
                    this.api().columns([3, 4, 5, 6, 7]).every(function() {
                        var title = $(this.footer()).text();

                        $(this.footer()).html('<input type="text" class="form-control "  placeholder="Buscar..." />');
                        var that = this;
                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });

                    });

                    this.api().columns([8]).every(function() {
                        var title = $(this.footer()).text();

                        $(this.footer()).html('<input type="date" class="form-control form-control-sm" placeholder="Buscar..." />');
                        var that = this;
                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });

                    });

                    this.api().columns([1, 2]).every(function() {
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
                "columns": [{
                        "data": null,
                        "mRender": function(data, type, full) {
                            if (full.imageurl != '') {
                                return '<div class=col-md-12 text-center"><img src="' + urlArticulosblanco + '/' + full.imageurl + '" alt="Imagen del porducto"  class="thumbnail" width="40px" /></div>';
                            } else {

                                return '<div class=col-md-12 text-center"><img src="' + urlArticulosblanco + 'asset/administrativo/imgarticulos/imgblanco.png" alt="Imagen del porducto"  class="thumbnail" width="40px" /></div>';
                            }
                        }
                    },
                    { "data": "nomcat" },
                    { "data": "nomsubcate" },
                    { "data": "codart" },
                    { "data": "nomart" },
                    { "data": "valart", render: $.fn.dataTable.render.number(",", ".", 0, '$ ') },
                    { "data": "qtyart" },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {
                            if (full.tipopromo == 0) {
                                return '';
                            } else if (full.tipopromo == 1) {

                                return 'Sin promocion';

                            } else if (full.tipopromo == 2) {

                                return 'Nuevo Producto';

                            } else if (full.tipopromo == 3) {

                                return 'Los Recomendados';

                            } else if (full.tipopromo == 4) {

                                return 'Los Mas Vendidos';
                            }else if (full.tipopromo == 5){
                                return 'Promociones'
                            }
                        }
                    },
                    { "data": "fecha" },
                ],
                "columnDefs": [{
                    "targets": [0],
                    "className": "text-center"
                }, ],
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

});

//select
$('.categoria').select2({
    dropdownParent: $('#exampleModal'),
    placeholder: 'Selecciona una categoria',
    allowClear: true,
    width: '100%',
    ajax: {
        type: "post",
        url: urlArticuloscategoria,
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

$('.categoria').change(function() {

    var categoria = $('.categoria option:selected').val();
    subcategorias(categoria);

});

function subcategorias(categoria) {

    $('.subcategoria').select2({
        dropdownParent: $('#exampleModal'),
        placeholder: 'Selecciona una subcategoria',
        allowClear: true,
        width: '100%',
        ajax: {
            type: "post",
            url: siteUrl + '/administrativo/ControladorArticulos/subcategoria',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    categoria: categoria,
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

}

$('#btnCreaArticulos').on('click', function() {

    $('[name="id"]').val(0);
    $('[name="urlimg"]').val('');
    $('[name="categoria"]').append($('<option>', {
        val: '',
        text: '',
        selected: true
    }));
    $('[name="subcategoria"]').append($('<option>', {
        val: '',
        text: '',
        selected: true
    }));

    subcategorias();

    $('[name="codart"]').val('');
    $('[name="nomart"]').val('');
    $('[name="valart"]').val('');
    $('[name="qtyart"]').val('');
    $('[name="descripcion"]').val('');
    $('[name="tipopromo"]').val(1);

    $('[name="codart"]').prop("disabled", false);

    $("#btnEliminarArticulos").addClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnGuardarArticulos').on('click', function() {

    var id = $('[name="id"]').val();
    var urlimg = $('[name="urlimg"]').val();
    var categoria = $('[name="categoria"]').val();
    var subcategoria = $('[name="subcategoria"]').val();
    var codart = $('[name="codart"]').val();
    var nomart = $('[name="nomart"]').val();
    var valart = $('[name="valart"]').val();
    var qtyart = $('[name="qtyart"]').val();
    var descripcion = $('[name="descripcion"]').val();
    var tipopromo = $('[name="tipopromo"]').val();


    if (categoria == "") {
        alertify.error('Digite la categoria');
        $('[name="categoria"]').focus();
        return false;
    }


    if (codart == "") {
        alertify.error('Digite el Codigo del articulo');
        $('[name="codart"]').focus();
        return false;
    }

    if (nomart == "") {
        alertify.error('Digite el Nombre del articulo');
        $('[name="nomart"]').focus();
        return false;
    }

    if (valart == "") {
        alertify.error('Digite el Valor del articulo');
        $('[name="valart"]').focus();
        return false;
    }

    if (descripcion == "") {
        alertify.error('Digite las Descripcion del articulo');
        $('[name="descripcion"]').focus();
        return false;
    }

    if (qtyart == "") {
        alertify.error('Digite las Unidades del articulo');
        $('[name="qtyart"]').focus();
        return false;
    }

    var formData = new FormData();
    var files = $('#image')[0].files[0];

    formData.append('file', files);
    formData.append('id', id);
    formData.append('urlimg', urlimg);
    formData.append('codart', codart);
    formData.append('nomart', nomart);
    formData.append('valart', valart);
    formData.append('qtyart', qtyart);
    formData.append('descripcion', descripcion);
    formData.append('categoria', categoria);
    formData.append('subcategoria', subcategoria);
    formData.append('tipopromo', tipopromo);

    $.ajax({
        type: "POST",
        url: urlArticulosGuardar,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {

            if (data == 0) {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function() {
                        location.reload();
                    });
            } else {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Este articulo ya se encuentra registrada.</h5>", function() {});
            }
        }
    });
    return false;
});

$('#tablaArticulos tbody').on('click', 'tr', function() {

    var data = table.row($(this)).data();

    var id = data.id;
    var urlimg = data.imageurl;
    var codart = data.codart;
    var nomart = data.nomart;
    var valart = data.valart;
    var qtyart = data.qtyart;
    var descripcion = data.descripcion;
    var categoria = data.categoria;
    var categorianom = data.nomcat;
    var tipopromo = data.tipopromo;

    subcategorias(categoria);

    var subcategoria = data.subcategoria;
    var nomsubcate = data.nomsubcate;


    $('[name="id"]').val(id);
    $('[name="urlimg"]').val(urlimg);
    $('[name="codart"]').val(codart);
    $('[name="nomart"]').val(nomart);
    $('[name="valart"]').val(valart);
    $('[name="qtyart"]').val(qtyart);
    $('[name="descripcion"]').val(descripcion);
    $('[name="tipopromo"]').val(tipopromo);

    $('[name="categoria"]').append($('<option>', {
        val: categoria,
        text: categorianom,
        selected: true
    }));

    $('[name="subcategoria"]').append($('<option>', {
        val: subcategoria,
        text: nomsubcate,
        selected: true
    }));

    $('[name="codart"]').prop("disabled", true);

    $("#btnEliminarArticulos").removeClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnEliminarArticulos').on('click', function() {

    var id = $('[name="id"]').val();
    var nomart = $('[name="nomart"]').val();

    var formData = new FormData();
    formData.append('id', id);
    formData.append('nomart', nomart);

    alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar a ' + nomart + '</h6>', function() {

        $.ajax({
            type: "POST",
            url: urlArticulosEliminar,
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                location.reload();
            }
        });
    }, function() { alertify.error('Operacion Cancelada') });
});