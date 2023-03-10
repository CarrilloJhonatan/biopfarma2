$(document).ready(function() {

    if ($('#sesion').val() == '1') {

        localStorage.setItem('id_user', JSON.stringify($('#id_usuario').val()));
    }
    cargarpedido();
    verUndCarrito();





    $(".CategoriasVer").on("click", function() {
        var categoria = $(this).data('product_code');
        var nombrecate = $(this).data('product_code1');

        $("#formulario" + categoria).submit();

    });

    $('#recoTienda').change(function() {

        if ($('#recoTienda').prop('checked')) {

            $('#direccion').prop('disabled', true);
        } else {

            $('#direccion').prop('disabled', false);
        }
    });
});

//CARGAR PEDIDOS AL CLIENTE

function cargarpedido() {
    var id = JSON.parse(localStorage.getItem('id_user'));

    if ($('#id_usuario').val() != id && $('#id_usuario').val() != '') {

        localStorage.setItem('id_user', $('#id_usuario').val());
        if (localStorage.getItem('codpedido') != null) {
            var codpedido = JSON.parse(localStorage.getItem('codpedido'));
        }


        var formData = new FormData();

        formData.append('codpedido', codpedido);

        $.ajax({
            type: "POST",
            url: urlCargarpedido,
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {

                if (data) {

                    alertify.success('Pedidos Cargados');



                }



            }
        });

        location.reload();
    }
}



//FUNCION DE LLAMADO DE LAS UNIDADES DE PRODUCTOS 
function verUndCarrito() {

    $.ajax({
        type: "POST",
        url: urlTotalCarrito,
        dataType: "JSON",
        data: {},
        success: function(data) {
            var i;


            if (data != 0) {

                for (i = 0; i < data.length; i++) {
                    if (data[i].total == null) {

                        $("#codigoped").text('');
                        $("#domicilio").text(0);
                        $(".totalCarrito").text(0);
                        $("#subtotal").text(0);
                        $("#sumTotalCarrito").text(0);
                        if (localStorage.getItem('codpedido') != null) {
                            localStorage.removeItem('codpedido')
                        }

                    } else {
                        if ($("#codigoped").text() == '') {
                            $("#codigoped").text(JSON.parse(localStorage.getItem('codpedido')));
                        }
                        $(".totalCarrito").text(data[i].total);
                        var domicilio = 3000;
                        $("#domicilio").text(Intl.NumberFormat('de-DE').format(domicilio));
                        $("#subtotal").text(Intl.NumberFormat('de-DE').format(data[i].totalsum));
                        var total = domicilio + parseFloat(data[i].totalsum);
                        $("#sumTotalCarrito").text(Intl.NumberFormat('de-DE').format(total))
                    }
                }
            }

        }
    });
}

$('.totalPedidosBtn').on('click', function() {

    tablaPedidos();
    $('#verModalPedido').appendTo("body").modal('show');

});

