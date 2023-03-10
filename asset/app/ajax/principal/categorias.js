$(document).ready(function() {


    todoArticulos();
    verUndCarrito();
    var Vtbl = '';
    var Vdescripcion = '';

    //-- Click on QUANTITY
    $(".btn-minus").on("click", function() {
        var now = $(".section > div > #undProducto").val();
        if ($.isNumeric(now)) {
            if (parseInt(now) - 1 > 0) { now--; }
            $(".section > div > #undProducto").val(now);
        } else {
            $(".section > div > #undProducto").val("1");
        }
    });

    $(".btn-plus").on("click", function() {
        var now = $(".section > div > #undProducto").val();
        if ($.isNumeric(now)) {
            $(".section > div > #undProducto").val(parseInt(now) + 1);
        } else {
            $(".section > div > #undProducto").val("1");
        }
    });

    alertify.defaults.transition = "slide";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";


    $('#recoTienda').change(function() {

        if ($('#recoTienda').prop('checked')) {

            $('#direccion').prop('disabled', true);
        } else {

            $('#direccion').prop('disabled', false);
        }
    });

});
//redireccionar a la subcategoria

$('#btnAtras').on('click', function() {

    var formData = new FormData();
    formData.append('categoria', $('#categoriaPost').val());
    formData.append('nombre', $('#nombrePost').val());

    $.ajax({
        type: "POST",
        url: urlSubcategorias,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            // $(locarion).attr('href',)
        }

    });

});


