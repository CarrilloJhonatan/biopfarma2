$('#btnGuardarPass').on('click',function(){

    var id          = $('[name="id"]').val();
    var password    = $('[name="password"]').val();
    var passwordR   = $('[name="passwordR"]').val();

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

    var formData = new FormData();
    formData.append('id',id );
    formData.append('password',password );
    formData.append('passwordR',passwordR );

    $.ajax({
        type : "POST",
        url  : urlUsuarioGuardarPass,
        dataType : "JSON",
        data : formData,
        contentType: false,
        processData: false,
        success: function(data){
            alertify
                .alert("<h3 class='text-center'>Mensaje!</h3>","<h5 class='text-center'>Contraseña modificada.</h5>", function(){
                    location.reload();
                });
          
        }
    });
    return false;
});