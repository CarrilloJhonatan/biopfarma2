<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="<?php echo base_url('asset/administrativo/img/favicon.ico')?>" rel="icon">


	  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('asset/clientes/css/bootstrap.min.css') ?>">
    <!-- AWESOME4 -->
    <link rel="stylesheet" href="<?php echo base_url('asset/clientes/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <link href="<?php echo base_url('asset/administrativo/css/alertify.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/administrativo/css/themes/semantic.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('asset/clientes/css/styles.css') ?>">
    <link href="<?php echo base_url('asset/administrativo/css/dataTables.bootstrap4.min.css');?>" rel="stylesheet">
    <title>Biopharma Virtual</title>
    <script src="<?php echo base_url('asset/administrativo/lib/jquery/jquery.min.js')?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  </head>
  <style>
  .table tfoot input{
        width: 100% !important;
    }
    .table tfoot {
        display: table-header-group !important;
    }
    .scroll_text{
        height:20%;
        overflow:auto;
        padding:0% 15%;
    }

    .scroll_text::-webkit-scrollbar {  
        width: 8%;  
    }  

    .scroll_text::-webkit-scrollbar-track {  
        background-color: #ffffff
    }  
    .scroll_text::-webkit-scrollbar-thumb {  
      background-color: #224F22;
      border: 1% solid #224F22;
      border-radius: 10%;
    }  
    .scroll_text::-webkit-scrollbar-thumb:hover {  
          -color: #000;  
    }  

    .scroll_text2{
        height:450%;
        overflow:auto;
        padding:0% 15%;
    }

    .scroll_text2::-webkit-scrollbar {  
        width: 8%;  
    }  
    .scroll_text2::-webkit-scrollbar-track {  
        background-color: #ffffff
    }  
    .scroll_text2::-webkit-scrollbar-thumb {  
        background-color: #224F22;
        border: 1% solid #224F22;
        border-radius: 10%;
    }  
    .scroll_text2::-webkit-scrollbar-thumb:hover {  
        background-color: #000;  
    }

    
</style>
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
  <body style="background-color: <?= $fondo ?> !important">
  

  