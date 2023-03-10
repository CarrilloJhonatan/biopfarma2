$(document).ready(function() {
    
    //terminarCompra()
    terminarCompra();
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //esta linea es necesaria para chrome
    window.onhashchange = function() { window.location.hash = "no-back-button"; }
    //$('#btnGuardarVenta').hide()
    if ($('#sesion').val() == '1') {

        localStorage.setItem('id_user', JSON.stringify($('#id_usuario').val()));
    }
    cargarpedido()
    slaiderfun();
  
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

    //MODAL CARD CROUSEL PRODUCTS
    $('.items').slick({
        dots: true,
        infinite: true,
        speed: 800,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
    });


    $('#recoTienda').change(function() {

        if ($('#recoTienda').prop('checked')) {

            $('#direccion').prop('disabled', true);
        } else {

            $('#direccion').prop('disabled', false);
        }
    });
});

async function terminarCompra() {
    var op = $('#mensaje').val();
    var press = $.Event("keypress");
    $('#payu').html('')
    press.ctrlKey = false;
    press.which = 81;

    await verUndCarrito()

    if (op == 'APPROVED') {
        alertify.success('Puede continuar con el pedido.');
        $('#ModalPago').appendTo("body").modal('show');
        $('#btnGuardarVenta').show()

        setTimeout(function() {
        }, 500)
      
    } else if (op == 'DECLINED') {

        alertify.error('Transaccion rechazada Intentelo mas tarde');
        await cargarValores()
        $('#ModalPago').appendTo("body").modal('show');
        $('#btnGuardarVenta').hide();
    } else if (op == 'PENDING') {
		$('#btnGuardarVenta').hide();
        alertify.error('Transaccion pendiente intentelo mas tarde');
        await cargarValores()
        $('#ModalPago').appendTo("body").modal('show');
        $('#btnGuardarVenta').show()   
     }
}

function rand_code(chars, lon) {
    code = "";
    for (x = 0; x < lon; x++) {
        rand = Math.floor(Math.random() * chars.length);
        code += chars.substr(rand, 1);
    }
    return code;
}

$('.totalPedidosBtn').on('click', function() {

    tablaPedidos();
    $('#verModalPedido').appendTo("body").modal('show');

});

//CARGAR PEDIDOS AL CLIENTE
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

