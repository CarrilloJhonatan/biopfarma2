
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
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
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
  
  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->

  <style>
      .headlog{
          background-color: #e23232 !important;
      }
  </style>
</head>

<body style="background-color: #F9FAFA;">
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <?php
    LimpiarCache::clearCache('300');
   
?>
    <div id="login-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="<?php echo base_url($logo2)?>" style="margin-top: 10vh;" class="img-fluid" width="200">
                </div>
            </div>
            <form class="form-login" style="margin-top: 5vh !important;" action="<?php echo site_url('Login/auth');?>" method="post">
                    <div>
                        <input type="text" class="form-control" name="email" placeholder="Correo electronico" autofocus required>
                        <br>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                        <br>
                        <button class="btn btn-danger headlog btn-block" type="submit"><i class="fa fa-lock "></i> Ingresar</button>
                        <hr>
                        <div class="login-social-link centered">
                            <a class="btn btn-danger headlog" href="<?php echo site_url('ControladorRegistrar');?>"><i class="fa fa-address-book"></i> Registrarse</a>
                            <a class="btn btn-danger headlog" href="<?php echo site_url('ControladorPassword');?>"><i class="fa fa-unlock-alt"></i> Olvide mi contraseña</a>
                                
                                <hr>
                            <?php echo $this->session->flashdata('msg');?>
                        </div>
                    </div>
            </form>

            
      <?php 
      ;
      //echo ApiRest::requestAPIproductos(100)?>
        </div>
    </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="<?php echo base_url('asset/administrativo/lib/jquery/jquery.min.js')?>"></script>
  
  <script src="<?php echo base_url('asset/administrativo/lib/bootstrap/js/bootstrap.min.js')?>"></script>
    
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="<?php echo base_url('asset/administrativo/lib/jquery.backstretch.min.js')?>"></script>
  
</body>
</html>
