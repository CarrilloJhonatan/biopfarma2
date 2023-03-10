
<link rel="stylesheet" href="<?php echo base_url('asset/clientes/css/card.css')?>">
  <!-- Owl-carousel CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="container">
<?php 
$url= site_url('clientes/ControladorInicio/');
$mensaje = 'Volver';
?>
<form action="<?= $url; ?>" method="post">
    	<input type="hidden" value="<?= $result ;?>"  name="categoria"	id="categoriaPost">
    	<input type="hidden" value="<?= $result2 ;?>" id="subcategoria">
    	<input type="hidden" value="<?= $result5 ;?>" name="nombre"	id="nombrePost">
    	<input type="hidden" value="<?= $result3 ;?>" 	id="input_tbl">
    	<input type="hidden" value="<?= $result4 ;?>" 	id="input_elegido">
    	<input type="hidden" value="<?= $result6 ;?>" 	id="numfila">
    	<input type="hidden" value="<?= $result7 ;?>" 	id="codpedido">
    	<input type="hidden" value="<?=  $this->session->userdata('id_usuario');?>" id="id_usuario">
    	<div>
    		<button class="btn btn-outline-danger my-2 my-sm-0" id="btnAtras" ><i class="fa fa-hand-o-left" aria-hidden="true"></i> <?= $mensaje; ?></button>
    	</div>
	</form>

    <input type="hidden" value="<?=  $this->session->userdata('id_usuario');?>" id="id_usuario">
    
<div class="row" id="contenido">


</div>
<div class="row" id="paginacion"></div>

	
</div>

<script>
		var urlInicio  			= "<?php echo site_url('clientes/ControladorInicio/todo')?>";
		var url  				= "<?php echo base_url('')?>";
		var urlGuardarCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/guardar')?>";
		var urlTotalCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/total')?>";
		var urlTodoCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/todo')?>";
		var urleliminarCarrito  = "<?php echo site_url('clientes/ControladorCarrito/eliminar')?>";
		var urlSlaider  		= "<?php echo site_url('clientes/ControladorInicio/slaider')?>";
		var urlSlaiderProducto1 = "<?php echo site_url('clientes/ControladorCarrito/slaiderproducto1')?>";
		var urlCargarpedido 	= "<?php echo site_url('app/ControladorInicio/cargarpedido')?>";
		var urlSite  			= "<?php echo site_url('')?>";
		var urlTodoMispedidos  	= "<?php echo site_url('clientes/ControladorInicio/miscompras')?>";
		var urlTodoArticulosp  	= "<?php echo site_url('clientes/ControladorInicio/articulosp')?>";
		var IniciarSession 		= "<?php echo site_url('Login/login');?>"
		var urlVerificarCod 	= "<?php echo site_url('clientes/ControladorInicio/verificarcodprom')?>";
		var urlcargarValores 	= "<?php echo site_url('clientes/ControladorInicio/cargarvalores')?>";

	</script>
	<script src="<?php echo base_url('asset/clientes/ajax/principal/categorias.js')?>" type="text/javascript"></script>