function cargarpedido() {

    var id = JSON.parse(localStorage.getItem('id_user'));

    if ($('#id_usuario').val() != id && $('#id_usuario').val() != '') {

        localStorage.setItem('id_user', $('#id_usuario').val());
        if (localStorage.getItem('codpedido') != null) {
            var codpedido = JSON.parse(localStorage.getItem('codpedido'));
        }

        id_usuario = $('#id_usuario').val();
        var formData = new FormData();

        formData.append('codpedido', codpedido);
        formData.append('id', id_usuario);

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


//LLAMADO A EL CAROUSEL
function slaiderfun() {

    $.ajax({
        type: "POST",
        url: urlSlaider,
        dataType: "JSON",
        data: {},
        contentType: false,
        processData: false,
        success: function(data) {
            var html = '';
            var html2 = '';
            var active = '';
            var i;
            var cont = 1;
            if (data != 0) {
                for (i = 0; i < data.length; i++) {
                    if (cont == 1) { active = "active" } else { active = "" }
                    html += `   <li data-target="#carouselExampleIndicators" data-slide-to="0" class="` + active + `"></li>`;
                    html2 += `  <div class="carousel-item ` + active + `">
                                    <img class="d-block w-100"  src="` + url + data[i].p_img + `" alt="First slide" id="buscarSlider"
                                    data-product_code   =   "` + data[i].p_tbl + `"
                                    data-product_code1  =   "` + data[i].p_elegido + `"
                                    data-product_code2  =   "` + data[i].descripcion + `">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5></h5>
                                        <p></p>
                                    </div>
                                </div>`;
                    cont++;
                }

                $('#slaider').html(html);
                $('#slaider2').html(html2);
            } else {
                $('#slaider').html('');
                $('#slaider2').html('');
            }
        }
    });

}
$(".CategoriasVer").on("click", function() {



    var categoria = $(this).data('product_code');
    var nombrecate = $(this).data('product_code1');


    $("#formulario" + categoria).submit();

});



//LLAMADO A TODOS LOS PRODUCTOS A PANATALLA
function todoArticulos() {
    
    $('#contenido').html('<div id="loading" style="" ></div>');

    var busquedaGeneral = $('#busquedaGeneral').val();
    var minimo = $('#manimoF').val();
    var maximo = $('#maximoF').val();
    var categoria = get_filter('categoriasF');

    var formData = new FormData();
    var codalmm = $('#codalmm').val();
    
    formData.append('codalmm', codalmm)
    formData.append('busquedaGeneral', busquedaGeneral);
    formData.append('minimo', minimo);
    formData.append('maximo', maximo);
    formData.append('categoria', categoria);
    
    
  
   /*  let date = new Date()

    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
   
    var fechaActual ="";
    var horaminuto ="";
    
  
      
      fechaActual=(`${year}-${month}-${day}`);
      
   */
      let date = new Date();
      let day = date.getDate();
   
      if(day < 10){
        daa =(`0${day}`);
      }else{
        daa =(`${day}`);
      }

      let hora = date.getHours()
      let min = date.getMinutes();
      horaminutos = (`${hora}:${min}`);
        let fechaActual = String(date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + daa) ;
        
    
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
          //  console.log(data);
          //console.log(fechaActual);
          
            if (data != 0) {
               

                for (i = 0; i < data.length; i++) {
                    var iva = data[i].iva;
                    var preciobasetemp = data[i].valart;
                    if(iva != 0){
                        
                        var preciotemp = (preciobasetemp*iva)/100;
                        var preciobase =  parseInt(preciobasetemp);
                        var preciofinaltemp = preciobase + preciotemp;
                        var preciofinal = ""+preciofinaltemp;
                    }else{
                        preciofinal = preciobasetemp;
                    }
    
                    var HoraIniciio = "";
                    var HoraFin = "";

                    if(data[i].HoraInicio == null){
                     HoraIniciio = 0; 
                        }else{
                            
                            HoraIniciio = data[i].HoraInicio;
                         
                        }

                            if(data[i].HoraFin == null){
                                HoraFin = 0;
                            }else{
                                HoraFin = data[i].HoraFin
                            }
                            
                    if( data[i].FechaFin >= fechaActual  &&  data[i].dcto != null  && data[i].dcto != 0  ){
                        html += `<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-6 verProductosClick jar" style="cursor:pointer; "
                       data-product_code="` + data[i].id + `"
                       data-product_code1="` + data[i].imageurl + `"
                       data-product_code2="` + data[i].categoria + `"
                       data-product_code3="` + data[i].codart + `"
                       data-product_code4="` + data[i].nomart + `"
                       data-product_code5="` + preciofinal+ `"
                       data-product_code6="` + data[i].qtyart + `"
                       data-product_code7="` + data[i].descripcion + `"
                       data-product_code8="` + data[i].estado + `"
                       data-product_code9="` + data[i].dcto + `"
                       data-product_code10="` + data[i].vrdcto + `"
                       data-product_code11="` + data[i].artPaga + `"
                       data-product_code12="` + data[i].artLleva + `"
                       data-product_code13="`+ data[i].iva+`"
                       data-product_code14 = "`+ data[i].valart+`"
                   >

               <div class="blog-card blog-card-blog">
               <div class="promocion"
               style="    background-color: initial;
               
               background-repeat: no-repeat;
               background-size: contain;
               width: 4rem;
               height: 4rem;
               position: relative;"
               
               ><img src="https://biopharmaciavirtual.com.co/img/icono_descuento.svg">
               <span class="spampromo"
               style="    top: 10px!important;
               color: #fff;
               font-weight: 600;
               overflow: hidden;
               text-align: center;
               margin: 0.5rem auto 0;
               align-items: center;
               height: 100%;
               font-size: 1.2rem;
               position: absolute;
               transform: translate(-50%);
               left: 50%;"
               >`+data[i].dcto+`</span>
               </div>  

                   <div class="blog-card-image text-center">
                       <a href="#"> <img class="img" src="` + url + data[i].imageurl + `" style=" width: 100%; height:200px;"> </a>
                       <div class="ripple-cont"></div>
                   </div>
                   <div class="blog-table">
                       <h6 class="blog-category blog-text-success"><i class="far fa-newspaper"></i> </h6>
                       <h4 class="blog-card-caption">
                           <a href="#" class="text-success" style="style: #000 !important;" >` + data[i].nomart.substr(0, 100) + `</a>
                       </h4>
                       <p class="blog-card-description">` + data[i].descripcion.substr(0, 100) + `</p>
                       <div class="ftr">
                           <div class="author">
                               <p class="pull-left text-success">$` + Intl.NumberFormat('de-DE').format(preciofinal) + `</p>
                               
                           </div>
                           <p class="pull-right ">Und: ` + data[i].qtyart + `<del></del></p>
                       </div>
                   </div>
               </div>
           </div>`;
          
                     
                    }else if(data[i].artPaga == 1  &&  data[i].dcto == 0  && HoraIniciio > horaminutos    && HoraFin > horaminutos ){
                      
                        
                            html += `<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-6 verProductosClick jar" style="cursor:pointer; "
                            data-product_code="` + data[i].id + `"
                            data-product_code1="` + data[i].imageurl + `"
                            data-product_code2="` + data[i].categoria + `"
                            data-product_code3="` + data[i].codart + `"
                            data-product_code4="` + data[i].nomart + `"
                            data-product_code5="` + preciofinal + `"
                            data-product_code6="` + data[i].qtyart + `"
                            data-product_code7="` + data[i].descripcion + `"
                            data-product_code8="` + data[i].estado + `"
                            data-product_code9="` + data[i].dcto + `"
                            data-product_code10="` + data[i].vrdcto + `"
                            data-product_code11="` + data[i].artPaga + `"
                            data-product_code12="` + data[i].artLleva + `"
                            data-product_code13="`+ data[i].iva+`"
                            data-product_code14 = "`+ data[i].valart+`"
                        >
                
                    <div class="blog-card blog-card-blog">
                    <div class="promocion"
                    style="    background-color: initial;
                    
                    background-repeat: no-repeat;
                    background-size: contain;
                    width: 4rem;
                    height: 4rem;
                    position: relative;"
                    
                    ><img src="https://biopharmaciavirtual.com.co/img/icono_descuento.svg">
                    <span class="spampromo"
                    style="    top: 10px!important;
                    color: #fff;
                    font-weight: 600;
                    overflow: hidden;
                    text-align: center;
                    margin: 0.5rem auto 0;
                    align-items: center;
                    height: 100%;
                    font-size: 1.2rem;
                    position: absolute;
                    transform: translate(-50%);
                    left: 50%;"
                    >Of</span>
                    </div>  
                
                        <div class="blog-card-image text-center">
                            <a href="#"> <img class="img" src="` + url + data[i].imageurl + `" style=" width: 100%; height:200px;"> </a>
                            <div class="ripple-cont"></div>
                        </div>
                        <div class="blog-table">
                            <h6 class="blog-category blog-text-success"><i class="far fa-newspaper"></i> </h6>
                            <h4 class="blog-card-caption">
                                <a href="#" class="text-success" style="style: #000 !important;" >` + data[i].nomart.substr(0, 100) + `</a>
                            </h4>
                            <p class="blog-card-description">` + data[i].descripcion.substr(0, 100) + `</p>
                            <div class="ftr">
                                <div class="author">
                                    <p class="pull-left text-success">$` + Intl.NumberFormat('de-DE').format(preciofinal) + `</p>
                                    
                                </div>
                                <p class="pull-right ">Und: ` + data[i].qtyart + `<del></del></p>
                            </div>
                        </div>
                    </div>
                </div>`;
                           
                       
                    }else{
                        //console.log("No Tiene Promocion");
                        html += `<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-6 verProductosClick jar" style="cursor:pointer; "
                            data-product_code="` + data[i].id + `"
                            data-product_code1="` + data[i].imageurl + `"
                            data-product_code2="` + data[i].categoria + `"
                            data-product_code3="` + data[i].codart + `"
                            data-product_code4="` + data[i].nomart + `"
                            data-product_code5="` + preciofinal + `"
                            data-product_code6="` + data[i].qtyart + `"
                            data-product_code7="` + data[i].descripcion + `"
                            data-product_code8="` + data[i].estado + `"
                            data-product_code13="`+ data[i].iva+`"
                            data-product_code14 = "`+ data[i].valart+`"
                       
                        >

                    <div class="blog-card blog-card-blog">
                    

                        <div class="blog-card-image text-center">
                            <a href="#"> <img class="img" src="` + url + data[i].imageurl + `" style=" width: 100%; height:200px;"> </a>
                            <div class="ripple-cont"></div>
                        </div>
                        <div class="blog-table">
                            <h6 class="blog-category blog-text-success"><i class="far fa-newspaper"></i> </h6>
                            <h4 class="blog-card-caption">
                                <a href="#" class="text-success" style="style: #000 !important;" >` + data[i].nomart.substr(0, 100) + `</a>
                            </h4>
                            <p class="blog-card-description">` + data[i].descripcion.substr(0, 100) + `</p>
                            <div class="ftr">
                                <div class="author">
                                    <p class="pull-left text-success">$` + Intl.NumberFormat('de-DE').format(preciofinal) + `</p>
                                    
                                </div>
                                <p class="pull-right ">Und: ` + data[i].qtyart + `<del></del></p>
                            </div>
                        </div>
                    </div>
                </div>`;
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
                                    .addClass("page-link")
                                    .attr({
                                       href: "#todos",
                                        onclick : "javascript:void(0)"
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
                                href: "#todos",
                                        onclick : "javascript:void(0)"
                            })
                            .text("") //Aqui va el nombre del boton
                        ),
                        $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
                            $("<a>")
                            .addClass("page-link fa fa-angle-double-right")
                            .attr({
                                href: "#todos",
                                        onclick : "javascript:void(0)"
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
                    $(".categoriasF").prop("checked", false);
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
    $('html, body').animate({
        scrollTop: $('#contenido').offset().top
        }, 1000);
});

function redireccionar() {
    window.location = urlBuscar + '#contenido'
}

$('#busquedaGeneral').on('keypress', function(e) {
    if (e.which == 13) {
        todoArticulos();
        $('html, body').animate({
            scrollTop: $('#contenido').offset().top
            }, 1000);
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
async function verUndCarrito() {
    await $.ajax({
        type: "POST",
        url: urlTotalCarrito,
        dataType: "JSON",
        data: {},
        success: function(data) {
            var i;
            if (data != 0) {
                for (i = 0; i < data.length; i++) {
                    if (data[i].total == null) {
                        var cadena = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                        var cod = rand_code(cadena, 13)
                        localStorage.setItem('codpedido', JSON.stringify(cod))
                        $("#codigoped").text(JSON.parse(localStorage.getItem('codpedido')));
                        // $("#domicilio").text(0);
                        $(".totalCarrito").text(0);
                        $("#subtotal").text(0);
                        $("#sumTotalCarrito").text(0);
                    } else {

                        if ($("#codigoped").text() == '') {

                            localStorage.setItem('codpedido', JSON.stringify(data[i].c_pedido))

                            $("#codigoped").text(JSON.parse(localStorage.getItem('codpedido')));
                        }

                        $(".totalCarrito").text(data[i].total);
                        var domicilio = 3000;
                        // $("#domicilio").text(Intl.NumberFormat('de-DE').format(domicilio));
                        var iva = parseFloat(data[i].totalsum) * 0.19;
                        var sign = "IDBn3JN5Pserw0a1JGM7mXgUOH~910262~vQoVLqfGO4kyh~20000~COP"


                        $("input[name=tax]").val(iva);
                        $("#subtotal").text(Intl.NumberFormat('de-DE').format(data[i].totalsum));
                        $("input[name=taxReturnBase]").val(data[i].totalsum)
                            // var total = domicilio + parseFloat(data[i].totalsum);
                        var total = parseFloat(data[i].totalsum);
                        $("#sumTotalCarrito").text(Intl.NumberFormat('de-DE').format(total));


                    }
                }
            }

        }
    });
}

//AL DAR CLICK SE ABRE EL MODAL DE LAS DESCIPCIONES DE LOS PRODUCTOS
$('#contenido').on('click', '.verProductosClick', function() {

var paga = $(this).data('product_code10');
var lleva = $(this).data('product_code11');
   

    var id = $(this).data('product_code3');
    var img = $(this).data('product_code1');
    var nombre = $(this).data('product_code4');
    var valor = $(this).data('product_code5');
    var dcto = $(this).data('product_code9');
    var preciobase = $(this).data('product_code14');

    var enviardcto = dcto;
    
    var descripcion = $(this).data('product_code7');
    var temp = (valor * dcto)/100;
    var enviartemp = temp;

    var valordcto = (valor - temp);
    
 




    $("#undProducto").val(1);
    $("#nombreProducto1").text(nombre);
    $("#nombreProducto2").text(nombre);
    $("#descripcionProducto").text(descripcion);
    $("#descuento").val(enviardcto);
    $("#resta").val(enviartemp);
    
    $("#preciobase").val(preciobase);
    
        if(dcto != null && dcto != 0){
            $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valordcto));
            $("#precioProducto2").val(valordcto);
         }else{
            $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valor));

            $("#precioProducto2").val(valor);
         }
    $("#idProducto").val(id);
  
    $("#urlProducto").attr('src', url + img);

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

    // var fechaAct = (moment().format('YYYY-MM-DD HH:mm:ss'));
    var id = $("#idProducto").val();
    var und = $("#undProducto").val();
    var descuentos = $("#descuento").val();
    var preciodescuento = $("#resta").val();
    var precio = $("#precioProducto2").val();
    var nombre = $("#nombreProducto2").text();  
     var preciobase = $("#preciobase").val();
    
   




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
    formData.append('descuento', descuentos);
    formData.append('resta', preciodescuento);
    formData.append('preciobase',preciobase);

    
    // formData.append('fechaAct', fechaAct);
    formData.append('codpedido', codpedido);
    $.confirm({
        title: 'Mensaje!',
        content: 'Deseas agrega al carro de compra <strong>' + nombre + '</strong>!',
        buttons: {
            SI: {
                btnClass: 'btn btn-outline-success',
                action: function() {
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

                            return '<div class="text-center"><a><img src="' + url + full.imageurl + '" alt="Imagen del porducto"  class="thumbnail" width="40px" /></a></div>';

                        }
                    },
                    { "data": "nomart" },
                    { "data": "c_und" },
                    
                    { "data": "c_descuento"},
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
    var hoy = new Date(Date.now());

    var hora
    var h
    var m
    if (hoy.getHours() < 10) {

        h = "0" + hoy.getHours()
        if (hoy.getMinutes() < 10) {
            m = "0" + hoy.getMinutes();
        } else {
            m = hoy.getMinutes();
        }
    } else {
        h = hoy.getHours()
        if (hoy.getMinutes() < 10) {
            m = "0" + hoy.getMinutes();
        } else {
            m = hoy.getMinutes();
        }
    }

    hora = h + ":" + m;

    if ($('#id_usuario').val() == id && $('#sesion').val() != 0) {
        $.alert({
            title: 'Alerta!',
            content: '<h6 class="text-center">Para realizar la compra debe iniciar sesion!</h6>',
            buttons: {
                CERRAR: {
                    btnClass: 'btn btn-outline-danger',
                    action: function() {
                        $(location).attr('href', IniciarSession);
                    }
                }
            }
        });
    } else {
        var domicilio = parseFloat($("#domicilio").text());
        var horainicio = $('[name="horainicio"]').val();
        var horafin = $('[name="horafin"]').val();


        var hora1 = Date.parse('1970-01-01T' + horainicio + 'Z');
        var hora2 = Date.parse('1970-01-01T' + horafin + 'Z');
        var horaactual = Date.parse('1970-01-01T' + hora + 'Z');
        if (horaactual >= hora1 && horaactual <= hora2) {
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
                    content: 'Deseas realizar la compra?',
                    buttons: {
                        SI: {
                            btnClass: 'btn btn-outline-success siguiente',
                            keys: ['q', ],
                            action: function() {
                                // guardarComentario()
                                $("#verModalCarrito").modal('hide'); //ocultamos el modal
                               // $('[name="formapago"]').val('');
                                //$('[name="direccion"]').val('');
                                //$('[name="telefono"]').val('');
                                //$('[name="CodProm"]').val('');
                                $('#ModalPago').appendTo("body").modal('show');

                                cargarValores()
                                $('input[name=referenceCode]').val(JSON.parse(localStorage.getItem('codpedido')))

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

        } else {
            $.alert({
                title: 'Lo sentimos!',
                content: '<h6 class="text-center">horario de atencion de hoy: ' + horainicio + ' - ' + horafin + '</h6>',
                buttons: {
                    CERRAR: {
                        btnClass: 'btn btn-outline-danger',
                        action: function() {}
                    }
                }
            });
        }

    }


});


 async function cargarValores() {
    var pedido = JSON.parse(localStorage.getItem('codpedido'))
    var formData = new FormData();
    $('#payu').html('')
    formData.append('codpedido', pedido)
    $.ajax({
        type: "POST",
        url: urlcargarValores,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data)



            html = `<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
            <input class="form-control" name="merchantId" type="hidden" value="${data.merchantId}">
            <input class="form-control" name="accountId" type="hidden" value="${data.accountId}">
            <input class="form-control" name="description" type="hidden" value="${data.description}">
            <input class="form-control" name="referenceCode" type="hidden" value="${data.referenceCode}">
            <input class="form-control" name="amount" type="hidden" value="${data.amount}">
            <input class="form-control" name="tax" type="hidden" value="${data.tax}">
            <input class="form-control" name="taxReturnBase" type="hidden" value="${data.taxReturnBase}">
            <input class="form-control" name="currency" type="hidden" value="${data.currency}">
            <input class="form-control" name="signature" type="hidden" value="${data.signature}">
            <input class="form-control" name="test" type="hidden" value="${data.test}">
            <input class="form-control" name="buyerEmail" type="hidden" value="${data.buyerEmail}">
            <input class="form-control" name="responseUrl" type="hidden" value="${data.responseUrl}">
            <input class="form-control" name="confirmationUrl" type="hidden" value="${data.confirmationUrl}">
            <input src="https://www.payulatam.com/img-secure-2015/boton_pagar_mediano.png"  name="Submit" type="image" value="PayU">
        </form>`;

            $(html).appendTo('#payu')
        }
    });
}

//COMPRAR
$('#btnGuardarVenta').click(async function() {

    var formapago = $('[name="formapago"] option:selected').val();
    //var formapago = $('#mediopago').val();
    var tipoformapago = $('#tipomediopago').val();
	var codalmm = $('#codalmm').val();
	var descuento = $('#descuento').val();
	var resta = $('#resta').val();
    var codtranferencia = $('#codtranferencia').val();
    var reftrans = $('#reftrans').val();
    if (localStorage.getItem('codpedido') !== null) {
        var codpedido = JSON.parse(localStorage.getItem('codpedido'));
    }

    //var comentario = $('#comentarioPedido').val();
    var comentario = $('#comentarioCarrito').val();

    var codpromo = $('#CodProm').val();

    if (codpromo != '') {

        var result = await verificarcodprom(codpromo);

        if (!result) {
            alertify.error('Codigo no valido');
            return false;
        }
    }

    var telefono = $('[name="telefono"]').val();
    var direccion = "";
    if ($('#recoTienda').prop('checked')) {
        direccion = 'RETIRO';
    } else {
        direccion = $("#direccion").val();
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
	if(codalmm == ''){
			alertify.error('Error interno, porfavor escriba la direccion y de click en mostrar Farmacia cercanas')
	}


    var formData = new FormData();
	formData.append('codalmm', codalmm);
	formData.append('descuento', descuento);
	formData.append('resta', resta);
    formData.append('formapago', formapago);
    formData.append('tipoformapago', tipoformapago);
    formData.append('direccion', direccion);
    formData.append('telefono', telefono);
    formData.append('codpedido', codpedido);
    formData.append('comentario', comentario);
    formData.append('codprom', codpromo);
    formData.append('codtranferencia', codtranferencia);
    formData.append('reftrans', reftrans);


    $('#payu').submit()

    // if (formapago == 1) {
    $('#btnGuardarVenta').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: urlSite + '/clientes/ControladorVenta/guardar',
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data);

            $('[name="formapago"]').val('');
            //$('[name="direccion"]').val('');
            // $('[name="telefono"]').val('');
            $('[name="CodProm"]').val('');
			$('[name="codalmm"]').val('');
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
                            $('#mensaje').val('')
                            $('#btnGuardarVenta').prop('disabled', false);
                           // $('#btnGuardarVenta1').prop('disabled', false);
                            location.href = urlSite + '/clientes/ControladorInicio/'
                        }
                    }
                }
            });
        },
        error: function(e) {
            $.alert({
                title: 'Alerta!',
                content: 'Ocurrio un problema al guardar el pedido.',
            });
        }
    });
   
});

