
<?php 
      $sql = $this->db->query('select * from par_personal');
      $resultp = $sql->result();
      $logo;
      $logo2;
      $fondo;
      $colorfont;
      $colortitle;
      $fondotitle;
      $facebook;
      $instagram;
      $whatsapp;
      $btn;
      $card;
      $border;
      $perfil;
      foreach ($resultp as $key => $value) {
          $logo = $value->url_logo;
          $fondo = $value->color_fondo;
          $colorfont = $value->color_font;
          $colortitle = $value->color_title;
          $fondotitle = $value->fondo_title;
          $facebook   = $value->red_face;
          $instagram  = $value->red_inst;
          $whatsapp   = $value->red_what;
          $btn        = $value->btn_boots;
          $card       = $value->card_boots;
          $border     = $value->bordes_color;
          $logo2      = $value->url_logo2;
          $perfil     = $value->url_perfil;
      }
       
      ?>

  <style>
   /* 
.a:hover{
      background-color:  #e23232 !important;
      
    }

    .active{
      background-color:  #e23232 !important;
      
    }
    */

    .btn-file {
  position: relative;
  overflow: hidden;
  }
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
  
  </style>
  
  <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg" style="border-bottom: 2px solid <?= $border ?> !important">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="<?php echo site_url('administrativo/ControladorPedidos');?>" class="logo">
        <img src="<?php echo base_url($logo)?>"  width="90" height="50">
      </a>
      <!--logo end-->
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- settings start -->
         <!-- <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-tasks"></i>
              <span class="badge bg-theme">400</span>
              </a>
            <ul class="dropdown-menu extended tasks-bar">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">You have 4 pending tasks</p>
              </li>
              <li>
                <a href="index.html#">
                  <div class="task-info">
                    <div class="desc">Dashio Admin Panel</div>
                    <div class="percent">40%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                      <span class="sr-only">40% Complete (success)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="index.html#">
                  <div class="task-info">
                    <div class="desc">Database Update</div>
                    <div class="percent">60%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                      <span class="sr-only">60% Complete (warning)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="index.html#">
                  <div class="task-info">
                    <div class="desc">Product Development</div>
                    <div class="percent">80%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                      <span class="sr-only">80% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="index.html#">
                  <div class="task-info">
                    <div class="desc">Payments Sent</div>
                    <div class="percent">70%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                      <span class="sr-only">70% Complete (Important)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li class="external">
                <a href="#">See All Tasks</a>
              </li>
            </ul>
          </li> -->
          <!-- settings end -->
          <!-- inbox dropdown start-->
         <!-- <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-theme">5</span>
              </a>
            <ul class="dropdown-menu extended inbox">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">You have 5 new messages</p>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="<?php echo base_url('asset/administrativo/img/ui-zac.jpg')?>"></span>
                 
                  <span class="subject">
                  <span class="from">Zac Snider</span>
                  <span class="time">Just now</span>
                  </span>
                  <span class="message">
                  Hi mate, how is everything?
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="<?php echo base_url('asset/administrativo/img/ui-divya.jpg')?>"></span>
                  
                  <span class="subject">
                  <span class="from">Divya Manian</span>
                  <span class="time">40 mins.</span>
                  </span>
                  <span class="message">
                  Hi, I need your help with this.
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="<?php echo base_url('asset/administrativo/img/ui-danro.jpg')?>"></span>
                
                  <span class="subject">
                  <span class="from">Dan Rogers</span>
                  <span class="time">2 hrs.</span>
                  </span>
                  <span class="message">
                  Love your new Dashboard.
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="<?php echo base_url('asset/administrativo/img/ui-sherman.jpg')?>"></span>
                  
                  <span class="subject">
                  <span class="from">Dj Sherman</span>
                  <span class="time">4 hrs.</span>
                  </span>
                  <span class="message">
                  Please, answer asap.
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">See all messages</a>
              </li>
            </ul>
          </li> -->
          <!-- inbox dropdown end -->  
        
          <!-- notification dropdown start-->
          <li id="header_notification_bar" class="dropdown">
            <a class="dropdown-toggle" style="color:red" href="<?php echo site_url('administrativo/ControladorUsuarios/pass');?>">
              <i class="fa fa-unlock-alt"></i> Cambiar Contraseña
            </a>
          </li>
        <!--  notification end -->
      </div>
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
        
          <li><a class="logout" href="<?php echo site_url('Login/logout');?>">Cerrar sesion</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse" style="border-right: 2px solid <?= $border ?> !important" >
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a><img src="<?php echo base_url($perfil)?>" class="img-circle" width="150vh" height="150vh"></a></p>
          <h5 class="centered" style="color: black"><?php echo $this->session->userdata('nombre_usuario');?></h5>
          <li class="mt">
            <a class="a" href="<?php echo site_url('Page');?>">
              <i style="color: black" class="fa fa-dashboard"></i>
              <span style="color: black">Principal </span>
              </a>
          </li>
          <li hidden class="">
            <a class="a" href="<?php echo site_url('administrativo/ControladorUsuarios/servicio');?>">
            <i style="color: black" class="fa fa-heart" aria-hidden="true"></i>
              <span style="color: black" >Calificacion servicio.</span>
              </a>
              </li>
        <!--  <li>
            <a href="<?php echo site_url('administrativo/ControladorSincronizar');?>">
              <i class="fa fa-refresh"></i>
              <span>Sincronizar articulos</span>
              </a>
          </li> -->
          <li class="sub-menu">
            <a class="a" href="javascript:;">
              <i style="color: black" class="fa fa-list"></i>
              <span style="color: black">Inventario</span>
            </a>
            <ul class="sub">
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorCategorias');?>">Categoria</a></li>
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorLineas');?>">SubCategoria</a></li>
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorArticulos');?>">Articulos</a></li>
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorPedidos');?>">Pedidos</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a class="a" href="javascript:;">
              <i style="color: black" class="fa fa-list"></i>
              <span style="color: black">Promociones</span>
            </a>
            <ul class="sub">
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorPromociones');?>">Publicidad y Banners</a></li>
              <li><a class="a" style="color: black" href="<?php echo site_url('administrativo/ControladorPromo');?>">Promociones</a></li>

        
            </ul>
          </li>
       <li>
          <a class="a" href="javascript:;">
          <i style="color: black"  class="fa fa-refresh"></i>
              <span style="color: black">Sincronizaciones.</span>
            </a>
              <ul class="sub">
              <li class="">
          <a class="a" id="sincronizar"> 
              <span style="color: black" >Sincronizar articulos</span>
              </a>
          </li>
          <li class="">
          <a class="a" id="sincroPromociones"> 
              <span style="color: black" >Sincronizar promociones</span>
              </a>
          </li>
          <li class="">
          <a class="a" id="sincrOtros"> 
              <span style="color: black" >Sincronizar otros</span>
              </a>
          </li>
              </ul>
          <li class="">
            <a class="a" href="<?php echo site_url('administrativo/ControladorUsuarios');?>">
              <i style="color: black"  class="fa fa-user-circle-o"></i>
              <span style="color: black" >Usuarios </span>
              </a>
          </li>
          <li class="">
            <a class="a" href="<?php echo site_url('administrativo/ControladorUsuarios/horario');?>">
            <i  style="color: black" class="fa fa-clock-o" aria-hidden="true"></i>
              <span style="color: black" >Horario de atencion </span>
              </a>
          </li>
          <li class="">
            <a class="a" href="<?php echo site_url('administrativo/ControladorUsuarios/pass');?>">
              <i style="color: black"  class="fa fa-unlock-alt"></i>
              <span style="color: black" >Cambiar Contraseña </span>
              </a>
              </li>
              <li hidden class="">
              <a class="a" id="cargarMenu">
              <i style="color: black" class="fa fa-upload" aria-hidden="true"></i>
              <span style="color: black" >Cargar menu. </span>
              </a>
              </li>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>

    <div class="modal fade" id="Modalcargar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #e23232 !important">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-upload" aria-hidden="true"></i> Cargar Menu</h4>
        </div>
        <div class="modal-body">
        <form>
            <div class="form-group">
              <br>
                <h4>Seleccione el menu</h4>
                <br>
                <label>Nombre de archivo:</label>
                <div class="row">
                  <div class="col-sm-6">
                    <input disabled type="text" id="nomArchivo" placeholder="Seleccione un pdf. "class="form-control">
                  </div>
                  <div class="col-sm-6">
                  <span class="btn btn-default btn-file">
                  <i class="fa fa-folder-open-o" aria-hidden="true"></i> Explorar <input id="menu" type="file" accept=".pdf">
                </span>
                  </div>

                </div>
                
            </div>
            <hr>
            <div class="form-group">
            <input hidden type="text" id="url">
              <a class="btn btn-primary" id="descargar" target="_blank">
              <i class="fa fa-download" aria-hidden="true"></i> Descargar Menu.
              </a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
        <button type="button" class="btn btn-success fa fa-hdd-o" id="GuardarArch"> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS------------------------------------------------------->

    <script>

    var urlCategoriasSincro     = "<?php echo site_url('administrativo/ControladorCategorias/sincroCategorias')?>";
    var urlArticulosSincro     = "<?php echo site_url('administrativo/ControladorArticulos/sincroArticulos')?>";
    var urlPromociones     = "<?php echo site_url('administrativo/ControladorArticulos/sincropromos')?>";
    var urldetPromociones     = "<?php echo site_url('administrativo/ControladorArticulos/sincrodetPromo')?>";
    var urlOtrosSincro     = "<?php echo site_url('administrativo/ControladorArticulos/sincroOtros')?>";
    var urlVariantesSincro     = "<?php echo site_url('administrativo/ControladorArticulos/sincroVariantes')?>";
    var urlSubcateSincro     = "<?php echo site_url('administrativo/ControladorLineas/sincroSubcategorias')?>";

    var urlGuardarMenu     = "<?php echo site_url('administrativo/ControladorArticulos/menu')?>";
    var urlGetMenu         = "<?php echo site_url('administrativo/ControladorArticulos/getmenu')?>"
    var url                = "<?php echo base_url()?>" ;

      $(document).ready(function(){
        
        cargarArchivo()
      })


      function cargarArchivo(){
        
        $.ajax({
        type: "POST",
        url: urlGetMenu,
        dataType: "JSON",
        data: {},
        contentType: false,
        processData: false,
        success: function(data) {
         
          if(data == '0'){
            $('#descargar').hide()
          }else{
            $('#descargar').show()
            $('#nomArchivo').val(data[0]['nomarchivo'])
            $('#url').val(url+data[0]['urlarchivo'])
            $('#descargar').prop('href',url+data[0]['urlarchivo'])
          }

           
        }
      });
    }

    $('#GuardarArch').click(function(){
    var formData = new FormData();
    var files = $('#menu')[0].files[0];
    var validar = $('#nomArchivo').val();
    var nombre = document.getElementById('menu').files[0].name;
    formData.append('file', files);
    formData.append('nombre', nombre);
    if (nombre == ""){
      alertify.error('Seleccione un Archivo.');
      return false
    }
    if(validar == 'FORMATO NO PERMITIDO.'){
      alertify.error('Seleccione formato permitido (PDF).');
      return false
    }
    $.ajax({
        type: "POST",
        url: urlGuardarMenu,
        dataType: "JSON",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {

            if (data != 0) {
                alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Esta accion fue guardada exitosamente.</h5>", function() {
                        location.reload();
                    });
            } 
        }
    });
      })

        $('#sincronizar').click(async function(){
          await cantidadArticulos();

          // await sincronizarCategorias();
          await sincronizarSubcategorias();
          await sincronizarArticulos();
          await sincronizarVariantes();
          
        })

        $('#sincroPromociones').click(async function(){
          await sincroPromociones();
          await sincroDetPromociones();
          
        })

        $('#menu').change(function(){
          var nombre = document.getElementById('menu').files[0].name;
          var extension = nombre.substring(nombre.lastIndexOf("."));
          if(extension != ".PDF" && extension != ".pdf"){
            $('#nomArchivo').val('FORMATO NO PERMITIDO.')
            alertify.error('Formato de archivo no permitido.');
            $('#menu').val('')
          }else{
            
            $('#nomArchivo').val(nombre)
          }
            
        })

        $('#sincrOtros').click(async function(){
          await sincronizarOtros()
          
        })
        $('#cargarMenu').click( function(){
         
          $('#Modalcargar').appendTo("body").modal('show')
          
        })


    /*     async function sincronizarCategorias(){          
          $('#main-content').waitMe({
           
              effect: 'stretch',
              text: 'Sincronizando...',
              bg: '#797979',
              color: '#FFFFFF'
          }); 
          cantt = window.prompt("Ingrese la cantidad de articulos para agregar");

       var parametros ={
          "cantidadArticulos" : parseInt(cantt)
        };

          await $.ajax({
            data: parametros,
            type: "POST",
            url: urlCategoriasSincro,
            contentType: false,
            processData: false,
            success: function(data) {
                var resultado = JSON.parse(data)
                if (resultado['respuesta'] === true) {

                  alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se actualizaron "+resultado['contador']+" categorias.</h5>", function() {
                        $('#main-content').waitMe("hide");
                        location.reload()
                    });
                    
                    
                } else {

                  alertify
                    .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se encontraron categorias nuevas.</h5>", function() {

                        
                        $('#main-content').waitMe("hide");
                        location.reload()
                    });
                    
                }
            }
        });

        } */

        async function sincronizarOtros(){

$('#main-content').waitMe({

    effect: 'stretch',
    text: 'Sincronizando...',
    bg: '#797979',
    color: '#FFFFFF'
}); 

await $.ajax({
  type: "POST",
  url: urlOtrosSincro,
  contentType: false,
  processData: false,
  success: function(data) {
      res = parseInt(data);
     
      if ( res == 3) {

        alertify
          .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Formas de pago y valores de domicilio sincronizadas.</h5>", function() {
              $('#main-content').waitMe("hide");
              location.reload()
          });
          
          
      } 
      if ( res > 0 && res < 3) {

alertify
  .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Sincronizacion incompleta</h5>", function() {
      $('#main-content').waitMe("hide");
      location.reload()
  });
  
  
} 
      
      if( res == 0) {

        alertify
          .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se encontraron registros nuevos.</h5>", function() {

              
              $('#main-content').waitMe("hide");
              location.reload()
          });
          
      }
  }
});

}

        async function sincronizarSubcategorias(){

           $('#main-content').waitMe({

               effect: 'stretch',
               text: 'Sincronizando...',
               bg: '#797979',
               color: '#FFFFFF'
              }); 

            await  $.ajax({
                type: "POST",
                url: urlSubcateSincro,
                contentType: false,
                processData: false,
                success: function(data) {
                    var resultado = JSON.parse(data)
                    if (resultado['respuesta'] === true) {

                     alertify
                       .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se      actualizaron "+resultado['contador']+" Subcategorias.</h5>", function() {
                            $('#main-content').waitMe("hide");
                            location.reload()
                        });
                        
          
                    } else {

                      alertify
                        .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se      encontraron Subcategorias nuevas.</h5>", function() {

                            
                            $('#main-content').waitMe("hide");
                            location.reload()
                        });
                        
                    }
          }
              });

}

