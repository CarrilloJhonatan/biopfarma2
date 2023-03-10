<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Horario de atencion: <?php echo date('d/m/Y') ?></h3>
        <div class="row mt">
          	<div class="col-lg-12">
                <form>
                    <div class="form-group">
                       
                        
                        <label>Hora de apertura</label>
                        <input type="time" class="form-control" name="horainicio">
                        <input type="hidden" class="form-control" name="id" value="<?= $this->session->userdata('id_usuario')?>">
                        
                        
                    </div>

                    <div class="form-group">
                        <label>Hora de cierre</label>
                        <input type="time" class="form-control" name="horafin">
                    </div>

                    <button type="button" class="btn btn-warning fa fa-hdd-o" id="btnGuardarhora"> Guardar</button>
                    <button type="button" class="btn btn-success fa fa-pencil-square-o" id="btnEditarhora"> Editar</button>
                </form>
          	</div>
        </div>
    </section>
      <!-- /wrapper -->
</section>	

<script>
    var urlHorarioAtencion = "<?php echo site_url('administrativo/ControladorUsuarios/horarioguardar')?>";
    var urlBuscarHorario = "<?php echo site_url('administrativo/ControladorUsuarios/gethorario')?>";
    var fecha ="<?php echo date('m-d-Y'); ?>";
    $(document).ready(function(){
    
    establecerhora()
    
    debugger
    if($('[name="horainicio"]').val() != '' ){
      $('#btnEditarhora').show()
      $('#btnGuardarhora').hide()
    }else{
        $('#btnEditarhora').hide()
        $('#btnGuardarhora').show()
    }
});

$('#btnGuardarhora').on('click', function(){

    var formData = new FormData();
    var horainicio = $('[name="horainicio"]').val();
    var horafin = $('[name="horafin"]').val();


    var hora1 = Date.parse('1970-01-01T'+horainicio+'Z');
    var hora2 = Date.parse('1970-01-01T'+horafin+'Z');
    debugger
    console.log(hora2)
    if(hora1 == hora2 || hora2 < hora1){
        alertify.error('Hora de cierre no puede ser menor o igual a la de apertura');
        return false;
    }
    if(horainicio == '' || horafin == ''){
        alertify.error('Llene todas los campos.');
        return false;
    }
    formData.append('horainicio', horainicio);
    formData.append('horafin', horafin);
    $.ajax({
        type : "POST",
        url  : urlHorarioAtencion,
        dataType : "JSON",
        data : formData,
        contentType: false,
        processData: false,
        success: function(data){
            alertify
                .alert("<h3 class='text-center'>Mensaje!</h3>","<h5 class='text-center'>Horario de atencion establecido!.</h5>", function(){
                    
                });

                if($('[name="horainicio"]').val() != '' && $('[name="horafin"]').val() != ''){
                $('[name="horainicio"]').prop('disabled',true);
                $('[name="horafin"]').prop('disabled',true);
                $('#btnEditarhora').show()
                $('#btnGuardarhora').hide()
            }
          
        }
    });


});


    async function establecerhora(){
        debugger
       await $.ajax({
        type : "POST",
        url  : urlBuscarHorario,
        dataType : "JSON", 
        success: function(data){
            debugger
            console.log(data)
            console.log(data[0]["horainicio"])
            console.log(data[0]["horafin"])

            if( data != false ){
            $('[name="horainicio"]').val(data[0]['horainicio'])
            $('[name="horafin"]').val(data[0]['horafin'])
            }

            if($('[name="horainicio"]').val() != '' ){
                $('#btnEditarhora').show()
                $('#btnGuardarhora').hide()
            }else{
                $('#btnEditarhora').hide()
                $('#btnGuardarhora').show()
            }

            if($('[name="horainicio"]').val() != '' && $('[name="horafin"]').val() != ''){
                $('[name="horainicio"]').prop('disabled',true);
                $('[name="horafin"]').prop('disabled',true);
            }
          
        }
    });
    }

    $('#btnEditarhora').on('click', function(){
        $('[name="horainicio"]').prop('disabled',false);
        $('[name="horafin"]').prop('disabled',false);
        $('#btnEditarhora').hide()
        $('#btnGuardarhora').show()
    })
</script>