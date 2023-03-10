$(document).ready(function(){

    $.ajax({
        type : "POST",
        url  : urlPromocionesTabla,
        dataType : "JSON",
        data : {},
        success: function(data){
            table = $('#tablaPromociones').DataTable({
                "data": data,
                "bDestroy": true,
                "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
                "order": [[ 0, "asc" ]],
                "lengthMenu": [ [10, 25, 50, -1], [10,25, 50, "Todo"] ],
                "searching": true,
                "autoWidth": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "initComplete": function () {
                     //Apply text search
                    this.api().columns([3]).every(function () {
                        var title = $(this.footer()).text();
                    
                        $(this.footer()).html('<input type="text" class="form-control "  placeholder="Buscar..." />');
                        var that = this;
                        $('input',this.footer()).on('keyup change', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });

                    });

                   

                    this.api().columns([1,2]).every(function () {
                        var column = this;
                        var select = $('<select class="form-control selectdos" style="width:100%;"><option value="">Todo</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                            .search( val ? '^'+val+'$' : '', true, false)
                            .draw();
                         });

                        column.data().unique().sort().each(function (d,j) {
                            select.append('<option value="'+d+'">'+d+'</option>');
                        });
                    });

                    $('.selectdos').select2();

                },
                "columns": [
                    { "data": null,
                        "mRender": function(data, type, full) {
                           
                            return '<div class=col-md-12 text-center"><img src="'+urlPromocionesblanco  +'/'+full.p_img+'" alt="Imagen del porducto"  class="thumbnail" width="40px" /></div>';
                        }
                    },
                    { "data": "t_nombre"},
                    { "data": "descripcion"},
  
                    { "data": "fecha"},
                ],
                "columnDefs": [
                    {
                        "targets": [0],
                        "className": "text-center"   
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
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
        }
    });

    $('.tbl').change(function(){
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
                    data: function (params) {
                        return {
                            searchTerm: params.term, // search term
                            elegido: val
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
            }
        });

    });

    $('#btnCreaPromociones').on('click',function(){

        $('[name="id"]').val(0);
        $('[name="urlimg"]').val('');
        $('[name="tbl"]').append($('<option>', {
            val: '',
            text:'',
            selected: true
        }));
        $('[name="elegido"]').append($('<option>', {
            val: '',
            text:'',
            selected: true
        }));
      
    
       
        $("#btnEliminarPromociones").addClass("invisible");
    
        $('#exampleModal').appendTo("body").modal('show');
    });

    $('#btnGuardarPromociones').on('click',function(){

        var id           =  $('[name="id"]').val();
        var urlimg       =  $('[name="urlimg"]').val();
        var tbl          =  $('[name="tbl"]').val();
        var elegido      =  $('[name="elegido"]').val();
        
    
        if(tbl=="")
        {
            alertify.error('Seleccione la tabla');
            return false;
        }
    
        if(elegido=="")
        {
            alertify.error('Seleccione la descripcion');
            return false;
        }
    
       
        var formData = new FormData();
        var files =   $('#image')[0].files[0];
    
       
        if(files==undefined)
        {
            alertify.error('Seleccione una imagen para la promocion');
            return false;
        }
    
        formData.append('file',files);
        formData.append('id',id );
        formData.append('urlimg',urlimg );
        formData.append('tbl',tbl );
        formData.append('elegido',elegido );
        
       
        $.ajax({
            type : "POST",
            url  : urlPromocionesGuardar,
            dataType : "JSON",
            data : formData,
            contentType: false,
            processData: false,
            success: function(data){
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>","<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function(){
                    location.reload();
                });
             }
        });
        return false;
    });

    $('#tablaPromociones tbody').on('click','tr',function() {
       
        var data = table.row( $(this) ).data();
    
        var id              = data.p_id  ;
        var urlimg          = data.p_img;
        var tbl             = data.p_tbl;
        var tblnombre       = data.t_nombre;
        var elegido         = data.p_elegido;
        var elegidonombre   = data.descripcion;
       
        
       
       
        $('[name="id"]').val(id);
        $('[name="urlimg"]').val(urlimg);
        
      
        $('[name="tbl"]').append($('<option>', {
            val: tbl,
            text:tblnombre,
            selected: true
        }));

        $('[name="elegido"]').append($('<option>', {
            val: elegido,
            text:elegidonombre,
            selected: true
        }));
    
        $("#btnEliminarPromociones").removeClass("invisible");
       
        $('#exampleModal').appendTo("body").modal('show');
    });

    $('#btnEliminarPromociones').on('click',function(){

        var id = $('[name="id"]').val();
    
        var formData = new FormData();
        formData.append('id',id );
        if(id == 9){
            alertify.alert('<h3 class="text-center fa fa-trash-o"> Error</h3>', '<h6 class="text-center">Esta vista no puede ser eliminada</h6>');

        }else if(id == 10){
            alertify.alert('<h3 class="text-center fa fa-trash-o"> Error</h3>', '<h6 class="text-center">Esta vista no puede ser eliminada</h6>');

        }   else if(id ==11 ){
            alertify.alert('<h3 class="text-center fa fa-trash-o"> Error</h3>', '<h6 class="text-center">Esta vista no puede ser eliminada</h6>');
        } else {
            alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar este item</h6>', function(){ 
    
                $.ajax({
                    type : "POST",
                    url  :  urlPromocionesEliminar ,
                    dataType : "JSON",
                    data : formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        location.reload();
                    }
                });
        }
        , function(){ alertify.error('Operacion Cancelada')});
    
}
});

});
