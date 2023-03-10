<?php 
      $sql = $this->db->query('select * from par_personal');
      $result = $sql->result();
      $logo;
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
      $buscar;

      foreach ($result as $key => $value) {
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
          $buscar     = $value->btn_buscar;
      }
       
      ?>
<style>
    .navbar-dark .navbar-nav .nav-link {
    color: #f8f9fa;
}


.af:hover{
        color: white !important;
        background-color:#3498DB ;
    }
    .ai:hover{
        color: white !important;
        background-color:#FF527A;
    }



    @import "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
@import url('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700');

/*body{ font-size: 14px; color: #333; list-style: 26px;font-family: 'Roboto', sans-serif; }*/

/** ======================  base css ==============================**/

a:hover{ text-decoration: none; }
/** ======================  header ==============================**/
.header{ background-color: red  }
.header .dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    border-radius: 0%;
}
.header .user-image {
    float: left;
    width: 25%;
    height: 25%;
    border-radius: 50%;
    margin-right: 10%;
    margin-top: -2%;
}

.header .navbar-light .navbar-nav .nav-link{ color: <?= $colorfont ?> }
.header .navbar-light .navbar-nav .nav-link:hover, .header .navbar-light .navbar-nav .nav-link:focus   {
    
       background: <?= $fondotitle ?>;
    color: <?= $colortitle ?>;
}
.header .fa.fa-fw.fa-bars{ color: <?= $colortitle ?>; }
.header .navbar-light .navbar-nav .nav-link {
    color: <?= $colorfont ?>;
    padding: 10% 20%;
    position: relative;
}
.header  li>a>.label {
    position: absolute;
    top: 9%;
    right: 7%;
    text-align: center;
    font-size: 9%;
    padding: 2% 3%;
    line-height: .9; background-color: #333;    border-radius: .25em;
}
.header  li>a:after{ display: none; }

.header-ul{    border-top-left-radius: 4%;
    border-top-right-radius: 4%;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    background-color: <?= $colorfont ?>;
    padding: 7% 10%;
    border-bottom: 1px solid <?= $border ?>;
    color: <?= $colorfont ?>;
    font-size: 14%;}

    .navbar-nav>.notifications-menu>.dropdown-menu, .navbar-nav>.messages-menu>.dropdown-menu, .navbar-nav>.tasks-menu>.dropdown-menu {
    width: 280%;
    padding: 0 0 0 0;
    margin: 0;
    top: 100%;
}
.navbar-nav>.messages-menu>.dropdown-menu li .menu>li>a>div>img {
    margin: auto 10% auto auto;
    width: 40%;
    height: 40%;
}
.navbar-nav>.messages-menu>.dropdown-menu li .menu>li>a ,.navbar-nav>.notifications-menu>.dropdown-menu li .menu>li>a{
    margin: 0;
    padding: 10% 10%;
        display: block;
    white-space: nowrap;
    border-bottom: 1% solid <?= $border ?>;
}
.navbar-nav>.messages-menu>.dropdown-menu li .menu>li>a>h4 {
    padding: 0;
    margin: 0 0 0 45%;
    color: #333;
    font-size: 15%;
    position: relative;
}
.navbar-nav>.messages-menu>.dropdown-menu li .menu>li>a>p {
    margin: 0 0 0 45%;
    font-size: 12%;
    color: #888888;
}

.footer-ul a{
	border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 4%;
    border-bottom-left-radius: 4%;
    font-size: 12%;
    background-color: <?= $fondotitle ?>;
    padding: 7% 10%;
    border-bottom: 1% solid <?= $border ?>;
    color: <?= $colortitle ?> ; display: block;
    }

      .dropdown-menu-over .menu{  max-height: 200%;
    margin: 0;
    padding: 0;
    list-style: none;
    overflow-x: auto;}

    .navbar-nav>.notifications-menu>.dropdown-menu li .menu>li>a {
    color: #444444;
    overflow: auto;
    text-overflow: ellipsis;
    padding: 10%;
}
.navbar-nav>.notifications-menu>.dropdown-menu li .menu>li>a>.glyphicon, .navbar-nav>.notifications-menu>.dropdown-menu li .menu>li>a>.fa, .navbar-nav>.notifications-menu>.dropdown-menu li .menu>li>a>.ion {
    width: 20%;
}

a.navbar-brand {
    width: 10%;
}


/***    left menu ****/