async function sincronizarArticulos(){

$('#main-content').waitMe({

    effect: 'stretch',
    text: 'Sincronizando...',
    bg: '#797979',
    color: '#FFFFFF'
   }); 

  await $.ajax({
     type: "POST",
     url: urlArticulosSincro,
     contentType: false,
     processData: false,
     success: function(data) {
         var resultado = JSON.parse(data)
         if (resultado['respuesta'] === true) {

          alertify
            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se      actualizaron "+resultado['contador']+" Articulos.</h5>", function() {
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             

         } else {

           alertify
             .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se      encontraron Articulos nuevos.</h5>", function() {

                 
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             
         }
}
   });

}

async function sincronizarVariantes(){

$('#main-content').waitMe({

    effect: 'stretch',
    text: 'Sincronizando...',
    bg: '#797979',
    color: '#FFFFFF'
   }); 

  await $.ajax({
     type: "POST",
     url: urlVariantesSincro,
     contentType: false,
     processData: false,
     success: function(data) {
         var resultado = JSON.parse(data)
         if (resultado['respuesta'] === true) {

          alertify
            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se      actualizaron " +resultado['contador'] +" Variantes de articulos.</h5>", function() {
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             

         } else {

           alertify
             .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se      encontraron Variantes de articulos nuevas.</h5>", function() {

                
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
            
         }
}
   });

}


  async function cantidadArticulos(){
    cantt = window.prompt("Ingrese la cantidad de articulos para agregar");

       var parametros ={
          "cantidadArticulos" : parseInt(cantt)
        };

        await $.ajax({
          data: parametros,
          type: "POST",
          url: urlCategoriasSincro ,
          
          success: function(data) {
            console.log("Hola")
          }
      });


}
async function sincroPromociones(){
debugger
$('#main-content').waitMe({

    effect: 'stretch',
    text: 'Sincronizando...',
    bg: '#797979',
    color: '#FFFFFF'
   }); 

  await $.ajax({
     type: "POST",
     url: urlPromociones,
     contentType: false,
     processData: false,
     success: function(data) {
         var resultado = JSON.parse(data)
         if (resultado['respuesta'] === true) {

          alertify
            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se      actualizaron "+resultado['contador']+" Promociones.</h5>", function() {
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             

         } else {

           alertify
             .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se      encontraron Promociones nuevas.</h5>", function() {

                 
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             
         }
}
   });

}
async function sincroDetPromociones(){
debugger
$('#main-content').waitMe({

    effect: 'stretch',
    text: 'Sincronizando...',
    bg: '#797979',
    color: '#FFFFFF'
   }); 

  await $.ajax({
     type: "POST",
     url: urldetPromociones,
     contentType: false,
     processData: false,
     success: function(data) {
         var resultado = JSON.parse(data)
         if (resultado['respuesta'] === true) {

          alertify
            .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>Se      actualizaron "+resultado['contador']+" Articulos Promocionales.</h5>", function() {
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             

         } else {

           alertify
             .alert("<h3 class='text-center'>Mensaje!</h3>", "<h5 class='text-center'>No se      encontraron articulos promocionales nuevas.</h5>", function() {

                 
                 $('#main-content').waitMe("hide");
                 location.reload()
             });
             
         }
}
   });

}




    </script>
 