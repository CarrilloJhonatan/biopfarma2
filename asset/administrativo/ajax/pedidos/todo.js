$(document).ready(function() {

    verTablaFactura();
});

function verTablaFactura() {

    $.ajax({
        type: "POST",
        url: urlCategorias + '/administrativo/ControladorPedidos/todo',
        dataType: "JSON",
        data: {},
        success: function(data) {
            table = $('#tablaPedidos').DataTable({
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
                    this.api().columns([0, 1, 2, 3, 4, 5, 6, 7]).every(function() {
                        var title = $(this.footer()).text();

                        $(this.footer()).html('<input type="text" class="form-control-sm"  placeholder="Buscar..." />');
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
                    { "data": "codcto" },
                    { "data": "tipfac" },
                    { "data": "numfac" },
                    { "data": "u_username" },
                    { "data": "fecfac" },
                    { "data": "valfac" },
                    { "data": "descfac" },
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

$('#tablaPedidos tbody').on('click', 'tr', async function() {

    var tbdata = table.row($(this)).data();
    var formData = new FormData();



    formData.append('numfac', tbdata.numfac);
    formData.append('fecfac', tbdata.fecfac);

    // modalDetalle(formData);
    detalleResumido(formData);

});

/*
function modalDetalle(formData) {
    $.ajax({
        type: "POST",
        url: urlCategorias + '/administrativo/ControladorPedidos/detalle',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {

            var data1 = data['detalle']
            console.log(data1)
            var data2 = data['variante']

            var compArt = 'articulo';
            var compVar = 'variante';
            var i;
            var html = '';


            for (i = 0; i < data1.length; i++) {
                var codart = data1[i].codart;
                compVar = data1[i].dv_variante;
                if (compArt != codart) {



                    if (compArt != data1[i].codart) {

                        $comp = false;

                        for (let j = 0; j < data2.length; j++) {
                            $var = data2[j].codart;

                            if (data1[i].codart == $var && !$comp) {
                                html += `<h4>${data2[j].nomart}</h4> <div class="list-group">`;
                                $var = data2[j].codart;
                                $comp = true;
                            }

                            if (compVar == data2[j].codartvar && data1[i].dv_articulo == data2[j].codart) {

                                html += `
                                    
                                            
                                    <a href="#" class="list-group-item list-group-item-action active bg-success">
                                    ${data2[j].nomvar}
                                    </a>
                                    <span class="list-group-item list-group-item-action">
                                        <div class="funkyradio-success funkyradio-NOBG">
                                            <div class="funkyradio-sm">
                                                <input type="radio" name="${data2[j].nomvar}" id="radio-nobg-sm-1" value="${data2[j].codartvar}" checked>
                                                <label for="radio-nobg-sm-1">${data2[j].nomartvar}</label>
                                            </div>
                                        </div>
                                    </span>
                                `;

                            }

                        }

                    }

                } else {
                    for (let j = 0; j < data2.length; j++) {
                        $var = data2[j].codart;

                        if (compVar == data2[j].codartvar && data1[i].dv_articulo == data2[j].codart) {

                            html += `
                                
                                        
                                <a href="#" class="list-group-item list-group-item-action active bg-success">
                                ${data2[j].nomvar}
                                </a>
                                <span class="list-group-item list-group-item-action">
                                    <div class="funkyradio-success funkyradio-NOBG">
                                        <div class="funkyradio-sm">
                                            <input type="radio" name="${data2[j].nomvar}" id="radio-nobg-sm-1" value="${data2[j].codartvar}" checked>
                                            <label for="radio-nobg-sm-1">${data2[j].nomartvar}</label>
                                        </div>
                                    </div>
                                </span>
                            `;

                        }
                    }
                }


                compArt = data1[i].codart;


            }
            html += ' </div>';

            $('#tblDetalle').html(html);

        }
    });

    $('#exampleModal').appendTo("body").modal('show');
}*/

function detalleResumido(formData) {
    $.ajax({
        type: "POST",
        url: urlCategorias + '/administrativo/ControladorPedidos/detalleResumen',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {


            $('#numfac').val(data[0]['numfactura'])
            $('#mediopago').text(data[0]['mediopago'])
            $('#reftrans').text(data[0]['reftrans'])
            $('#tipomediopago').text(data[0]['tipomediopago'])
            $('#codtranferencia').text(data[0]['codtranferencia'])
            $('#direccion').text(data[0]['direccion'])
            table = $('#pedidosResumido').DataTable({
                "data": data,
                "bDestroy": true,
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
                "columns": [
                    { "data": "item" },
                    { "data": "nomart" },
                    { "data": "valart" },
                    { "data": "qtyart" },
                    { "data": "totart" },
                    { "data": "comentario" }


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

    $('#exampleModalResumen').appendTo("body").modal('show');

    verTablaFactura();
}

$('#cancelarPedido').on('click', function() {

    var formData = new FormData();
    formData.append('numfac', $('#numfac').val());

    alertify.confirm('Advertencia!', 'Deseas cancelar este pedido?',
        function() {


            $.ajax({
                type: "POST",
                url: urlCategorias + '/administrativo/ControladorPedidos/cancelar',
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#exampleModalResumen').modal('hide');
                    verTablaFactura();
                    alertify.success('Pedido Cancelado.');

                }
            });


        },


        function() {
            $('#exampleModalResumen').modal('hide');
            alertify.error('Operacion Cancelada');
        }



    );



});