/***********************  TOP Bar ********************/
.sidebar{ width:30%;   background-color:<?= $fondo ?> ; position: fixed; transition: all 0.5s  ease-in-out; z-index: 100;  }
.bg-defoult{background-color:<?= $fondo ?>;}
.sidebar ul{ list-style:none; margin:0%; padding:0%; }
.sidebar li{ list-style:none; margin:0%; padding:0%; }
.sidebar li a { display:block; padding:4% 8%; color:<?= $colorfont ?>;border-left:0% solid <?= $border?>;  text-decoration:none}
.sidebar li a.collapsed.active{ display:block; padding:4% 8%; color:<?= $colorfont ?>;border-left:0% solid <?= $border?>;  text-decoration:none; }
.sidebar li a.active{background-color: <?= $fondo ?>;border-left:1% solid <?= $border ?>; transition: all 0.5s  ease-in-out; }
.sidebar li a:hover{background-color:<?= $fondotitle ?>!important; color: <?= $colortitle ?>;}
.sidebar li a i{ padding-right:5%;}
.sidebar ul li .sub-menu li a{ position:relative}
.sidebar ul li .sub-menu li a:before{
    font-family: FontAwesome;
    content: "\f105";
    display: inline-block;
    padding-left: 0%;
    padding-right: 1%;
    vertical-align: middle;
}
.sidebar ul li .sub-menu li a:hover:after {
    content: "";
    position: absolute;
    left: -5%;
    top: 0;
    width: 5%;
    background-color: <?= $fondo ?>;
    height: 10%;
}
.sidebar ul li .sub-menu li a:hover{ background-color:#222; padding-left:1%; transition: all 0.5s  ease-in-out}
.sub-menu{ border-left:5% solid <?= $border ?>;}
	.sidebar li a .nav-label,.sidebar li a .nav-label+span{ transition: all 0.5s  ease-in-out}
	

	.sidebar.fliph li a .nav-label,.sidebar.fliph li a .nav-label+span{ display:none;transition: all 0.5s  ease-in-out}
	.sidebar.fliph {
    width: 0%;transition: all 0.5s  ease-in-out;
   
}
	
.sidebar.fliph li{ position:fixed; z-index: 1500;}
.sidebar.fliph .sub-menu {
    position: absolute;
    left: 39%;
    top: 0;
    background-color: #222;
    width: 100%;
    z-index: 100;
}
@media only screen and (max-width: 900px) {
    .sidebar{ width:80%;   background-color:<?= $fondo ?> ; position: fixed; transition: all 0.5s  ease-in-out; z-index: 100;  }
	
}
	@media only screen and (max-width: 1364px) {
    .sidebar{ width:80%;   background-color:<?= $fondo ?> ; position: fixed; transition: all 0.5s  ease-in-out; z-index: 100;  }
		.container{max-width:84%;}
		.carousel-inner{
			width:116.5% !important; 
			height:100% !important; 
			left:-14% !important; 
			top: -13.6px !important; 
			
		}
}
@media only screen and (max-width: 767px) {
    .sidebar{ width:80%;   background-color:<?= $fondo ?> ; position: fixed; transition: all 0.5s  ease-in-out; z-index: 100;  }
		.container{max-width:84%;}
		.carousel-inner{
			width:146.3% !important; 
			height:100% !important; 
			left:-23.1% !important; 
			top: -13.7px !important; 
			
		}
}
@media only screen and (max-width: 671px) {
    .sidebar{ width:80%;   background-color:<?= $fondo ?> ; position: fixed; transition: all 0.5s  ease-in-out; z-index: 100;  }
		.container{max-width:84%;}
		.carousel-inner{
			width:127.8% !important; 
			height:100% !important; 
			left:-14% !important; 
			top: -13.6px !important; 
			
		}
}


	.user-panel {
    clear: left;
    display: block;
    float: left;
}
.user-panel>.image>img {
    width: 10% !important;
    max-width: 20% !important;
    height: auto;
}
.user-panel>.info,  .user-panel>.info>a {
    color: <?= $colorfont ?>;
}
.user-panel>.info>p {
    font-weight: 300;
    margin-bottom: 1%;
}
.user-panel {
    clear: left;
    display: block;
    float: left;
    width: 80%;
    margin-bottom: 5%;
    padding: 1% 1%;
    border-bottom: 1% solid;
}
.user-panel>.info {
    padding: 5% 5% 5% 5%;
    line-height: 1;
    position: absolute;
    left: 0%;
}

.fliph .user-panel{ display: none; }

.main{

    z-index: 3;

}

.scroll_text_menu{
        height:100vh !important;
        overflow:auto;
        padding:0% 0%;
    }

    .scroll_text_menu::-webkit-scrollbar {  
        width: 0%;  
    }  

    .scroll_text_menu::-webkit-scrollbar-track {  
        background-color: #ffffff
    }  
    .scroll_text_menu::-webkit-scrollbar-thumb {  
      background-color: <?= $fondotitle ?> !important;
      border: 1% solid <?= $fondotitle ?> !important;
      border-radius: 5%;
    }  
    
    .scroll_text_menu::-webkit-scrollbar-thumb:hover {  
          -color: #000;  
    }  

</style>

<nav class="navbar navbar-expand-md  fixed-top" style="border-bottom: <?= $border ?> 2px solid; background: white !important;">
      <button class=" btn <?= $buscar ?> abrir-menu"><i class="fa fa-bars"></i></button>
    <a class="navbar-brand" href="<?php echo site_url('page');?>">
        <img src="<?php echo base_url($logo.'')?>" width="140%" height="140%" alt="" loading="lazy">
        
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars" style="color: <?= $colorfont ?>!important;" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse" style="padding-left: inherit; width:100%" id="navbarSupportedContent">
        <div id="Busqueda"class="form-inline" style="padding-left: inherit; ">
            <input class="form-control mr-sm-2" id="busquedaGeneral" type="text" placeholder="Buscar.....">
            <button class="btn <?= $buscar ?> my-2 my-sm-0" id="btnBusquedaGeneral" type="button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
        </div>
      
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
                <a style="color:  <?= $colorfont ?>;" class="nav-link totalPedidosBtn" href="#"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> Mis Compras</a>
                
            </li>
            <li class="nav-item">
                <a class="nav-link totalCarritoBtn" href="#" style="color: <?= $colorfont ?>;"><span style="color:  <?= $colorfont ?>;" class="badge badge-light totalCarrito"></span> <i class="fa fa-list" aria-hidden="true"></i> Pedido</a>
            </li>
            <li class="nav-item dropdown ocul">
                <a class="nav-link dropdown-toggle" style="color: <?= $colorfont ?> !important;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Siguenos
                </a>
                <div class="dropdown-menu" style="background-color: <?= $fondo ?> !important; border: 0px solid!important; " aria-labelledby="navbarDropdown">
                    <a class="dropdown-item af"  style="color: <?= $colorfont ?>;"  href="<?= $facebook ?>" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
                    <a class="dropdown-item ai"  style="color: <?= $colorfont ?>;"  href="<?= $instagram ?>" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a>
               
            </li>

            <?php
                $query = $this->db->query('select * from tbl_usuarios where u_estado = 1 and u_tipo = 2');
                $rest = $query->result();
                $rest2 = false;
                foreach($rest as $rows){
                    if($rows->u_id === $this->session->userdata('id_usuario')){
                        $rest2=true;
                    }
                }
            if( !$rest2){?>
          <li class="nav-item">
                <a class="nav-link " style="color:  <?= $colorfont ?>;"  href="<?php echo site_url('Login/login');?>" tabindex="-1" aria-disabled="true"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar sesion</a>
                <input type="hidden" id="sesion" value="1">
            </li>
            <?php } elseif($rest2){?>
            <li class="nav-item">
                <a class="nav-link " style="color:  <?= $colorfont ?>;"  href="<?php echo site_url('Login/logout');?>" tabindex="-1" aria-disabled="true"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesion</a>
                <input type="hidden" id="sesion" value="0">
            </li>
            <?php }?>
        </ul>
        <input hidden type="time" name="horainicio">
        <input hidden type="time" name="horafin">
  </div>  
</nav>
<br><br><br>



<div class="main">
       
          <div class="sidebar left scroll_text_menu">
            <div class="user-panel" >
                <div class="pull-left image" style="height:50px !important">

                </div>
              <div class="pull-left info  image">
                  <?php 
                  $nit = $this->session->userdata('id_usuario');
                  $consulta2 = $this->db->query("SELECT * FROM tbl_usuarios WHERE u_id = ".$nit);
                  if($consulta2->result()){
                    foreach ($consulta2->result() as $row): 
                  ?>
                <p><?= $row->u_username ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
               <?php 
               endforeach;
                  }else{                  
               ?>
                <p>Visitante</p>
                <a href="#"><i class="fa fa-circle text-warning"></i> Offline</a>
               <?php 
               }
               ?>
              </div>
            </div>
            <div>
            <ul class="list-sidebar bg-defoult">
            <?php $consulta = $this->db->query("SELECT id,codgru,nomgru FROM tbl_categorias WHERE estado = 1");
			$url = site_url('clientes/ControladorInicio/productos');
							 	foreach ($consulta->result() as $row): 
							?>
              <li> 
              <?php $consulta4 = $this->db->query("SELECT * FROM tbl_subcategorias WHERE codgru = ".$row->codgru);
							$url = site_url('clientes/ControladorInicio/productos');
							if(!$consulta4->result()){
                             
							?>
                            <a href="#" onclick="$('#formulariog<?= $row->id; ?>').submit(), $('.sidebar').toggleClass('fliph');" data-toggle="collapse" data-target="#<?= $row->nomgru?>" class="collapsed active" > <span class="nav-label"> <?= $row->nomgru?> </span> <span class="fa fa-chevron-left pull-right"></span> </a>
								<div class="CategoriasVer" data-product_code="<?= $row->id;?>">
								<form action="<?= $url;  ?>" method="post" id="formulariog<?= $row->id; ?>">
                                 <a hidden class="dropdown-item" href="#"><?= $row->nomgru ?></a>
								 <input type="hidden" name="categoria" value="<?= $row->codgru ?>">
								<input type="hidden" name="nombre" value="<?= $row->nomgru ?>">
								</form>
								</div>
							<?php
							}else{
                           
                            ?>
                            <a href="#" data-toggle="collapse" data-target="#grupo<?= $row->codgru?>" class="collapsed active" >  <span class="nav-label"> <?= $row->nomgru?> </span> <span class="fa fa-chevron-left pull-right"></span> </a>
                                <ul class="sub-menu collapse" id="grupo<?= $row->codgru?>">
                            <?php
                            
                            foreach ($consulta4->result() as $row2): 
                            ?>
              

                                
                                    <li class=""><a href="#" onclick="$('#formulario<?= $row2->codsubcate; ?>').submit(), $('.sidebar').toggleClass('fliph');" ><?= $row2->nomsubcate; ?></a>
                                    <form action="<?= $url;  ?>" method="post" id="formulario<?= $row2->codsubcate; ?>">
                                                    <input type="hidden" name="categoria" value="<?= $row->codgru ?>">
                                                    <input type="hidden" name="nombre" value="<?= $row->nomgru ?>">
                                                    <input type="hidden" name="subcategoria" value="<?= $row2->codsubcate ?>">	
                                                    </form>
                                </li>
								 <?php
                             
                                endforeach;
                            }?>
                                </ul>
            </li>
            <?php endforeach;?>
            <li> <a href="#" onclick="return scrollprimario('lonuevo')" > <span class="nav-label">Lo Nuevo</span></a> </li>
            <li> <a href="#" onclick="return scrollprimario('lomasvendido')"> <span class="nav-label">Lo mas vendido</span></a> </li>
            <li> <a href="#" onclick="return scrollprimario('lorecomendado')"> <span class="nav-label">Lo recomendado</span></a> </li>
            
    </ul>
    </div>
    </div>
   
</div>
<!-- PRUEBA --> 

<script>
  var urlBuscarHorario = "<?php echo site_url('administrativo/ControladorUsuarios/gethorario')?>";
    var fecha ="<?php echo date('Y-m-d'); ?>";
    $(document).ready(function(){
        $('.sidebar').toggleClass('fliph');
        $('.abrir-menu').click(function(){
       $('.sidebar').toggleClass('fliph');
      
   });
        establecerhora()

    })

    function scrollprimario(id){
        $('.sidebar').toggleClass('fliph');
        $('html, body').animate({
        scrollTop: $("#"+id).offset().top
        }, 1000);

    }
async function establecerhora(){
     
        await $.ajax({
         type : "POST",
         url  : urlBuscarHorario,
         dataType : "JSON", 
         success: function(data){
            
 
             if( data != false ){
             $('[name="horainicio"]').val(data[0]['horainicio'])
             $('[name="horafin"]').val(data[0]['horafin'])
             
             }
           
         }
     });
     }
</script>





<!---------------------------------------MODAL LOGIN----------------------------------------------->