function enviarPayu() {
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
}


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



/* $('.verSliderClick1').click(function() {

    var id = $(this).data('product_code');
    var img = $(this).data('product_code1');
    var nombre = $(this).data('product_code4');
    var valor = $(this).data('product_code5');
    var descripcion = $(this).data('product_code7');
    var dcto = $(this).data('product_code9');
    var preciobase = $(this).data('product_code14');
   

    var enviardcto = dcto;
    
    var descripcion = $(this).data('product_code7');
    var temp = (valor * dcto)/100;
    var enviartemp = temp;

    var valordcto = (valor - temp);

    $("#preciobase").val(preciobase);
    if(dcto != null && dcto != 0){
        $("#undProducto").val(1);
    $("#nombreProducto1").text(nombre);
    $("#nombreProducto2").text(nombre);
    $("#descripcionProducto").text(descripcion);
    $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valordcto));
    $("#idProducto").val(id);
    $("#precioProducto2").val(valordcto);
    $("#urlProducto").attr('src', url + img);

    

    $('#ModalVerProductos').appendTo("body").modal('show');
    }else{
        $("#undProducto").val(1);
    $("#nombreProducto1").text(nombre);
    $("#nombreProducto2").text(nombre);
    $("#descripcionProducto").text(descripcion);
    $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valor));
    $("#idProducto").val(id);
    $("#precioProducto2").val(valor);
    $("#urlProducto").attr('src', url + img);


    $('#ModalVerProductos').appendTo("body").modal('show');
    }
    

});*/

