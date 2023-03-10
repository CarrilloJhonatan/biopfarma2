$(document).ready(function() {

    vertablasubcategoria();


});

//select
$('.categoria').select2({
    dropdownParent: $('#exampleModal'),
    placeholder: 'Selecciona una categoria',
    allowClear: true,
    width: '100%',
    ajax: {
        type: "post",
        url: siteUrl + '/administrativo/ControladorArticulos/categoria',
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


function vertablasubcategoria() {

    $.ajax({
        type: "POST",
        url: siteUrl + '/administrativo/ControladorLineas/todo',
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaLineas').DataTable({
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
                    this.api().columns([0, 1, 2]).every(function() {
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

                },
                "columns": [
                    { "data": "codsubcate" },
                    { "data": "categoria" },
                    { "data": "nomsubcate" },
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

$('#btnCreaLineas').on('click', function() {

    $('[name="id"]').val(0);
    $('[name="categoria"]').append($('<option>', {
        val: '',
        text: '',
        selected: true
    }));
    $('[name="codsubcate"]').val('');
    $('[name="nomsubcate"]').val('');

    $('[name="categoria"]').prop("disabled", false);
    $('[name="codsubcate"]').prop("disabled", false);
    $("#btnEliminarLineas").addClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnGuardarLineas').on('click', function() {

    var id = $('[name="id"]').val();
    var categoria = $('[name="categoria"]').val();
    var codsubcate = $('[name="codsubcate"]').val();
    var nomsubcate = $('[name="nomsubcate"]').val();

    if (categoria == "") {
        alertify.error('Seleccione la categoria');
        $('[name="categoria"]').focus();
        return false;
    }

    if (codsubcate == "") {
        alertify.error('Digite codigo de la  subcategoria');
        $('[name="codsubcate"]').focus();
        return false;
    }

    if (nomsubcate == "") {
        alertify.error('Digite nombre de la  subcategoria');
        $('[name="codsubcate"]').focus();
        return false;
    }

    var formData = new FormData();
    formData.append('id', id);
    formData.append('categoria', categoria);
    formData.append('codsubcate', codsubcate);
    formData.append('nomsubcate', nomsubcate);

    $.ajax({
        type: "POST",
        url: siteUrl + '/administrativo/ControladorLineas/guardar',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {

            if (data == 0) {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function() {
                        vertablasubcategoria();
                        $("#exampleModal").modal('hide'); //ocultamos el modal
                    });
            } else {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Codigo de subcategoria se encuentra registrada.</h5>", function() {});
            }
        }
    });
    return false;
});

$('#tablaLineas tbody').on('click', 'tr', function() {

    var data = table.row($(this)).data();

    var id = 2;
    var codgru = data.codgru;
    var categoria = data.categoria;
    var codsubcate = data.codsubcate;
    var nomsubcate = data.nomsubcate;

    $('[name="id"]').val(id);
    $('[name="categoria"]').append($('<option>', {
        val: codgru,
        text: categoria,
        selected: true
    }));
    $('[name="codsubcate"]').val(codsubcate);
    $('[name="nomsubcate"]').val(nomsubcate);

    $('[name="categoria"]').prop("disabled", true);
    $('[name="codsubcate"]').prop("disabled", true);

    $("#btnEliminarLineas").removeClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');


});

$('#btnEliminarLineas').on('click', function() {

    var nomsubcate = $('[name="nomsubcate"]').val();
    var codsubcate = $('[name="codsubcate"]').val();

    var formData = new FormData();
    formData.append('nomsubcate', nomsubcate);
    formData.append('codsubcate', codsubcate);

    alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar a ' + nomsubcate + '</h6>', function() {

        $.ajax({
            type: "POST",
            url: siteUrl + '/administrativo/ControladorLineas/eliminar',
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                vertablasubcategoria();
                $("#exampleModal").modal('hide'); //ocultamos el modal
            }
        });
    }, function() { alertify.error('Operacion Cancelada') });
});