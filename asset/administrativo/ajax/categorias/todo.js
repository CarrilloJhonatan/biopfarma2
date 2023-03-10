$(document).ready(function() {

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>';

    $("#avatar-2").fileinput({
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
        defaultPreviewContent: '<img src="' + urlCategoriablanco + 'asset/administrativo/imgcategoria/imgblanco.png" alt="Your Avatar"><h6 class="text-muted">Click para seleccionar</h6>',
        layoutTemplates: { main2: '{preview} ' + btnCust + ' {remove} {browse}' },
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

    $.ajax({
        type: "POST",
        url: urlCategoriasTabla,
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaCategorias').DataTable({
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
                    this.api().columns([1, 2, 3]).every(function() {
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

                    this.api().columns([4]).every(function() {
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

                },
                "columns": [{
                        "data": null,
                        "mRender": function(data, type, full) {

                            if (full.img != '') {
                                return '<div class=col-md-12 text-center"><img src="' + urlCategoriablanco + '/' + full.img + '" alt="Imagen del porducto"  class="thumbnail" width="40px" /></div>';
                            } else {
                                return '<div class=col-md-12 text-center"><img src="' + urlCategoriablanco + 'asset/administrativo/imgcategoria/imgblanco.png" alt="Imagen del porducto"  class="thumbnail" width="40px" /></div>';
                            }

                        }
                    },
                    { "data": "id" },
                    { "data": "nomgru" },
                    { "data": "usuario" },
                    { "data": "fecha" },
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



});



$('#btnCreaCategorias').on('click', function() {

    $('[name="id"]').val(0);
    $('[name="nomgru"]').val('');
    $('[name="urlimg"]').val('');

    $("#btnEliminarCategorias").addClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnGuardarCategorias').on('click', function() {

    var id = $('[name="id"]').val();
    var nomgru = $('[name="nomgru"]').val();
    var urlimg = $('[name="urlimg"]').val();

    if (nomgru == "") {
        alertify.error('Digite el Nombre de la categoria');
        $('[name="nomgru"]').focus();
        return false;
    }

    var formData = new FormData();
    var files = $('#avatar-2')[0].files[0];
    formData.append('file', files);
    formData.append('id', id);
    formData.append('nomgru', nomgru);
    formData.append('urlimg', urlimg);

    $.ajax({
        type: "POST",
        url: urlCategoriasGuardar,
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
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Esta categoria ya se encuentra registrada.</h5>", function() {});
            }
        }
    });
    return false;
});

$('#tablaCategorias tbody').on('click', 'tr', function() {

    var data = table.row($(this)).data();

    var id = data.id;
    var nomgru = data.nomgru;
    var urlimg = data.img;

    $('[name="id"]').val(id);
    $('[name="nomgru"]').val(nomgru);
    $('[name="urlimg"]').val(urlimg);

    $("#btnEliminarCategorias").removeClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');


});

$('#btnEliminarCategorias').on('click', function() {

    var id = $('[name="id"]').val();
    var nomgru = $('[name="nomgru"]').val();

    var formData = new FormData();
    formData.append('id', id);
    formData.append('nomgru', nomgru);

    alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar a ' + nomgru + '</h6>', function() {

        $.ajax({
            type: "POST",
            url: urlCategoriasEliminar,
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