/*
$('.verSliderClick2').click(function() {

    var id = $(this).data('product_code');
    var img = $(this).data('product_code1');
    var nombre = $(this).data('product_code4');
    var valor = $(this).data('product_code5');
    var descripcion = $(this).data('product_code7');
    var dcto = $(this).data('product_code9');
    var temp = (valor * dcto)/100;
    var valordcto = (valor - temp);
    var preciobase = $(this).data('product_code14');

    
        $("#undProducto").val(1);
        $("#nombreProducto1").text(nombre);
        $("#nombreProducto2").text(nombre);
        $("#descripcionProducto").text(descripcion);
        $("#preciobase").val(preciobase);
        if(dcto != null && dcto != 0){
            $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valordcto));
            $("#precioProducto2").val(valordcto);
        }else{
        $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valor));
        $("#precioProducto2").val(valor);
        }
        $("#idProducto").val(id);
        $("#urlProducto").attr('src', url + img);
    
    
        $('#ModalVerProductos').appendTo("body").modal('show');
    
   

});
 */
$('.verSliderClick3').click(function() {
    
    var id = $(this).data('product_code');
    var img = $(this).data('product_code1');
    var nombre = $(this).data('product_code4');
    var valor = $(this).data('product_code5');
    var descripcion = $(this).data('product_code7');
    var dcto = $(this).data('product_code9');
    var temp = (valor * dcto)/100;
    var valordcto = (valor - temp);
    var preciobase = $(this).data('product_code14');
    

   
        $("#undProducto").val(1);
        $("#nombreProducto1").text(nombre);
        $("#nombreProducto2").text(nombre);
        $("#descripcionProducto").text(descripcion);
        $("#preciobase").val(preciobase);
        if(dcto != null && dcto != 0){
        $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valordcto));
        $("#precioProducto2").val(valordcto);
        }else{
        $("#precioProducto").text('$ ' + Intl.NumberFormat('de-DE').format(valor));
        $("#precioProducto2").val(valor);
        }
        $("#idProducto").val(id);
       
        $("#urlProducto").attr('src', url + img);
    
    
        $('#ModalVerProductos').appendTo("body").modal('show');
    

});



