<div class="vertical-menu scroll_text" style="height: 80%;" hidden>
  		<a class="active">Categorias</a>
		  <a href="<?php echo base_url().'#lonuevo';?>" onclick="; $('.vertical-menu').fadeOut(); $('.vertical-menu').prop('hidden', true) ">Lo nuevo</a>
		  <a href="<?php echo base_url().'#lomasvendido';?>" onclick="; $('.vertical-menu').fadeOut(); $('.vertical-menu').prop('hidden', true)">Lo mas vendido</a>
		  <a href="<?php echo base_url().'#lorecomendado';?>" onclick="; $('.vertical-menu').fadeOut(); $('.vertical-menu').prop('hidden', true)">Los recomendados</a>
		  <ul class="navbar-nav ml-auto">
            <?php $consulta = $this->db->query("SELECT id,codgru,nomgru FROM tbl_categorias WHERE estado = 1");
			$url = site_url('clientes/ControladorInicio/productos');
							 	foreach ($consulta->result() as $row): 
							?>
							<li class="nav-item">
                            <div class="dropdown">
							
							
                            <a class="dropdown-toggle" style="font-size: 11pt;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $row->nomgru?>
                            </a>

                            <div class="dropdown-menu" style="width: 100%;" aria-labelledby="dropdownMenuButton">
							<?php $consulta4 = $this->db->query("SELECT * FROM tbl_subcategorias WHERE codgru = ".$row->codgru);
							$url = site_url('clientes/ControladorInicio/productos');
							if(!$consulta4->result()){
							?>
								<div class="CategoriasVer" data-product_code="<?= $row->id;?>">
								<form action="<?= $url;  ?>" method="post" id="formulario<?= $row->id; ?>">
                                 <a class="dropdown-item" href="#"><?= $row->nomgru ?></a>
								 <input type="hidden" name="categoria" value="<?= $row->codgru ?>">
								<input type="hidden" name="nombre" value="<?= $row->nomgru ?>">
								</form>
								</div>
							<?php
							}
							 	foreach ($consulta4->result() as $row2): 
							?>
								<div class="CategoriasVer" data-product_code="<?= $row2->codsubcate;?>">
								<form action="<?= $url;  ?>" method="post" id="formulario<?= $row2->codsubcate; ?>">
                                 <a class="dropdown-item" href="#"><?= $row2->nomsubcate ?></a>
								 <input type="hidden" name="categoria" value="<?= $row->codgru ?>">
								<input type="hidden" name="nombre" value="<?= $row->nomgru ?>">
								<input type="hidden" name="subcategoria" value="<?= $row2->codsubcate ?>">	
								</form>
								</div>
								 <?php endforeach;?>
								 
                            </div>
								<input type="hidden" name="numfila" id="numfila" value="<?= $consulta->num_rows(); ?>">

									
							</div>
							</li>
							<?php endforeach;?>	
           </ul>
	</div>