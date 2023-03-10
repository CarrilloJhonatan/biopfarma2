<div class = "container pt-5">
    <br>    
	<div>
	    <input type="hidden" value="<?=  $this->session->userdata('id_usuario');?>" id="id_usuario">
		<div>
			<a href="<?= site_url('app/ControladorInicio'); ?>" class="btn btn-outline-danger my-2 my-sm-0" id="btnAtras" ><i class="fa fa-hand-o-left" aria-hidden="true"></i> Volver a Categorias</a>
	        <hr>
			<button class="btn btn-warning flotante totalCarritoBtn" style="color:white !important;">
				<span class="badge badge-danger totalCarrito"></span> 
				<i class="fa fa-list" aria-hidden="true"></i>
			</button>
		</div>
		<div class="row">
	        <div class="col-12" id="contenidoSub">
	            <h1 class="text-center pb-2"><strong><?= $result2; ?></strong></h1>
	            <input type="hidden" id="codgru" value="<?= $result; ?>">
	            <div class="row">
					<?php
						if($result == null){
							$rest = $this->db->query("SELECT * FROM tbl_subcategorias");
						}else{
							$rest = $this->db->query("SELECT * FROM tbl_subcategorias where codgru =".$result);
						}
		                
		                foreach ($rest->result() as $row):
		            ?>
		                <div class="col-4 subcategoriasVer" data-product_code="<?= $row->codsubcate?>" data-product_code1="<?= $row->nomsubcate?>">
							<form action="<?= site_url('app/ControladorInicio/productos') ?>" method="post" id="formulario<?= $row->codsubcate ?>">
							<div class="product_featured_tile"> 

								<span class="product_title text-center">
									<strong><?= $row->nomsubcate ?></strong>
									<span class="product_cat" style="font-size: 2vh;">
										UA Select FG
										<input hidden name="categoria" value="<?= $row->codgru ?>">
										<input hidden name="subcategoria" value="<?= $row->codsubcate ?>">
		                                <input hidden name="nomsubcategoria" value="<?= $result2 ?>">
		                                <input hidden name="numfila" id="numfila" value="<?= $rest->num_rows(); ?>">
									</span>
								</span>  
								<span class="product_price">
								</span> 
							</div>
							</form>
						</div>
	             	<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

<!-- Modal -->
	<div class="modal" id="verModalCarrito" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Lista de pedidos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row align-content-center">	
						<div class="col-6">
						<h5><label>#Pedido: </label> <span id="codigoped"></span></h5>
						</div>
				</div>

				<div class="table-responsive">
					<table class="table" id="tablaCarrito">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Und</th>
                                <th>Total</th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="row pl-4">
                        <label>Domicilio: $<span id="domicilio"></span></label> 
                        </div>
                        <div class="row pl-4">
                        <label>Subtotal: $<span id="subtotal"></span></label> 
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <div class="row pl-4">
                        <h4>Total: $<span id="sumTotalCarrito"></span></h4>
                        </div>
                        <hr>
<div class="section" style="padding-bottom:20px;">
							<h6 class="title-attr"><small>COMENTARIO</small></h6>
							<textarea class="form-control" style="resize: none;" name="comentarioCarrito1" id="comentarioCarrito1" cols="10" rows="3"></textarea>                   
						</div>
					</div>
				</div>
				<div class="row align-content-center">
					<div class="col-md-2"></div>
					<div class="col-md-4 mt-2">
                        <button data-dismiss="modal" class="btn btn-block btn-outline-info pull-right"  type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Agregar mas articulos</button>
                    </div>
					<div class="col-md-4 mt-2">
						<button class="btn btn-block btn-outline-danger pull-right" id="btnComprar" type="button"><i class="fa fa-check-square-o" aria-hidden="true"></i> Pedir</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">

			</div>
			</div>
		</div>
	</div>

