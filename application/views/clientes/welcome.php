<?php
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
	$codpedido = substr(str_shuffle($permitted_chars), 0, 13);
	$mensaje = "";
	$mediopago = "";
	$tipomediopago = "";
	$codtranferencia = "";
	$reftrans = "";
	if(isset($_GET['lapTransactionState'])){
		$mensaje = $_GET['lapTransactionState'];
	}
	if(isset($_GET['lapPaymentMethod'])){
		$mediopago = $_GET['lapPaymentMethod'];
	}
	if(isset($_GET['lapPaymentMethodType'])){
		$tipomediopago = $_GET['lapPaymentMethodType'];
	}
	if(isset($_GET['transactionId'])){
		$codtranferencia = $_GET['transactionId'];
	}
	if(isset($_GET['reference_pol'])){
		$reftrans = $_GET['reference_pol'];
	}

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

<link rel="stylesheet" href="<?php echo base_url('asset/clientes/css/card.css')?>">
  
<!-- Owl-carousel CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWYq2HjKlnk64_g_wRKkAs0461FuLKY64&libraries=places&callback=initMap&v=weekly" defer></script>
    


<!-- CARROSEL Y LO NUEVO -->
<div class="container" id="cuerpo">
	<input type="hidden" value="<?=  $this->session->userdata('id_usuario');?>" id="id_usuario">
	<input type="hidden" value="<?= $codpedido ;?>" 	id="codpedido">
	<input type="hidden" value="<?= $mensaje ;?>" 	id="mensaje">
	<input type="hidden" value="<?= $mediopago ;?>" 	id="mediopago">
	<input type="hidden" value="<?= $tipomediopago ;?>" 	id="tipomediopago">
	<input type="hidden" value="<?= $codtranferencia ;?>" 	id="codtranferencia">
	<input type="hidden" value="<?= $reftrans;?>" 	id="reftrans">

		<!-- CARROUSEL -->			

	<div class="row">
	  <div class="col-sm">
			<div id="carouselExampleIndicators" class="carousel  slide" data-ride="carousel">
				
				<?php 
				$rest1 = $this->db->query("SELECT * FROM tbl_promociones WHERE p_estado = 1");
				$active='';
				?>
				
				<ol class="carousel-indicators">
					<?php 
					foreach ($rest1->result()as $row1):
						if($row1->p_id  == 1){$active = 'active';}else{$active='';}
					?>
					<li data-target="#carouselExampleIndicators" data-slide-to="<?= $row1->p_id;?>" class="<?= $active?>"></li>	
					<?php endforeach; ?>
				</ol>
				<div class="carousel-inner" id="carousel-innner" style="height:100%; width: 121.7%; left:-11%; top:-11px;">
				<?php 
					$cont = 1;
					foreach ($rest1->result()as $row1):

						if($cont == 1){$active = 'active';}else{$active='';}
					?>
					<div class="carousel-item <?= $active?>">
						<form action="<?= site_url('app/ControladorInicio/productos') ?>" method="post" id="carousel<?= $row1->p_id ?>">
						<img class="d-block w-100 buscarSlider"  src="<?= base_url('').$row1->p_img?>" alt="First slide"
								data-product_code   =   "<?=$row1->p_id?>">
							<input type="hidden" name="input_tbl" value="<?= $row1->p_tbl ?>">
							<input type="hidden" name="input_elegido" value="<?= $row1->p_elegido ?>">
						</form>
						<div class="carousel-caption d-none d-md-block">
						<h5></h5>
						<p></p>
					</div>
				</div>
				<?php
				$cont++;
				endforeach; ?>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only ">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon text-dark" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	  </div>
	</div>

		<!-- PRODUCTOS NUEVOS -->			
		<br>
	<div class="row">
		<div class="col-sm">
			
			<div class="row align-items-center" style="border-radius: 15px; background-color: <?= $fondotitle ?>">
			<h3 id="lonuevo" class="col-lg-12" style="color: <?= $colortitle ?> !important">LO NUEVO</h3>
			</div>
			<hr>
			<div class="items">
				
				<?php 	

					
					

					$this->db->select('*');
					$this->db->from('tbl_articulos');
					$this->db->where('estado',1);
					$this->db->where('tipopromo',2);
					
					$rest1=$this->db->get(); 
					foreach ($rest1->result()as $row1): 
						$preciobase = $row1 -> valart;
						$iva = $row1 -> iva;
						if($iva != 0){
						$preciotemp = ($preciobase*$iva)/100;
						$preciofinal = $preciobase + $preciotemp;
						}else{
							$preciofinal = $preciobase;
						}
						
				?>
				
					<div>
					<div class="owl-item <?= $card ?>" style="height:100%; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);">
									<div class="bbb_viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
										<div class="bbb_viewed_image" style="box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);"><img src="<?= base_url('').$row1->imageurl?>" alt=""></div>
										<div class="bbb_viewed_content text-center">
											<div class="bbb_viewed_price text-success" style="color:<?= $border ?> !important">$<label style="color:<?= $border ?> !important"><?= number_format($row1->valart); ?></label></div>
											<div class="bbb_viewed_name"><?=  substr($row1->nomart,0,100); ?></div>
											<br>
											<button type="button" class="verSliderClick3 <?= $buscar ?> btn fa fa-search" 
												data-product_code="<?=$row1->codart?>"
												data-product_code1="<?=$row1->imageurl?>"
												data-product_code4="<?=$row1->nomart?>"
												data-product_code5="<?=$preciofinal?>"
												data-product_code7="<?=$row1->descripcion?>"
												data-product_code14="<?=$row1->valart?>"
												
												"> Ver</button>
										</div>
										<ul class="item_marks ">
									
											<li class="item_mark item_discount" style="color:<?= $border ?> !important"></li>
											<li class="item_mark item_new" style="background:<?= $border ?> !important">Nuevo</li>
										</ul>
										
									</div>
								</div>
						</div>
												
					
									
						
				<?php endforeach;?>
			</div>
		</div>
	</div>





