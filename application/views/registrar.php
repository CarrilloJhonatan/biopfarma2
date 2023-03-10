
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
      }
       
      ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>ECOMMERCE</title>

  <!-- Favicons -->
  <link href="<?php echo base_url('asset/administrativo/img/favicon.png')?>" rel="icon">
  
  <link href="<?php echo base_url('asset/administrativo/img/apple-touch-icon.png')?>" rel="apple-touch-icon">
  
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('asset/administrativo/lib/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  
  <!--external css-->
  <link href="<?php echo base_url('asset/administrativo/lib/font-awesome/css/font-awesome.css')?>" rel="stylesheet" />
  
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url('asset/administrativo/css/style.css')?>" rel="stylesheet">
  
  <link href="<?php echo base_url('asset/administrativo/css/style-responsive.css')?>" rel="stylesheet">

  <link href="<?php echo base_url('asset/administrativo/css/alertify.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/administrativo/css/themes/semantic.css');?>" rel="stylesheet">
  
  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->

  <style>

      .corporativorojo{
        background-color:  #e23232 !important;
          color: white !important;
      }
    

  </style>
</head>

<body style="background-color: #F9FAFA;">
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <?php LimpiarCache::clearCache('300'); ?>
    <div id="login-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="<?php echo base_url($logo)?>" style="margin-top: 4vh" class="img-fluid" width="200">
                </div>
            </div>
            <div class="row">
                <h4><i class="fa fa-angle-right"></i> Formulario de registro</h4>
                <div class="form-panel">
                    <div class="form">
                        <form class="cmxform form-horizontal style-form" id="signupForm" method="get" action="">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Nombres</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" name="username" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">Numero de identificacion</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" name="nitter" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">Genero</label>
                                <div class="col-lg-10">
                                <select name="genero" id="genero" class="form-control">
                                    <option value=""selected disabled>Seleccione un genero</option>
                                    <option value="1">Masculino </option>
                                    <option value="2">Femenino </option>
                                    <option value="0">No quiero especificar </option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">Correo electronico</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="email" type="email" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">Contraseña</label>
                                <div class="col-lg-10">
                                    <input class="form-control " name="password" type="password" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="confirm_password" class="control-label col-lg-2">Confirmar Contraseña</label>
                                <div class="col-lg-10">
                                <input class="form-control " name="passwordR" type="password" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Telefono</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="telefono" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-lg-2">Departamento</label>
                            <div class="col-lg-10">
                            
								<select name="dpto" id="dpto" class="form-control">
                                <option value=""  checked>Selecione un Departamento</option>

                                <?php 
      $sql = $this->db->query('select * from tbl_dpto');
      $resultp = $sql->result();
                                if( $resultp != null){

                                   foreach ($resultp as $key => $value) {
                                ?>
                                <option value="<?= $value->coddpto ?>"><?= $value->nomdpto ?></option>

                                <?php 
                                }   
                                }
                                ?>
                                </select>
                                </div>
                            </div>
							<div class ="form-group" >
                            <label class="control-label col-lg-2">Ciudad</label>
                            <div class="col-lg-10">
                                <select name="ciudad" id="ciudad" class="form-control"></select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Direccion</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="direccion" type="text" />
                                </div>
                            </div>
                           
								
								
								
								
                            <div class="form-group row">
                              <div class="col-md-3"></div>
                                <div class="col-md-6 text-center">
                                    <button type="button" style="margin-right: 1vh;" class="btn btn-success col-md-4" id="BtnRegistrar">Registrarse</button>
                                    <a class="btn btn-danger corporativorojo col-md-4" href="<?php echo site_url('ControladorIniciarsesion');?>">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('asset/administrativo/lib/jquery/jquery.min.js')?>"></script>
    
    <script src="<?php echo base_url('asset/administrativo/lib/bootstrap/js/bootstrap.min.js')?>"></script>
    
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo base_url('asset/administrativo/lib/jquery.backstretch.min.js')?>"></script>
    <!--ALERTIFY-->
    <script src="<?php echo base_url('asset/administrativo/lib/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('asset/administrativo/js/alertify.js');?>"></script>	
    <script>
    var UrlCargarDpto     	= "<?php echo site_url('app/ControladorInicio/getDpto')?>";
		var UrlCargarCiudad     = "<?php echo site_url('app/ControladorInicio/getCiudad')?>";
        var urlRegistrar = "<?php echo site_url('ControladorRegistrar/guardar')?>";
        var urlCiudad = "<?php echo site_url('ControladorRegistrar/getCiudad')?>";
    </script>
    <script src="<?php echo base_url('asset/ajax/registrar.js');?>"></script>
	
      
</body>
</html>