<!-- Modal -->
<div class="modal" id="verModalPedido" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header text-center">
				<h5 class="modal-title text-center"><i class="fa fa-list" aria-hidden="true"></i> Mis pedidos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" id="tablapedidos">
                        <thead>
                            <tr>
								<th>fecha</th>
                                <th>pedido</th>
								<th>articulos</th>
                                <th>Valor</th>
                                <th>estado</th>
                            </tr>
                        </thead>
                        <tbody>							
                        </tbody>
                    </table>
                </div>
			</div>
			<div class="modal-footer">

			</div>
			</div>
		</div>
	</div>
	
	<!-- Modal de pago -->
	<div class="modal fade bd-example-modal-lg" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg">
    		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-product-hunt" aria-hidden="true"></i> Pedir</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<input type="hidden" id="comentarioPedido1">
						<div class="col-md-12 product_content">
							<div class="form-group">
								<label>Elije forma de pago</label>
								<select name="formapago" class="form-control">
								<option disabled selected>Selecciona un medio de pago</option>
								<option value="EF">EFECTIVO</option>
									<option value="CR">CREDITO</option>
									<option value="TC">T. CREDITO </option>
									<option value="TD">T. DEBITO</option>
								</select>
							</div>
							
							<hr>
							<div class="form-group">
								<label>¿Donde desea recibir el pedido?</label>
								<br>
								<input type="checkbox" id="recoTienda"> <label>Recoger en tienda</label>
								<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion de domicilio..." value="<?= $this->session->userdata('direccion');?>">
							</div>
							<hr>

							<div class="form-group">
								<label>Telefono de contacto</label>
								<input type="number" class="form-control" name="telefono" placeholder="Telefono de contacto..." value="<?= $this->session->userdata('telefono');?>">
							</div>
							
							<div class="form-group">
								<label>Codigo promocional</label>
								<input type="text" class="form-control" name="CodProm" id="CodProm" placeholder="Codigo de descuento..." value="">
							</div>
							
							
               			</div>
					</div>
				</div>
				<div class="modal-footer">

					
					<div class="invisible">
						<form >
							
							<script
								src="https://checkout.epayco.co/checkout.js"
								class="epayco-button"
								data-epayco-key="491d6a0b6e992cf924edd8d3d088aff1"
								data-epayco-amount="50200"
								data-epayco-name="Vestido Mujer Primavera"
								data-epayco-description="Holis"
								data-epayco-currency="cop"
								data-epayco-country="co"
								data-epayco-test="true"
								data-epayco-external="false"
								data-epayco-response="https://tualiadotae.com/appecommerce/index.php/page"
								data-epayco-confirmation="https://ejemplo.com/confirmacion">
							</script>
						</form>
					</div>	
					
					<button type="button" class="btn btn-success" id="btnGuardarVenta">Guardar</button>
					
					<button type="button" class="btn btn-danger" data-dismiss="modal" >Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
    var urlProductos = '<?= site_url('app/ControladorInicio/productos') ?>';
    var urlCategorias = '<?= site_url('app/ControladorInicio/') ?>';

		var urlInicio  			= "<?php echo site_url('app/ControladorInicio/todo')?>";
		var url  				= "<?php echo base_url('')?>";
		var urlGuardarCarrito  	= "<?php echo site_url('app/ControladorCarrito/guardar')?>";
		var urlTotalCarrito  	= "<?php echo site_url('app/ControladorCarrito/total')?>";
		var urlTodoCarrito  	= "<?php echo site_url('app/ControladorCarrito/todo')?>";
		var urleliminarCarrito  = "<?php echo site_url('app/ControladorCarrito/eliminar')?>";

		var urlTodoMispedidos  	= "<?php echo site_url('app/ControladorMispedidos/todo')?>";
		var urlTodoArticulosp  	= "<?php echo site_url('app/ControladorMispedidos/articulos')?>";
		var urlSubcategorias	= "<?= site_url('app/ControladorInicio/subcategorias'); ?>"
		var urlSite  			= "<?php echo site_url('')?>";
		var IniciarSesion		= "<?php echo site_url('Login/login') ?>";
		var urlVerificarCod 	= "<?php echo site_url('app/ControladorInicio/verificarcodprom')?>";
	</script>

<script src="<?php echo base_url('asset/app/ajax/principal/subcategorias.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/app/ajax/principal/categorias.js')?>" type="text/javascript"></script>