<!-- PROMOCIONES -->
<div class="row">
		<div class="col-sm">
			
			<div class="row align-items-center" style="border-radius: 15px; background-color: <?= $fondotitle ?>">
			<h3 id="lonuevo" class="col-lg-12" style="color: <?= $colortitle ?> !important">PROMOCIONES</h3>
			</div>
			<hr>
			<div class="items">
				
				<?php 	

					$fechaactual = date('Y-m-d');
					

					$this->db->select('*');
					$this->db->from('headpromo h');
					$this->db->join('detpromo p', 'h.numero  = p.numero and h.codcto = p.codcto');
					$this->db->join('tbl_articulos a', 'a.codart = p.codart and a.tipopromo = 5 and a.estado =1');
					$this->db->where('h.fecha2 >= ',$fechaactual);
					
					$rest4=$this->db->get(); 
					foreach ($rest4->result()as $row4): 
						$dcto = $row4->dcto;
						$paga = $row4->paga;
						$lleva =$row4->lleva;
						$preciobase = $row4 -> valart;
						$iva = $row4 -> iva;
						if($iva != 0){
						$preciotemp = ($preciobase*$iva)/100;
						$preciofinal = $preciobase + $preciotemp;
						}else{
							$preciofinal = $preciobase;
						}
						
				?>
				
					
					<div class="owl-item <?= $card ?>" style="height:100%; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);">
					
					<div class="promocion"
									 style="   background-color: initial;background-repeat: no-repeat;background-size: contain;width: 4rem;
										height: 4rem;
										position: fixed;
										z-index: 1;
										">
										<img style="width:60% ;" src="https://biopharmaciavirtual.com.co/img/icono_descuento.svg">
										<?php if($dcto != null && $dcto != 0){?>
										<span class="spampromo"
										style=" top: -4px!important;
										color: #fff;
										font-weight: 600;
										overflow: hidden;
										text-align: center;
										margin: 0.5rem auto 0;
										align-items: center;
										height: 100%;
										font-size: 1.2rem;
										position: absolute;
										transform: translate(-50%);
										left: 30%;"
										><?=$row4->dcto?></span>
									</div> 
									<?php }else if($dcto == 0 && $paga != 0 && $lleva != 0  ){ ?>
										<span class="spampromo"
										style=" top: -4px!important;
										color: #fff;
										font-weight: 600;
										overflow: hidden;
										text-align: center;
										margin: 0.5rem auto 0;
										align-items: center;
										height: 100%;
										font-size: 0.9rem;
										position: absolute;
										transform: translate(-50%);
										left: 30%;"
										><?=$paga?>x<?=$lleva?></span>
									</div> 
										<?php }?>
									<div class="bbb_viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
									
									<div class="bbb_viewed_image" style="box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);"><img src="<?= base_url('').$row4->imageurl?>" alt=""></div>
										<div class="bbb_viewed_content text-center">
											<div class="bbb_viewed_price text-success" style="color:<?= $border ?> !important">$<label style="color:<?= $border ?> !important"><?= number_format($preciofinal); ?></label></div>
											<div class="bbb_viewed_name"><?=  substr($row4->nomart,0,100); ?></div>
											<br>
											<button type="button" class="verSliderClick3 <?= $buscar ?> btn fa fa-search" 
												data-product_code="<?=$row4->codart?>"
												data-product_code1="<?=$row4->imageurl?>"
												data-product_code4="<?=$row4->nomart?>"
												data-product_code5="<?=$preciofinal?>"
												data-product_code7="<?=$row4->descripcion?>"
												data-product_code9="<?=$row4->dcto?>"
												data-product_code14="<?=$row4->valart?>"
												"> Ver</button>
										</div>
										
									</div>
								
						</div>
												
					
									
						
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>