// CARGAR TABLE DE MIS PEDIDOS
function tablaPedidos() {
    $.ajax({
        type: "POST",
        url: urlTodoMispedidos,
        dataType: "JSON",
        data: {},
        success: function(data) {



            tablepedidos = $('#tablapedidos').DataTable({
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
                "searching": false,
                "autoWidth": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "initComplete": function() {
                    //Apply text search
                    this.api().columns([0, 1, 2, 3, 4]).every(function() {
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
                    /*
                                    this.api().columns([3]).every(function () {
                                        var title = $(this.footer()).text();
                    
                                        $(this.footer()).html('<input type="date" class="form-control form-control-sm" placeholder="Buscar..." />');
                                        var that = this;
                                        $('input',this.footer()).on('keyup change', function () {
                                            if (that.search() !== this.value) {
                                                that
                                                    .search(this.value)
                                                    .draw();
                                            }
                                        });

                                    });*/

                },
                "columns": [{ "data": "fecfac" },
                    { "data": "numfac" },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {

                            return '<div class="text-center"><button type="button" class="btn btn-outline-warning fa fa-eye" id="verArticulos"></button></div>';

                        }
                    },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {

                            return parseFloat(data['valfac']) - parseFloat(data['descfac'])
                        }
                    },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {
                            var mensaje;
                            var clase;
                            if (data['pedidoestado'] == 0) {
                                mensaje = 'Proceso';
                                clase = 'badge-primary';
                            }
                            if (data['pedidoestado'] == 1) {
                                mensaje = 'Despachado';
                                clase = 'badge-success'
                            }
                            if (data['pedidoestado'] == 2) {
                                mensaje = 'entregado'
                                clase = 'badge-info'
                            }
                            return '<div class="text-center"><span class="badge ' + clase + '">' + mensaje + '</span></div>';

                        }
                    },

                    //Select de calificacion
                    /*{
                        "data": null,
                        "mRender": function(data, type, full) {

                            return '<div class="text-center"><select class="form-control"><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option></select></div>';

                        }
                    }*/
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

$('#tablapedidos').on('click', '#verArticulos', function() {

    var data = tablepedidos.row($(this).parents('tr')).data();
    var fecfac = data.fecfac;
    var numfac = data.numfac;

    var formData = new FormData();

    formData.append('fecfac', fecfac);
    formData.append('numfac', numfac);
    tablaarticulos(formData)
});

function tablaarticulos(formData) {
    $.ajax({
        type: "POST",
        url: urlTodoArticulosp,
        contentType: false,
        processData: false,
        data: formData,
        success: function(data) {
            var datos = JSON.parse(data);

            contenido = `<table class="table table-bordered">
            <thead>
              <tr>
                
                <th scope="col">nombre</th>
                <th scope="col">cantidad</th>
                
              </tr>
            </thead><tbody>`

            datos.forEach(e => {
                contenido += ` <tr>
  
  <td>${e.nomart}</td>
  <td>${e.qtyart}</td>

</tr>`
            })

            $.confirm({
                title: 'Articulos',
                content: contenido + `</tbody> </table>`,
                buttons: {


                }
            });


        }
    });
}

//ABRIR MODAL DE EL CARRITO DE COMPRA
$('.totalCarritoBtn').on('click', function() {

    tablaCarrito();
    $('#verModalCarrito').appendTo("body").modal('show');

});

//MODAL DE CARRITO DE COMPRA CON TABLA
function tablaCarrito() {
    $.ajax({
        type: "POST",
        url: urlTodoCarrito,
        dataType: "JSON",
        data: {},
        success: function(data) {
            tablecarrito = $('#tablaCarrito').DataTable({
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
                "searching": false,
                "autoWidth": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "initComplete": function() {
                    //Apply text search

                    this.api().columns([0, 1, 2, 3, 4]).every(function() {
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
                    /*
                                                            this.api().columns([3]).every(function () {
                                                                var title = $(this.footer()).text();
                    
                                                                $(this.footer()).html('<input type="date" class="form-control form-control-sm" placeholder="Buscar..." />');
                                                                var that = this;
                                                                $('input',this.footer()).on('keyup change', function () {
                                                                    if (that.search() !== this.value) {
                                                                        that
                                                                            .search(this.value)
                                                                            .draw();
                                                                    }
                                                                });

                                                            });*/

                },
                "columns": [{
                        "data": null,
                        "mRender": function(data, type, full) {
                            localStorage.setItem('codpedido', JSON.stringify(data['c_pedido']));
                            $("#codigoped").text(data['c_pedido']);
                            return '<div class="text-center"><a><img src="' + url + full.imageurl + '" alt="Imagen del porducto"  class="thumbnail" width="40px" /></a></div>';

                        }
                    },
                    { "data": "nomart" },
                    { "data": "c_und" },
                    { "data": "c_totalvalor", render: $.fn.dataTable.render.number(",", ".", 0, '$ ') },
                    {
                        "data": null,
                        "mRender": function(data, type, full) {

                            return '<div class="text-center"><button type="button" class="btn btn-outline-danger fa fa-trash-o" id="eliminarCarrito"></button></div>';

                        }
                    },
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

//ELIMINAR PRODUCTOS DEL CARRITO DE COMPRA
$('#tablaCarrito').on('click', '#eliminarCarrito', function() {

    var data = tablecarrito.row($(this).parents('tr')).data();
    var fecha = data.c_fecha;
    var articulo = data.c_producto;
    var total = data.c_totalvalor;
    var nombre = data.nomart;


    var formData = new FormData();
    formData.append('fecha', fecha);
    formData.append('articulo', articulo);
    formData.append('total', total);

    $.confirm({
        title: 'Eliminar!',
        content: 'Deseas quitar a <strong>' + nombre + '</strong>!',
        buttons: {
            SI: {
                btnClass: 'btn btn-outline-success',
                action: function() {
                    $.ajax({
                        type: "POST",
                        url: urleliminarCarrito,
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            tablaCarrito();
                            verUndCarrito();

                            // $('#verModalCarrito').modal('hide');

                        }
                    });
                }
            },

            NO: {
                btnClass: 'btn btn-outline-danger',
                action: function() {
                    alertify.error('Operacion Cancelada');
                }
            }

        }
    });

});

function guardarComentario() {

    var comentario = $('#comentarioCarrito').val();
    var codpedido = $("#codigoped").text();

    if (comentario != '') {


        $('#comentarioPedido').val(comentario);
        $('#comentarioCarrito').val('');
        /*var formData = new FormData();

        formData.append('comentario', comentario)
        formData.append('codpedido', codpedido)

        $.ajax({
            type: "POST",
            url: urlguardarComent,
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {

                if (data) {
                    alertify.success('comentario guardado')
                } else {
                    alertify.error('ocurrio un error')
                }

                // $('#verModalCarrito').modal('hide');

            }
        });*/

    }




}

//COMPRAR
$('#btnComprar').on('click', function() {

    var id = JSON.parse(localStorage.getItem('id_user'))
    if ($('#id_usuario').val() == id && $('#sesion').val() != 0) {
        $.alert({
            title: 'Alerta!',
            content: '<h6 class="text-center">Para realizar el pedido debe iniciar sesion!</h6>',
            buttons: {
                CERRAR: {
                    btnClass: 'btn btn-outline-danger',
                    action: function() {
                        $(location).attr('href', IniciarSesion);
                    }
                }
            }
        });
    } else {
        var totalCarrito = $("#sumTotalCarrito").text();

        if (totalCarrito <= 0) {
            $.alert({
                title: 'Alerta!',
                content: '<h6 class="text-center">El monto total es cero debe elegir productos!</h6>',
                buttons: {
                    CERRAR: {
                        btnClass: 'btn btn-outline-danger',
                        action: function() {}
                    }
                }
            });

            return false;
        } else {

            $.confirm({
                title: 'Mensaje!',
                content: 'Deseas generar el pedido?',
                buttons: {
                    SI: {
                        btnClass: 'btn btn-outline-success',
                        action: function() {
                            $("#verModalCarrito").modal('hide'); //ocultamos el modal
                            $('[name="formapago"]').val('');
                            //$('[name="direccion"]').val('');
                            //$('[name="telefono"]').val('');
                            $('[name="CodProm"]').val('');
                            guardarComentario();

                            $('#ModalPago').appendTo("body").modal('show');
                            $("#verModalCarrito").modal('hide'); //ocultamos el modal

                        }
                    },

                    NO: {
                        btnClass: 'btn btn-outline-danger',
                        action: function() {
                            alertify.error('Operacion Cancelada');
                            $("#verModalCarrito").modal('hide'); //ocultamos el modal

                        }
                    }

                }
            });

        }


    }



});




//COMPRAR

$('#btnGuardarVenta1').click(async function() {
    var formapago = $('[name="formapago"] option:selected').val();
    if (localStorage.getItem('codpedido') !== null) {
        var codpedido = JSON.parse(localStorage.getItem('codpedido'));
    }

    var comentario = $('#comentarioPedido').val();

    var codpromo = $('#CodProm').val();

    if (codpromo != '') {

        var result = await verificarcodprom(codpromo);

        if (!result) {
            alertify.error('Codigo no valido');
            return false;
        }
    }

    var telefono = $('[name="telefono"]').val();
    if ($('#recoTienda').prop('checked')) {
        var direccion = 'Recoger en tienda';
    } else {
        var direccion = $('[name="direccion"]').val();
    }

    if (formapago == null) {
        alertify.error('Seleccione un tipo de pago');
        return false;
    }

    if (direccion == '') {
        alertify.error('llene el campo de direccion');
        return false;
    }

    if (telefono == '') {
        alertify.error('llene el campo de telefono');
        return false;
    }


    var formData = new FormData();
    formData.append('formapago', formapago);
    formData.append('direccion', direccion);
    formData.append('telefono', telefono);
    formData.append('codpedido', codpedido);
    formData.append('comentario', comentario);
    formData.append('codprom', codpromo);


    // if (formapago == 1) {
    $('#btnGuardarVenta1').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: urlSite + '/app/ControladorVenta/guardar',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {

            $('[name="formapago"]').val('');
            //$('[name="direccion"]').val('');
            // $('[name="telefono"]').val('');
            $('[name="CodProm"]').val('');
            verUndCarrito();
            $('#ModalPago').modal('hide');

            $.alert({
                title: 'Mensaje!',
                content: '<h6 class="text-center">Tu pedido fue exitoso. Muchas gracias!</h6>',
                buttons: {
                    CERRAR: {
                        btnClass: 'btn btn-outline-success',
                        action: function() {
                            localStorage.removeItem('codpedido')

                            $('#btnGuardarVenta').prop('disabled', false);
                            $('#btnGuardarVenta1').prop('disabled', false);
                        }
                    }
                }
            });
        }
    });
});

async function verificarcodprom(codigo) {

    var formData = new FormData();
    var result;
    formData.append('codigo', codigo)

    await $.ajax({
        type: "POST",
        url: urlVerificarCod,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {




            result = data;

        }
    });

    return result;



}

$('.buscarSlider').on('click', function() {

    var id = $(this).data('product_code');

    $("#carousel" + id).submit();



});