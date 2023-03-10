$(document).ready(function(){

    $.ajax({
        type : "POST",
        url  : urlUsuarioTabla,
        dataType : "JSON",
        data : {},
        success: function(data){
            table = $('#tablaUsuarios').DataTable({
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
                    this.api().columns([0,1,2]).every(function () {
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

                    this.api().columns([4]).every(function () {
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

                    });

                    this.api().columns([3]).every(function () {
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
                    { "data": "u_nitter"}, 
                    { "data": "u_username"},
                    { "data": "u_usuario"},
                    { "data": "tipo"},
                    { "data": "fecha"},
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

$('.usuarioTipo').select2({
    dropdownParent: $('#exampleModal'),
    placeholder: 'Selecciona un tipo de usuario',
    allowClear: true,
    width: '100%',
    ajax: {
            type: "post",
            url: urlUsuarioTipo,
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

$('#btnCreaUsuario').on('click',function(){

    $('[name="usuarioId"]').val(0);
    $('[name="username"]').val('');
    $('[name="usuarioUser"]').val('');
    $('[name="nitter"]').val('');
    $('[name="email"]').val('');
    $('[name="usuarioTipo"]').append($('<option>', {
        val: '',
        text:'',
        selected: true
    }));
    $('[name="password"]').val('');
    $('[name="passwordR"]').val('');
    $('[name="telefono"]').val('');
    $('[name="direccion"]').val('');

    $('[name="usuarioTipo"]').prop( "disabled", false );
    $('[name="password"]').prop( "disabled", false );
    $('[name="passwordR"]').prop( "disabled", false );
    $('[name="usuarioUser"]').prop( "disabled", false );
    $('[name="nitter"]').prop( "disabled", false );

    $("#btnEliminarUsuario").addClass("invisible");

    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnGuardarUsuario').on('click',function(){

    var id          = $('[name="usuarioId"]').val();
    var username    = $('[name="username"]').val();
    var nitter      = $('[name="nitter"]').val();
    var usuarioUser = $('[name="usuarioUser"]').val();
    var tipo        = $('[name="usuarioTipo"]').val();
    var email       = $('[name="email"]').val();
    var password    = $('[name="password"]').val();
    var passwordR   = $('[name="passwordR"]').val();
    var telefono    = $('[name="telefono"]').val();
    var direccion   = $('[name="direccion"]').val();

    if(username=="")
    {
        alertify.error('Digite el Nombre completo');
        $('[name="username"]').focus();
        return false;
    }

    if(nitter=="")
    {
        alertify.error('Digite el Numero de identificacion');
        $('[name="nitter"]').focus();
        return false;
    }

    if(email=="")
    {
        alertify.error('Digite el Correo electronico');
        $('[name="email"]').focus();
        return false;
    }

    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if(!regex.test($('[name="email"]').val().trim())){
        alertify.error('Digite un correo valido');
        $('[name="email"]').focus();
        return false;
    }

    if(usuarioUser=="")
    {
        alertify.error('Digite el usuario');
        $('[name="usuarioUser"]').focus();
        return false;
    }

    if(tipo=="")
    {
        alertify.error('Digite el tipo de usuario');
        $('[name="usuarioTipo"]').focus();
        return false;
    }

    if(password=="")
    {
        alertify.error('Digite la Contraseña');
        $('[name="password"]').focus();
        return false;
    }

    if(passwordR=="")
    {
        alertify.error('Digite Repetir Contraseña');
        $('[name="passwordR"]').focus();
        return false;
    }

    if(password != passwordR)
    {
        alertify.error('Contraseña no coinciden');
        return false;
    }

    if(telefono=="")
    {
        alertify.error('Digite el Telefono');
        $('[name="telefono"]').focus();
        return false;
    }

    if(direccion=="")
    {
        alertify.error('Digite la Direccion');
        $('[name="direccion"]').focus();
        return false;
    }

    var formData = new FormData();
    formData.append('id',id );
    formData.append('username',username );
    formData.append('tipo',tipo );
    formData.append('nitter',nitter );
    formData.append('usuarioUser',usuarioUser );
    formData.append('email',email );
    formData.append('password',password );
    formData.append('passwordR',passwordR );
    formData.append('telefono',telefono );
    formData.append('direccion',direccion );

    $.ajax({
        type : "POST",
        url  : urlUsuarioGuardar,
        dataType : "JSON",
        data : formData,
        contentType: false,
        processData: false,
        success: function(data){
            
            if(data==0)
            {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>","<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function(){
                    location.reload();
                });
            }else{
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>","<h5 class='text-center'>Este usuario ya se encuentra registrado.</h5>", function(){
                });
            }
         }
    });
    return false;
});

$('#tablaUsuarios tbody').on('click','tr',function() {
       
    var data = table.row( $(this) ).data();

    var id = data.u_id ;
    var nombre = data.u_username;
    var identificacion = data.u_nitter;
    var correo = data.u_email;
    var usuario = data.u_usuario;
    var tipo = data.u_tipo	;
    var tiponombre = data.tipo;
    var pass = data.u_password;
    var telefono = data.u_telefono;
    var direccion = data.u_direccion;
   
    $('[name="usuarioId"]').val(id);
    $('[name="username"]').val(nombre);
    $('[name="nitter"]').val(identificacion);
    $('[name="nitter"]').prop( "disabled", true );
    $('[name="email"]').val(correo);
    $('[name="usuarioUser"]').val(usuario);
    $('[name="usuarioUser"]').prop( "disabled", true );
    $('[name="usuarioTipo"]').append($('<option>', {
        val: tipo,
        text:tiponombre,
        selected: true
    }));
    $('[name="usuarioTipo"]').prop( "disabled", true );
    $('[name="password"]').prop( "disabled", true );
    $('[name="passwordR"]').prop( "disabled", true );
    $('[name="password"]').val(pass);
    $('[name="passwordR"]').val(pass);
    $('[name="telefono"]').val(telefono);
    $('[name="direccion"]').val(direccion);


    $("#btnEliminarUsuario").removeClass("invisible");
   
    $('#exampleModal').appendTo("body").modal('show');
});

$('#btnEliminarUsuario').on('click',function(){

    var id = $('[name="usuarioId"]').val();
    var nombre = $('[name="username"]').val();

    var formData = new FormData();
    formData.append('id',id );
    formData.append('nombre',nombre );
   
    alertify.confirm('<h3 class="text-center fa fa-trash-o"> Eliminar</h3>', '<h6 class="text-center">Deseas eliminar a '+nombre+'</h6>', function(){ 

            $.ajax({
                type : "POST",
                url  :  urlUsuarioEliminar ,
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
});