<div id="imagen1" style="position:static;">
	<?php 
	$conexion = new mysqli("a2nlmysql33plsk.secureserver.net:3306", "prueba1", "prueba123", "appecomerce") or die("not connected".mysqli_connect_error());

	$sql = "SELECT `p_img` FROM `tbl_promociones` WHERE `p_id`=20;";

	$img = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

	while($fila=mysqli_fetch_array($img)){


	?>
	<section  class="parallax-content">	
		<div id="container1" style="  filter: brightness(0.6)">
			<img src=<?= base_url('').$fila['p_img']?> style="width:100%; left:-11%">
		
		</div>

	</section>
	<?php 
	}
	?>
</div>


<!-- MAS VENDIDOS -->			
<br>
<div class="container" id="cuerpo">
	
	<div class="row" style="border-radius: 15px; background-color: <?= $fondotitle ?>">
			<h3 id="lomasvendido" class="col-lg-12"  style="color: <?= $colortitle ?> !important">LO MAS VENDIDO</h3>
	</div>			
			
			<hr>
			<div class="items">
				<?php 	
				$this->db->select('*');
				$this->db->from('tbl_articulos');
				$this->db->where('estado',1);
				$this->db->where('tipopromo',4);
					
					
					$rest2=$this->db->get(); 
					foreach ($rest2->result()as $row2): 
						$preciobase = $row2 -> valart;
						$iva = $row2 -> iva;
						if($iva != 0){
						$preciotemp = ($preciobase*$iva)/100;
						$preciofinal = $preciobase + $preciotemp;
						}else{
							$preciofinal = $preciobase;
						}

				?>
					<div>	
					<div class="owl-item" style="height:100%;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);">			
					<div class="bbb_viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
									
									<div class="bbb_viewed_image" style="box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);"><img src="<?= base_url('').$row2->imageurl?>" alt=""></div>
										
										<div class="bbb_viewed_content text-center">
											<div class="bbb_viewed_price text-success"><label style="color:<?= $border ?> !important">$<?= number_format($row2->valart); ?></label></div>
											<div class="bbb_viewed_name"><?=  substr($row2->nomart,0,100); ?></div>
											
											<br>
											<button type="button" class="verSliderClick3 <?= $buscar ?>  btn  fa fa-search" 
												data-product_code="<?=$row2->codart?>"
												data-product_code1="<?=$row2->imageurl?>"
												data-product_code4="<?=$row2->nomart?>"
												data-product_code5="<?=$preciofinal?>"
												data-product_code7="<?=$row2->descripcion?>"
												data-product_code14="<?=$row2->valart?>"
												
												"> Ver</button>
										</div>
										<ul class="item_marks">
											<li class="item_mark item_discount"></li>
											<li class="item_mark item_new" style="background:<?= $border ?>" ><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></li>

					
										</ul>
									</div>
								</div>
						</div>
						
				<?php endforeach;?>
			</div>					
</div>

<div id="imagen2" style="position:static;">
	<?php 
	$conexion = new mysqli("a2nlmysql33plsk.secureserver.net:3306", "prueba1", "prueba123", "appecomerce") or die("not connected".mysqli_connect_error());

	$sql = "SELECT `p_img` FROM `tbl_promociones` WHERE `p_id`=21;";

	$img = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

	while($fila=mysqli_fetch_array($img)){


	?>
	<section  class="parallax-content">	
		<div id="container1" style="  filter: brightness(0.6)">
			<img src=<?= base_url('').$fila['p_img']?> style="width:100%; left:-11%">
		
		</div>

	</section>
	<?php 
	}
	?>
</div>

