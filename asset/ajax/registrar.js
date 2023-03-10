$(document).ready(function(){
    $('#BtnRegistrar').on('click',function(){

        var username    = $('[name="username"]').val();
        var nitter      = $('[name="nitter"]').val();
        var email       = $('[name="email"]').val();
        var password    = $('[name="password"]').val();
        var passwordR   = $('[name="passwordR"]').val();
        var telefono    = $('[name="telefono"]').val();
        var direccion   = $('[name="direccion"]').val();
        var dpto        = $("#dpto option:selected").val();
        var genero       = $("#genero option:selected").val();
        var ciudad      = $("#ciudad option:selected").text();

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
        if(genero=="")
        {
            alertify.error('Seleccione un genero');
            $('[name="genero"]').focus();
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

        if(dpto=="")
        {
            alertify.error('Seleccione un Departamento');
            $('[name="dpto"]').focus();
            return false;
        }
        if(ciudad=="")
        {
            alertify.error('Seleccione una Ciudad');
            $('[name="ciudad"]').focus();
            return false;
        }

        var formData = new FormData();
        formData.append('username',username );
        formData.append('nitter',nitter );
        formData.append('email',email );
        formData.append('password',password );
        formData.append('passwordR',passwordR );
        formData.append('telefono',telefono );
        formData.append('direccion',direccion );
        formData.append('genero', genero);
        formData.append('dpto', dpto);
        formData.append('ciudad', ciudad);

        $.ajax({
            type : "POST",
            url  : urlRegistrar,
            dataType : "JSON",
            data : formData,
            contentType: false,
            processData: false,
            success: function(data){
                if(data==0)
                {
                    alertify
                        .alert("Mensaje!","<h3 class='text-center'>Registro exitoso.</h3>", function(){
                        location.reload();
                    });
                }else{
                    alertify
                        .alert("Mensaje!","<h3 class='text-center'>Este usuario ya se encuentra registrado.</h3>", function(){
                    });
                }
            }
        });
        return false;

    });

});

$('#dpto').change(()=>{
    var formData = new FormData();
    formData.append('coddpto', $("#dpto option:selected").val());
    
    $.ajax({
            type : "POST",
            url  : urlCiudad,
            dataType : "JSON",
            data : formData,
            contentType: false,
            processData: false,
            success: function(data){
                $('#ciudad').html("")
                data.forEach((ciu)=>{
                    $(`<option value="${ciu.codciud}">${ciu.nomciud}</option>`).appendTo('#ciudad')
                })
            }
        });

})