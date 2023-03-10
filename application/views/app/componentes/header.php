<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('asset/app/css/bootstrap.min.css') ?>">
    <!-- AWESOME4 -->
    <link rel="stylesheet" href="<?php echo base_url('asset/app/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <link href="<?php echo base_url('asset/administrativo/css/alertify.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/administrativo/css/themes/semantic.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('asset/app/css/styles.css') ?>">
    <link href="<?php echo base_url('asset/administrativo/css/dataTables.bootstrap4.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/app/css/card.css');?>" rel="stylesheet">
    <title>ECOMMERCE</title>
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
        height:200px;
        overflow:auto;
        padding:0px 15px;
    }

    .scroll_text::-webkit-scrollbar {  
        width: 8px;  
    }  

    .scroll_text::-webkit-scrollbar-track {  
        background-color: #ffffff
    }  
    .scroll_text::-webkit-scrollbar-thumb {  
      background-color: #e23232 !important;
      border: 1px solid #e23232 !important;
      border-radius: 10px;
    }  
    .scroll_text::-webkit-scrollbar-thumb:hover {  
          -color: #000;  
    }  

    .scroll_text2{
        height:450px;
        overflow:auto;
        padding:0px 15px;
    }

    .scroll_text2::-webkit-scrollbar {  
        width: 8px;  
    }  
    .scroll_text2::-webkit-scrollbar-track {  
        background-color: #ffffff
    }  
    .scroll_text2::-webkit-scrollbar-thumb {  
        background-color: #e23232 !important;
        border: 1px solid #e23232 !important;
        border-radius: 10px;
    }  
    .scroll_text2::-webkit-scrollbar-thumb:hover {  
        background-color: #000;  
    }

    
</style>
  <body>

  <?php // LimpiarCache::clearCache('300'); ?>
  

  