function guardarComentario() {

    var comentario = $('#comentarioCarrito1').val();
    var codpedido = $("#codigoped").text();

    if (comentario != '') {


        $('#comentarioPedido1').val(comentario);
        $('#comentarioCarrito1').val('');
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
//LLAMADO A TODOS LOS PRODUCTOS A PANATALLA
function todoArticulos() {

    $('#contenido').html('<div id="loading" style="" ></div>');

    var busquedaGeneral = $('#busquedaGeneral').val();
    var minimo = $('#manimoF').val();
    var maximo = $('#maximoF').val();
    var categoriaPost = $('#categoriaPost').val();
    var input_tbl = $('#input_tbl').val();
    var input_elegido = $('#input_elegido').val();

    //NOMBRE DE LA CATEGORIA ENVIADO POR POST
    var nombrePost = $("#nombrePost").val();

    var formData = new FormData();
    formData.append('busquedaGeneral', busquedaGeneral);
    formData.append('minimo', minimo);
    formData.append('maximo', maximo);
    formData.append('categoriaPost', categoriaPost);
    formData.append('input_tbl', input_tbl);
    formData.append('input_elegido', input_elegido);
    formData.append('subcate', nombrePost);

    $.ajax({
        type: "POST",
        url: urlInicio,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            var html = '';
            var i;
            if (data != 0) {
                for (i = 0; i < data.length; i++) {
                    if (data[i].promo != '') {
                        html += `
                            <div class="col-6 verProductosClick jar" style="cursor:pointer;"
                                        data-product_code3="` + data[i].id + `"
                                        data-product_code1="` + data[i].imageurl + `"
                                        data-product_code2="` + data[i].categoria + `"
                                        data-product_code="` + data[i].codart + `"
                                        data-product_code4="` + data[i].nomart + `"
                                        data-product_code5="` + data[i].valart + `"
                                        data-product_code6="` + data[i].qtyart + `"
                                        data-product_code7="` + data[i].descripcion + `"
                                        data-product_code8="` + data[i].estado + `"
                                        data-product_code9="` + (data[i].valart - ((data[i].valart * data[i].promo) / 100)) + `"
                                        >
                                <div class="product_featured_tile">
                                    <img src="" alt="" class="product_brand">
                                    <span class="product_img">
                                        <img src="` + url + data[i].imageurl + `" alt="">
                                    </span> 
                                    <span class="product_title">
                                        ` + data[i].nomart.substr(0, 14) + `...
                                        <span class="product_cat">
                                        ` + nombrePost + `
                                        </span>
                                    </span>  
                                   
                                    <span class="product_price">
                                    <del class="product_cat text-dark"><i class="fa fa-usd"></i> ` + Intl.NumberFormat('de-DE').format(data[i].valart) + `</del>
                                        <i class="fa fa-usd"></i> ` + Intl.NumberFormat('de-DE').format((data[i].valart - ((data[i].valart * data[i].promo) / 100))) + `
                                    </span> 
                                </div>
                            </div>
                      `;
                    } else {

                        html += `
                        <div class="col-6 verProductosClick jar" style="cursor:pointer;"
                                    data-product_code3="` + data[i].id + `"
                                    data-product_code1="` + data[i].imageurl + `"
                                    data-product_code2="` + data[i].categoria + `"
                                    data-product_code="` + data[i].codart + `"
                                    data-product_code4="` + data[i].nomart + `"
                                    data-product_code5="` + data[i].valart + `"
                                    data-product_code6="` + data[i].qtyart + `"
                                    data-product_code7="` + data[i].descripcion + `"
                                    data-product_code8="` + data[i].estado + `"
                                    data-product_code9="` + data[i].promo + `">
                            <div class="product_featured_tile">
                                <img src="" alt="" class="product_brand">
                                <span class="product_img">
                                    <img src="` + url + data[i].imageurl + `" alt="">
                                </span> 
                                <span class="product_title">
                                    ` + data[i].nomart.substr(0, 14) + `...
                                    <span class="product_cat">
                                    ` + nombrePost + `
                                    </span>
                                </span>  
                               
                                <span class="product_price">
                                <br>
                                <i class="fa fa-usd"></i> ` + Intl.NumberFormat('de-DE').format(data[i].valart) + `
                                </span> 
                            </div>
                        </div>
                  `;
                    }



                }

                html2 = `<nav>
                            <ul class="pagination justify-content-center pagination-sm"></ul>
                        </nav>`;
                $('#contenido').html(html);
                $('#paginacion').html(html2);

                function getPageList(totalPages, page, maxLength) {
                    if (maxLength < 4) throw "maxLength must be at least 5";

                    function range(start, end) {
                        return Array.from(Array(end - start + 1), (_, i) => i + start);
                    }

                    var sideWidth = maxLength < 9 ? 1 : 2;
                    var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                    var rightWidth = (maxLength - sideWidth * 2 - 2) >> 1;

                    if (totalPages <= maxLength) {
                        // no breaks in list
                        return range(1, totalPages);
                    }

                    if (page <= maxLength - sideWidth - 1 - rightWidth) {
                        // no break on left of page
                        return range(1, maxLength - sideWidth - 1)
                            .concat([0])
                            .concat(range(totalPages - sideWidth + 1, totalPages));
                    }

                    if (page >= totalPages - sideWidth - 1 - rightWidth) {
                        // no break on right of page
                        return range(1, sideWidth)
                            .concat([0])
                            .concat(
                                range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages)
                            );
                    }
                    // Breaks on both sides
                    return range(1, sideWidth)
                        .concat([0])
                        .concat(range(page - leftWidth, page + rightWidth))
                        .concat([0])
                        .concat(range(totalPages - sideWidth + 1, totalPages));
                }

                $(function() {
                    // Number of items and limits the number of items per page
                    var numberOfItems = $("#contenido .jar").length;
                    var limitPerPage = 8;
                    // Total pages rounded upwards
                    var totalPages = Math.ceil(numberOfItems / limitPerPage);
                    // Number of buttons at the top, not counting prev/next,
                    // but including the dotted buttons.
                    // Must be at least 5:
                    var paginationSize = 6;
                    var currentPage;

                    function showPage(whichPage) {
                        if (whichPage < 1 || whichPage > totalPages) return false;
                        currentPage = whichPage;
                        $("#contenido .jar")
                            .hide()
                            .slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage)
                            .show();
                        // Replace the navigation items (not prev/next):
                        $(".pagination li").slice(1, -1).remove();
                        getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                            $("<li>")
                                .addClass(
                                    "page-item " +
                                    (item ? "current-page " : "") +
                                    (item === currentPage ? "active " : "")
                                )
                                .append(
                                    $("<a>")
                                    .addClass("page-link ")
                                    .attr({
                                        href: "javascript:void(0)"
                                    })
                                    .text(item || "...")
                                )
                                .insertBefore("#next-page");
                        });
                        return true;
                    }

                    // Include the prev/next buttons:
                    $(".pagination").append(
                        $("<li>").addClass("page-item").attr({ id: "previous-page" }).append(
                            $("<a>")
                            .addClass("page-link fa fa-angle-double-left")
                            .attr({
                                href: "javascript:void(0)"
                            })
                            .text("") //Aqui va el nombre del boton
                        ),
                        $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
                            $("<a>")
                            .addClass("page-link fa fa-angle-double-right")
                            .attr({
                                href: "javascript:void(0)"
                            })
                            .text("") //Aqui va el nombre del boton
                        )
                    );
                    // Show the page links
                    $("#contenido").show();
                    showPage(1);

                    // Use event delegation, as these items are recreated later
                    $(
                        document
                    ).on("click", ".pagination li.current-page:not(.active)", function() {
                        return showPage(+$(this).text());
                    });
                    $("#next-page").on("click", function() {
                        return showPage(currentPage + 1);
                    });

                    $("#previous-page").on("click", function() {
                        return showPage(currentPage - 1);
                    });
                    $(".pagination").on("click", function() {
                        $("html,body").animate({ scrollTop: 0 }, 0);
                    });
                });
            } else {
                $('#paginacion').html('');
                $('#contenido').html(`<div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"><i class="fa fa-search-minus" aria-hidden="true"></i> No se encontro el filtro</h4>
                        <p>No encontramos lo q estas buscando.</p>
                        <hr>
                        <p class="mb-0">Global.</p>
                    </div>
                </div>`);
            }
        }
    });

}

