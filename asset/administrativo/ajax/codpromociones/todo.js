$(document).ready(function() {

    $.ajax({
        type: "POST",
        url: urlPromocionesTabla,
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaPromociones').DataTable({
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
                    this.api().columns([0, 1, 2, 3]).every(function() {
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

                    this.api().columns([4, 5]).every(function() {
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
                "columns": [
                    { "data": "id" },
                    { "data": "codigo" },
                    {
                        "data": 'descripcion'
                    },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {

                            return '$ ' + data.valor;

                        }
                    },
                    { "data": "fecha_inicio" },
                    { "data": "fecha_final" },
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

    $('#btnGenerar').on('click', function() {

        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < 8; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        $('#codigoprom').val(result);
    });

    //select
    $('.tbl').select2({
        dropdownParent: $('#exampleModal'),
        placeholder: 'Selecciona una tabla',
        allowClear: true,
        width: '100%',
        ajax: {
            type: "post",
            url: urlPromocionesTbl,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(data) {

                console.log(data);
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.tbl').change(function() {
        var val = $(this).val();

        //select
        $('.elegido').select2({
            dropdownParent: $('#exampleModal'),
            placeholder: 'Selecciona una descripcion',
            allowClear: true,
            width: '100%',
            ajax: {
                type: "post",
                url: urlPromocionesElegido,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        elegido: val
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

    });

    $('#btnCreaPromociones').on('click', function() {

        $('[name="tbl"]').append($('<option>', {
            val: '',
            text: '',
            selected: true
        }));
        $('[name="elegido"]').append($('<option>', {
            val: '',
            text: '',
            selected: true
        }));
        $('[name="id"]').val('');
        $('[name="valor"]').val('');
        $('[name="codigoprom"]').val('');
        $('[name="inicio"]').val('');
        $('[name="horainicio"]').val('');
        $('[name="final"]').val('');
        $('[name="horafinal"]').val('');

        $("#btnEliminarPromociones").addClass("invisible");

        $('#exampleModal').appendTo("body").modal('show');
    });

    $('#btnGuardarPromociones').on('click', function() {

        if ($('[name="id"]').val() == 0 || $('[name="id"]').val() == '') {
            var id = 0
        } else {
            var id = $('[name="id"]').val();
        }


        var tbl = $('[name="tbl"]').val();
        var elegido = $('[name="elegido"]').val();
        var valor = $('[name="valor"]').val();
        var codigoprom = $('[name="codigoprom"]').val();
        var fechainicio = $('[name="inicio"]').val();
        var fechafinal = $('[name="final"]').val();
        var horainicio = $('[name="horainicio"]').val();
        var horafinal = $('[name="horafinal"]').val();
        var fecha1 = Date.parse(fechainicio + ' ' + horainicio)
        var fechai = new Date(fecha1)
        var fecha2 = Date.parse(fechafinal + ' ' + horafinal)
        var fechaf = new Date(fecha2)


        if (tbl == "") {
            alertify.error('Seleccione la tabla');
            return false;
        }

        if (elegido == "") {
            alertify.error('Seleccione la descripcion');
            return false;
        }


        if (valor == "") {
            alertify.error('Digite el valor');
            $('[name="porcentaje"]').focus();
            return false;
        }
        if (codigoprom == "") {
            alertify.error('Genere un codigo de promocion');
            return false;
        }



        if (fechainicio == "") {
            alertify.error('Seleccione la fecha de inicio');
            return false;
        }

        if (fechafinal == "") {
            alertify.error('Seleccione la fecha de finalizacion');
            return false;
        }

        if (fechai >= fechaf) {
            alertify.error('la fecha final no puede ser menor o igual a la inical.');
            return false;
        }

        debugger
        var formData = new FormData();
        formData.append('id', id);
        formData.append('tbl', tbl);
        formData.append('elegido', elegido);
        formData.append('valor', valor);
        formData.append('fechainicio', fechainicio);
        formData.append('fechafinal', fechafinal);
        formData.append('horainicio', horainicio);
        formData.append('horafinal', horafinal);
        formData.append('codigo', codigoprom);

        $.ajax({
            type: "POST",
            url: urlPromocionesGuardar,
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function() {
                        location.reload();
                    });
            }
        });
        return false;
    });

    $('#tablaPromociones tbody').on('click', 'tr', function() {

        var data = table.row($(this)).data();

        console.log('datos tabla: ', data)
        var id = data.id;
        var tbl = data.t_id;
        var tblnombre = data.t_nombre;

        var elegido = data.elegido;


        var elegidonombre = data.descripcion;
        var valor = data.valor;
        var inicio = data.fecha_inicio;
        var horainicio = data.hora_inicio;
        var final = data.fecha_final;
        var horafinal = data.hora_final;
        var codprom = data.codigo;




        $('[name="id"]').val(id);
        $('[name="valor"]').val(valor);
        $('[name="codigoprom"]').val(codprom);
        $('[name="inicio"]').val(inicio);
        $('[name="horainicio"]').val(horainicio);
        $('[name="final"]').val(final);
        $('[name="horafinal"]').val(horafinal);
        $('[name="tbl"]').append($('<option>', {
            val: tbl,
            text: tblnombre,
            selected: true
        }));

        $('[name="elegido"]').append($('<option>', {
            val: elegido,
            text: elegidonombre,
            selected: true
        }));

        $("#btnEliminarPromociones").removeClass("invisible");

        $('#exampleModal').appendTo("body").modal('show');
    });

    $('#btnEliminarPromociones').on('click', function() {

        var id = $('[name="id"]').val();

        var formData = new FormData();
        formData.append('id', id);

        alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar este item</h6>', function() {

            $.ajax({
                type: "POST",
                url: urlPromocionesEliminar,
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

});