<!--RECOMENDADOS -->			
<br>	
<div class="container" id="cuerpo">	
		<div class="row" style="border-radius: 15px; background-color: <?= $fondotitle ?>">
			<h3 id="lorecomendado" class="col-lg-12" style="color: <?= $colortitle ?> !important">LOS RECOMENDADOS</h3>
		</div>			
	
		<hr>
		<div class="items">
			<?php 	
						$this->db->select('*');
						$this->db->from('tbl_articulos');
						$this->db->where('estado',1);
						$this->db->where('tipopromo',3);
							
				$rest3=$this->db->get(); 
				
				foreach ($rest3->result()as $row3): 
					$preciobase = $row3 -> valart;
						$iva = $row3 -> iva;
						if($iva != 0){
						$preciotemp = ($preciobase*$iva)/100;
						$preciofinal = $preciobase + $preciotemp;
						}else{
							$preciofinal = $preciobase;
						}

					
			?>
			
			

				<div>
				<div class="owl-item" style="height:100%;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);">
                                <div class="bbb_viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="bbb_viewed_image" style="box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);"><img src="<?= base_url('').$row3->imageurl?>" alt=""></div>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price text-success"><label style="color:<?= $border ?> !important">$<?= number_format($row3->valart); ?></label></div>
                                        <div class="bbb_viewed_name"><?=  substr($row3->nomart,0,100); ?></div>
										<br>
										<button type="button" class="verSliderClick3 btn <?= $buscar ?>  fa fa-search" 
											data-product_code="<?=$row3->codart?>"
											data-product_code1="<?=$row3->imageurl?>"
											data-product_code4="<?=$row3->nomart?>"
											data-product_code5="<?=$preciofinal?>"
											data-product_code7="<?=$row3->descripcion?>"
											data-product_code14="<?=$row3->valart?>"
											
											"> Ver</button>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount"></li>
										<li class="item_mark item_new" style="background:<?= $border ?>" ><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></li>

									</ul>
                                </div>
                            </div>
					
			<?php endforeach;?>
		</div>
</div>

<div id="imagen3" style="position:static;">
	<?php 
	$conexion = new mysqli("a2nlmysql33plsk.secureserver.net:3306", "prueba1", "prueba123", "appecomerce") or die("not connected".mysqli_connect_error());

	$sql = "SELECT `p_img` FROM `tbl_promociones` WHERE `p_id`=22;";

	$img = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

	while($fila=mysqli_fetch_array($img)){


	?>
	<section  class="parallax-content">	
		<div id="container1" style="  filter: brightness(0.6)">
			<img src=<?= base_url('').$fila['p_img']?> style="width:100%; left:-11%">
		
		</div>

	</section>
	<?php 
	}
	?>
</div>

<!--TODOS LOS ARTICULOS -->
<br>
<div class="container" id="cuerpo">
	<class="row" style="border-radius: 15%; background-color: <?= $fondotitle ?>">
		<h3 id="todos" class="col-lg-12" style="color: <?= $colortitle ?> !important">TODOS LOS ARTICULOS</h3>
	<hr>

	<br><br>
	<style>
			.page-item.active .page-link {
				z-index: 3;
				color: #fff;
				background-color: #21D192;
				border-color: #21D192;
			}
			.page-link{
				color: #21D192;
			}
			
		</style>

	<div class="row mt-5" id="contenido"></div>
	<div class="row" id="paginacion">
		
		
</div>
	
</div>

</div>



<script>

	
		var urlInicio  			= "<?php echo site_url('clientes/ControladorInicio/todo')?>";
		var urlBuscar  			= "<?php echo site_url('clientes/ControladorInicio/')?>"	;
		var url  				= "<?php echo base_url('')?>";
		var urlGuardarCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/guardar')?>";
		var urlTotalCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/total')?>";
		var urlTodoCarrito  	= "<?php echo site_url('clientes/ControladorCarrito/todo')?>";
		var urleliminarCarrito  = "<?php echo site_url('clientes/ControladorCarrito/eliminar')?>";
		var urlSlaider  		= "<?php echo site_url('clientes/ControladorInicio/slaider')?>";
		var urlSlaiderProducto1 = "<?php echo site_url('clientes/ControladorCarrito/slaiderproducto1')?>";
		var urlCargarpedido 	= "<?php echo site_url('app/ControladorInicio/cargarpedido')?>";
		var urlTodoMispedidos  	= "<?php echo site_url('clientes/ControladorInicio/miscompras')?>";
		var urlTodoArticulosp  	= "<?php echo site_url('clientes/ControladorInicio/articulosp')?>";
		var urlSite  			= "<?php echo site_url('')?>";
		var IniciarSession 		= "<?php echo site_url('Login/login');?>"
		var urlVerificarCod 	= "<?php echo site_url('clientes/ControladorInicio/verificarcodprom')?>";
		var urlcargarValores 	= "<?php echo site_url('clientes/ControladorInicio/cargarvalores')?>";
		var urlPromociones = '<?php  echo site_url('administrativo/ControladorArticulos/sincropromos')  ?> '
	</script>
	<script src="<?php echo base_url('asset/clientes/ajax/principal/principal.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('asset/clientes/ajax/principal/index.js')?>" type="text/javascript"></script>