//AGARRA LAS CLASES DE LOS CHECKBOX
function get_filter(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function() {
        filter.push($(this).val());
    });
    return filter;
}


$('#slaider2').on('click', '#buscarSlider', function() {

    var tbl = $(this).data('product_code');
    var elegido = $(this).data('product_code1');
    var nombre = $(this).data('product_code2');

    $.confirm({
        title: 'Buscar!',
        content: 'Deseas buscar esta promocion?',
        buttons: {
            SI: {
                btnClass: 'btn btn-outline-success',
                action: function() {
                    if (tbl == 1) {
                        $("#busquedaGeneral").val('');
                        $(".categoriasF").prop("checked", false);
                        $('[name=categoriasF' + elegido + ']').prop("checked", true);
                        todoArticulos();

                    } else {

                        $(".categoriasF").prop("checked", false);
                        $("#busquedaGeneral").val(nombre);
                        todoArticulos();
                    }
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

$('#quitarfiltro').click(function() {

    $.confirm({
        title: 'Quitar filtro!',
        content: 'Deseas Quitar el filtro?',
        buttons: {
            SI: {
                btnClass: 'btn btn-outline-success',
                action: function() {

                    $("#busquedaGeneral").val('');
                    $("#manimoF").val('');
                    $("#maximoF").val('');

                    //$(".categoriasF").prop("checked",false);  
                    todoArticulos();

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

$('#btnBusquedaGeneral').click(function() {
    todoArticulos();
});

$('#busquedaGeneral').on('keypress', function(e) {
    if (e.which == 13) {
        todoArticulos();
    }
});

$('.common_selector').click(function() {
    todoArticulos();
});

$('#manimoF').change(function() {
    todoArticulos();
});

$('#maximoF').change(function() {
    todoArticulos();
});

//FUNCION DE LLAMADO DE LAS UNIDADES DE PRODUCTOS 
function verUndCarrito() {

    var formData = new FormData();

    if (localStorage.getItem('codpedido') !== null) {
        var codpedido = JSON.parse(localStorage.getItem('codpedido'));
    }

    formData.append('codpedido', codpedido)

    $.ajax({
        type: "POST",
        url: urlTotalCarrito,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
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
                    } else {
                        if ($("#codigoped").text() == '') {
                            $("#codigoped").text(JSON.parse(localStorage.getItem('codpedido')));
                        }
                        $(".totalCarrito").text(data[i].total);
                        var domicilio = 3000;
                        $("#domicilio").text(Intl.NumberFormat('de-DE').format(domicilio));
                        $("#subtotal").text(Intl.NumberFormat('de-DE').format(data[i].totalsum));
                        var total = domicilio + parseFloat(data[i].totalsum);
                        $("#sumTotalCarrito").text(Intl.NumberFormat('de-DE').format(total));
                    }
                }
            }

        }
    });
}

//AL DAR CLICK SE ABRE EL MODAL DE LAS DESCIPCIONES DE LOS PRODUCTOS
$('#contenido').on('click', '.verProductosClick', function() {

    var id = $(this).data('product_code');
    var img = $(this).data('product_code1');
    var nombre = $(this).data('product_code4');
    var valor = $(this).data('product_code5');
    var descripcion = $(this).data('product_code7');
    var promo = $(this).data('product_code9');

    $("#undProducto").val(1);
    $("#nombreProducto1").text(nombre);
    $("#nombreProducto2").text(nombre);
    $("#descripcionProducto").text(descripcion);
    $("#idProducto").val(id);
    if (promo != '') {
        $("#precioProducto2").val(promo);
        $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(promo));
        $("#precioProductoAntes").text('$ ' + Intl.NumberFormat('de-DE').format(valor));

    } else {

        $("#precioProducto2").val(valor);
        $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valor));
        $("#precioProductoAntes").text(' ');
    }

    $("#urlProducto").attr('src', url + img);

    var formData = new FormData();
    formData.append('id', id);

    $.ajax({
        type: "POST",
        url: urlSite + '/app/ControladorInicio/variante',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            var html = '';
            var comparacion1 = '';
            var comparacion2 = '';
            var i;
            var variantes1 = [];
            var codvariante1 = [];
            var count = 0;
            if (data != 0) {
                comparacion1 = 'inicio1';
                comparacion2 = 'inicio1';

                for (i = 0; i < data.length; i++) {

                    comparacion1 = data[i].nomvar;

                    if (comparacion1 != comparacion2) {
                        count++;
                        html += `
                            <div class="list-group">    
                                <p style="color:black">${data[i].nomvar}</p>
                                <select class="form-control" name="${data[i].nomvar}" id="radio-nobg-sm-${count}">
                                    <option value="${data[i].codartvar}" selected>${data[i].nomartvar}</option>
                                </select>
                        `;

                        //comparacion1 =  data[i].nomvar;

                    } else {
                        if (count == 1) {
                            variantes1.push(data[i].nomartvar);
                            codvariante1.push(data[i].codartvar);
                        } else {
                            $('#radio-nobg-sm-' + count).append('<option value="' + data[i].codartvar + '">' + data[i].nomartvar + '</option>');

                        }

                    }

                    if (comparacion1 != comparacion2) {
                        comparacion2 = data[i].nomvar;
                        html += '</div>';
                        $('#tblVariantes').html(html);
                    }

                }

                for (var i = 0; i < codvariante1.length; i++) {
                    $('#radio-nobg-sm-' + 1).append('<option value="' + codvariante1[i] + '">' + variantes1[i] + '</option>');
                }

            } else {
                $('#tblVariantes').html('');
            }

        }
    });


    $('#ModalVerProductos').appendTo("body").modal('show');
});

//AL ELEGIR EL PRODUCTO Y GUARDAR
$('#addCarrito').on('click', function() {
    var pedido = $("#codpedido").val();
    if (localStorage.getItem('codpedido') == null) {
        localStorage.setItem('codpedido', JSON.stringify(pedido))
    }

    if (localStorage.getItem('codpedido') != null) {
        var codpedido = JSON.parse(localStorage.getItem('codpedido'));
    }

    var fechaAct = (moment().format('YYYY-MM-DD HH:mm:ss'));
    var id = $("#idProducto").val();
    var und = $("#undProducto").val();
    var precio = $("#precioProducto2").val();
    var nombre = $("#nombreProducto2").text();




    if (und == "") {
        alertify.error("favor llenar");
        return false;
    }

    if (und <= 0) {
        alertify.error("producto mayores a 0 und");
        return false;
    }

    var formData = new FormData();
    formData.append('id', id);
    formData.append('und', und);
    formData.append('precio', precio);
    formData.append('fechaAct', fechaAct);
    formData.append('codpedido', codpedido);

    $.confirm({
        title: 'Mensaje!',
        content: 'Deseas agregar a la lista <strong>' + nombre + '</strong>!',
        buttons: {
            SI: {
                btnClass: 'btn btn-outline-success',
                action: function() {

                    /**GUADARDAO DE DETALLEVARIANTE */
                    $.ajax({
                        type: "POST",
                        url: urlSite + '/app/ControladorInicio/variante',
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            var comparacion1 = 'inicio1';
                            var comparacion2 = 'inicio1';
                            var i;
                            var count = 0;
                            if (data != 0) {

                                for (i = 0; i < data.length; i++) {
                                    comparacion1 = data[i].nomvar;

                                    if (comparacion1 != comparacion2) {
                                        count++
                                        var variante = $("#radio-nobg-sm-" + count).val();
                                        comparacion2 = data[i].nomvar;
                                        formData.append('variante', variante);
                                    }

                                    $.ajax({
                                        type: "POST",
                                        url: urlSite + '/app/ControladorCarrito/guardarvariante',
                                        dataType: "JSON",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(data) {

                                        }
                                    });
                                }
                            }
                        }
                    });

                    /**GUADARDAO DE CARRITO DE COMPRA */
                    $.ajax({
                        type: "POST",
                        url: urlGuardarCarrito,
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            verUndCarrito();
                            $('#ModalVerProductos').modal('hide');

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

$('.totalPedidosBtn').on('click', function() {

    //tablaCarrito();
    $('#verModalPedido').appendTo("body").modal('show');

});

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

//ABRIR MODAL DE FILTROS
$('.flotante2').on('click', function() {

    $('#modalFiltro').appendTo("body").modal('show');

});

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
                            guardarComentario()
                            $("#verModalCarrito").modal('hide'); //ocultamos el modal
                            $('[name="formapago"]').val('');
                            //$('[name="direccion"]').val('');
                            //$('[name="telefono"]').val('');
                            $('[name="CodProm"]').val('');
                            $('#ModalPago').appendTo("body").modal('show');



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
$('#ModalPago').on('click', '#btnGuardarVenta', async function() {
    //$('#btnGuardarVenta').on('click',function(){
    if (localStorage.getItem('codpedido') != null) {
        var codpedido = JSON.parse(localStorage.getItem('codpedido'));
    }
    var formapago = $('[name="formapago"] option:selected').val();

    var telefono = $('[name="telefono"]').val();

    var comentario = $('#comentarioPedido1').val();

    var codpromo = $('#CodProm').val();

    if (codpromo != '') {

        var result = await verificarcodprom(codpromo);

        if (!result) {
            alertify.error('Codigo no valido');
            return false;
        }
    }

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
    $('#btnGuardarVenta').prop('disabled', true);
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
                            localStorage.removeItem('id_user')
                            $('#btnGuardarVenta').prop('disabled', false);
                            $('#btnGuardarVenta1').prop('disabled', false);

                        }
                    }
                }
            });
        }
    });
    /* } else if (formapago == 2) {

       $.ajax({
           type: "POST",
           url: urlSite + '/app/ControladorVenta/guardar',
           dataType: "JSON",
           data: formData,
           contentType: false,
           processData: false,
           success: function(data) {

               verUndCarrito();
               $('[name="formapago"]').val('');
               $('[name="direccion"]').val('');
               $('[name="telefono"]').val('');
               $('#ModalPago').modal('hide');
               $(".epayco-button-render").trigger("click");

               var valfac2 = data[0].valfac;
               var factura2 = data[0].tipfac + ' - ' + data[0].numfac;

               
               var epayco =` <form>
                                   <script
                                       src="https://checkout.epayco.co/checkout.js"
                                       class="epayco-button"
                                       data-epayco-key="491d6a0b6e992cf924edd8d3d088aff1"
                                       data-epayco-amount="`+valfac2+`"
                                       data-epayco-name="Vestido Mujer Primavera"
                                       data-epayco-description="`+factura2+`"
                                       data-epayco-currency="cop"
                                       data-epayco-country="co"
                                       data-epayco-test="true"
                                       data-epayco-external="false"
                                       data-epayco-response="https://ejemplo.com/respuesta.html"
                                       data-epayco-confirmation="https://ejemplo.com/confirmacion">
                                   </script>
                               </form>`;


               $('#verapayco').html(epayco);

           }*/
    // });

    //}
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
                    }
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