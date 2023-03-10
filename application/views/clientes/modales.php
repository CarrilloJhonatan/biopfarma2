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
	  $formapag;

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
.vertical-menu {
  width: 300px;
  position: fixed;
  z-index: 100;

}

.vertical-menu a {
  background-color: <?= $colortitle ?>;
  color: black;
  display: block;
  padding: 12px;
  text-decoration: none;
}

.vertical-menu a:hover {
  background-color: <?= $fondo ?>;
}

.vertical-menu a.active {
  background-color: <?= $fondo ?>;
  color: white;
}

.flotanteMenu{
	position: fixed;
    left: 10px;
    top: 30px;
   
    margin-bottom: 0;
    opacity: 0.5;
}
</style>

<div class="container">

    <!-- Modal -->
	<div class="modal" id="verModalCarrito" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Carrito de compra</h5>
				<button type="button" class="close" onclick="Cerrar();" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h6> <label for="">Codigo: </label> <label id="codigoped"></label></h6>

				<div class="table-responsive">
					<table class="table" id="tablaCarrito">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Und</th>
								<th>Descuento</th>
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
                       <!-- <label>Domicilio: $<span id="domicilio"></span></label> -->
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
							<textarea class="form-control" style="resize: none;" name="comentarioCarrito" id="comentarioCarrito" cols="10" rows="3"></textarea>                   
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
	<div class="modal fade bd-example-modal-lg" id="ModalVerProductos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg">
    		<div class="modal-content">
				<div class="modal-header">	
					<h5 class="modal-title"  id="exampleModalLongTitle"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span id="nombreProducto1"></span></h5>
					<button type="button" class="close" data-dismiss="modal" onclick="Cerrar()" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 product_img text-center" style="border-right: 1px solid <?= $border ?>; color: <?= $border ?> !important">
							<img src="" class="imagenP" id="urlProducto" >
						</div>
						<div class="col-md-6 product_content">
							<h4 class="text-success" id="nombreProducto2"></h4>
						
							<hr>
							<div class="scroll_text">
								<p id="descripcionProducto"></p>
								<input hidden type="text" id="descuento">
								<input hidden type="text" id="resta">
								<input hidden type="text"  id="preciobase">
								
							</div>
							<div>
								
							</div>
							<hr>
							<h3 class="cost text-success" style="color: <?= $border ?>" id="precioProducto"></h3>
							
								 
							
							<div class="space-ten"></div>
								<div class="btn-ground">
									<div class="section" style="padding-bottom:20px;">
										<h6 class="title-attr"><small>CANTIDAD</small></h6>                    
										<div>
											<div class="btn-minus btn btn-success"><span class="fa fa-minus"></span></div>
											<input class="form-control"  id="undProducto" value="1">
											<input class="form-control" type="hidden" id="idProducto">
											<input class="form-control" type="hidden" id="precioProducto2">
											<div class="btn-plus btn btn-success"><span class="fa fa-plus"></span></div>
										</div>
										<br><br>
										<button type="button" class="btn <?= $buscar ?>" id="addCarrito"><span class="fa fa-shopping-cart"></span> Agregar</button>
									</div>
								</div>
							</div>
               			</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modalFiltro" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-filter" aria-hidden="true"></i> Filtros</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body scroll_text2">
				<br>
				<div class="card">
					<article class="card-group-item">
						<header class="card-header bg-success">
							<h6 class="title text-white">Rango de precios </h6>
						</header>
						<div class="filter-content">
							<div class="card-body">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Minimo</label>
										<input type="number" class="form-control" id="manimoF" placeholder="$0" min="0">
									</div>
									<div class="form-group col-md-6 text-right">
										<label>Maximo</label>
										<input type="number" class="form-control" id="maximoF" placeholder="$1,0000" min="0">
									</div>
								</div>
							</div> <!-- card-body.// -->
						</div>
					</article> <!-- card-group-item.// -->
				</div>
				<br>
				<div class="card">		
					<article class="card-group-item">
						<header class="card-header bg-success">
							<h6 class="title text-white">Categorias </h6>
						</header>
						<div class="filter-content">
							<div class="card-body">
							<hr>
							<?php $consulta = $this->db->query("SELECT id,codgru,nomgru FROM tbl_categorias WHERE estado = 1");
							 	foreach ($consulta->result() as $row): 
							?>
								<label class="form-check">
									<input class="form-check-input common_selector categoriasF" type="checkbox" name="categoriasF<?= $row->id?>" value="<?= $row->codgru?>">
									<span class="form-check-label">
										<?= $row->nomgru?>
									</span>
								</label> <!-- form-check.// -->
								<hr>
							<?php endforeach;?>		
							</div> <!-- card-body.// -->
						</div>
					</article> <!-- card-group-item.// -->
				</div> <!-- card.// -->

			</div>
			</div>
		</div>
	</div>

	<!-- Modal -->

	<div  class="modal fade bd-example-modal-lg" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg" style="max-width: 85%">
    		<div class="modal-content">
		
			<div class="modal-header">
				
					<h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-product-hunt" aria-hidden="true"></i> Comprar</h5>
					<button type="button" class="close" data-dismiss="modal" onclick="Cerrar()" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<br>
				<!-- NOTA PARA EL USUARIO -->
				<div id="nota" hidden class="alert alert-primary alert-dismissible fade show" role="alert">
					<strong>Nota Importante:</strong> Señor(a) usuario al momento de usar la ubicacion actual porfavor verifique que este bien escrita.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-6" style="  border-right: 1px solid <?= $fondotitle ?>;">
							<img src="<?php echo base_url($logo.'')?>" style="width:100%" >
						
						</div>


						<div class="col-md-6 product_content">
							<div class="form-group">
								<label>Elije forma de pago</label>
								<select name="formapago" class="form-control">
									

								<?php  
									$consulta2 = $this->db->query("SELECT * FROM forma_pago ");
									foreach ($consulta2->result() as $row): 
									if( strpos(strtoupper($row->nombre), "PAYU") !== false ){
										$formapag = $row->codformapago;
								?>
									<option selected="true" value="<?= $row->codformapago; ?>" selected><?= $row->nombre;?></option>
									

									<?php 
									}
									endforeach; ?>
								</select>
							</div>
							
							<hr>
							<div class="form-group">
								<label>¿Donde desea recibir el pedido?</label>
								<br>
								<input type="checkbox" id="recoTienda"> <label>Recoger en tienda</label>
								<br>
								<input type="checkbox" name="location on" id="Location-on" onclick="Selectt()">

								<label for=""> Usar Ubicacion Actual</label>
       							 <br>
								<!-- <input class="form-control" type="text"  id="places_input" placeholder="Ingrese direccion"> -->

								<form id="location-form">	
								<br>
								<label for="">Direccion</label>
								<br>
								<input type="text" id="direccion" name="direccion" class="form-control" onkeydown="onKeyDownHandler(event);"  value="<?= $this->session->userdata('direccion');?>">
								<br>

								<label for="">Farmacia mas cercana</label>
										<div class="form-group">
											<table class="table table-hover" id="tablaRestaurantes">
												<thead class="">
													<tr>
														
														<th>Nombre Farmacia</th>
														<th>Direccion</th>
													</tr>
													
												</thead>
												<tbody id="tabla-content"style="cursor:pointer">
												
												</tbody>
											</table>
									
											<button id="btn" type="submit" class="btn btn-primary">Mostrar Farmacias Cercanas</button>
									</form>
										</div>
								<!--<input type="text" class="form-control" id="direccion" placeholder="Direccion de domicilio..." value="<//?= $this->session->userdata('direccion');?>">
									-->		
									
							</div>
							<hr>
						
							<input hidden type="text" name="codalmm" id="codalmm">
							<div class="form-group">
								<label>Telefono de contacto</label>
								<input type="number" class="form-control" name="telefono" placeholder="Telefono de contacto..." value="<?= $this->session->userdata('telefono');?>">
							</div>
							<div hidden class="form-group">
								<label>Codigo promocional</label>
								<input type="text" class="form-control" name="CodProm" id="CodProm" placeholder="Codigo de descuento..." value="">
							</div>
							
               			</div>
						</div>
							<div class="modal-footer">
							<center>
							<p style="size:11px">
							Al finalizar la transaccion recuerde descargar 
							su comprobante y pulsar <u><b>Regresar al sitio de la tienda</b></u>
							para finalizar el proceso satisfactoriamente.
							
							</p>
							</center>
							<div id="payu">
							</div>
							<button  type="button" class="btn btn-outline-success" id="btnGuardarVenta">Terminar Pedido</button>
							<!--<button type="submit"  >Guardar</button>-->
							<button type="button" id="cerrar" name="cerrar" onclick="Cerrar()"  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
    
    <button class="btn btn-success flotante totalCarritoBtn" style="margin-top:30px !important">
		<span class="badge badge-dark totalCarrito"></span> 
		<i class="fa fa-shopping-cart" aria-hidden="true"></i>
	</button>
	
	<!--<button class="btn btn-warning flotante2" style="color:white !important;">
		<i class="fa fa-filter" aria-hidden="true"></i>
	</button>

	<button class="btn btn-danger flotante3" id="quitarfiltro" title="Quitar filtro">
		<i class="fa fa-filter" aria-hidden="true"></i><i class="fa fa-times-circle-o fa-lg" aria-hidden="true"></i>
	</button>-->

	


	<div class="modal" id="verModalPedido" tabindex="-1" role="dialog">
		
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Mis compras</h5>
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
                                <th>compra</th>
								<th>articulos</th>
                                <th>Valor</th>
                                <th>estado</th>
                                <!--<th>Calificacion</th>-->
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

<script>
	var formapago = "<?= $row->codformapago ?>";
	var latP = "", longP = "", latD = "", longD = "", latB = [], lonB = [], menor = 0, latt = 0, longg = 0, reversedireccion="";
    $(document).ready(function(){
		//IautoComplete();
		$('[name="formapago"]').val(formapago)
		getPosition();	
		 consultarRestaurantes();
		 

		//$('#btnGuardarVenta').hide();
		
		$('#verMenu').on('click',function(){
			var estado = $('.vertical-menu').is(':hidden');
			$('.vertical-menu').fadeIn()
			$('.vertical-menu').prop('hidden', !estado)
		})
        
		})
		$("html").click(function() {
			if(!$('.vertical-menu').is(':hidden')){
				$('.vertical-menu').fadeOut()

			}
	});
	$('#verMenu').click(function (e) {
    e.stopPropagation();
	});

	function Cerrar(){
        $('#ModalPago').appendTo("body").modal('hide');
        $('#verModalCarrito').appendTo("body").modal('hide');
		$('#ModalVerProductos').appendTo("body").modal('hide');
	}
	async	function consultarRestaurantes() {
		fetch('https://biopharmaciavirtual.com.co/api/consultar.php', {
                method: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(respuesta => respuesta.json())
                .then(restaurantes => {
                    agregarRestaurantesTabla(restaurantes);
					
                })
	}
	async	function consultarRestaurantes1(e) {
		e.preventDefault();
		fetch('https://biopharmaciavirtual.com.co/consultar.php', {
                method: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(respuesta => respuesta.json())
                .then(restaurantes => {
                    agregarRestaurantesTabla(restaurantes);
					
                })
	}
	async function agregarRestaurantesTabla(restaurantes) {
		var restaurantes1 = new Object();
		var a = new Object();
		for (var restaurante of restaurantes) {
			
				 a = await CalcularAuto(restaurante);	
					//	llamarLatLong(restaurante);	
					if(a != null){
						restaurantes1 = a;
					}else{

					}
				
		}

			vaciarTabla();
			document.getElementById('codalmm').value = restaurantes1.codalmm;
			localStorage.setItem('codalm',restaurantes1.codalmm);

			todoArticulos();
			$('#tablaRestaurantes tbody').append(` <tr>
                                            
							<td>${restaurantes1.Nombre}</td>
							<td>${restaurantes1.Direccion}</td>

							</tr>`);
							//console.log("La farmacia mas cercana es: "+latt+", "+longg);
							//console.log("El numero menor es: "+ menor);
							menor = 0;

		
		
		
	}
	function vaciarTabla(){
		const elemento = document.querySelector('#tabla-content');
		elemento.innerHTML ="";
	}
	function initMap(){
		//IautoComplete();
	}         
	// Get Location form
	var locationForm = document.getElementById('location-form');

	// Listen for submit
	locationForm.addEventListener('submit', consultarRestaurantes1);
    
 	async function Selectt(){
			if(document.getElementById('Location-on').checked){
				
				latP = "";
				longP ="";
				await getPosition();
				await	consultarRestaurantes();
				var limpiar="";
				document.getElementById('direccion').value =reversedireccion;
				document.getElementById('btn').disabled =true;
				document.getElementById('nota').hidden = false;

			}else{
				document.getElementById('direccion').disabled=false;
				document.getElementById('btn').disabled =false;

			} 
    }     
	function onKeyDownHandler(event) {

		document.getElementById('btn').disabled =false;

		/* var codigo = event.which || event.keyCode;

		console.log("Presionada: " + codigo);
		
		if(codigo === 13){
		console.log("Tecla ENTER");
		}

		if(codigo >= 65 && codigo <= 90){
		console.log(String.fromCharCode(codigo));
		} */
	}

	//Convertir de nomeclatura a coordenadas
    async  function geocode(){
                  
                
                 
                var location = document.getElementById('direccion').value;
                //location = latP +","+ longP;
				if (location == "") {
					
				}else{
					await  axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
                    params:{
                        address:location,
                        key:'AIzaSyCWYq2HjKlnk64_g_wRKkAs0461FuLKY64'
                        
                    }
                })
                .then(function(response){
                    // Log full response
                   // console.log(response);

                    // Formatted Address
                    var formattedAddress = response.data.results[0].formatted_address;
                    var formattedAddressOutput =
                     `
                        <ul class = "list-group">
                        <li class="list-group-item">${formattedAddress}</li>
                        </ul>
                    `;

                    // Address componets
                        var addressComponents = response.data.results[0].address_components;
                            var addressComponentOutput = 
                            `
                            <ul class = "list-group">
                            `;
                            for (var i = 0; i < addressComponents.length; i++) {
                                addressComponentOutput += 
                                `
                                    <li class="list-group-item"><strong>${addressComponents[i].types[0]}
                                    </strong>: ${addressComponents[i].long_name}</li>
                                `;                            
                            }
                        addressComponentOutput += '</ul>';
                        

             // Geometry
             var latLocation = response.data.results[0].geometry.location.lat;
             var lngLocation = response.data.results[0].geometry.location.lng;
            
             latP = latLocation;
             longP = lngLocation;
             
                       /*      var geometryOutput = 
                            `
                            <ul class = "list-group">
                                <li id="latLocation" class="list-group-item"><strong>Latitude</strong>:
                                ${latLocation}
                                    
                                </li>

                                <li id = "lngLocation" class="list-group-item"><strong>Longitude</strong>:
                                ${lngLocation}
                                    
                                </li>
                            </ul>`;
                                      */                       
                            
                               


 
                        

                    })
                .catch(function(error){
                   // console.log(error);
                })
				}
               
    }
	//Convertir de coordenadas a nomeclatura
	async function reversegeocoding(){
		
		var KEY = "AIzaSyCWYq2HjKlnk64_g_wRKkAs0461FuLKY64";
		var url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latP},${longP}&key=${KEY}`;
		fetch(url)
			.then(response => response.json())
			.then(data =>{
				let parts = data.results[0].address_components;
				reversedireccion = data.results[0].formatted_address;
			
			});
	}
           
    // Calcular la ubicacion 1 con la 2

 	async  function CalcularAuto(restaurantes){

                await geocode();
                //await geodestination();
						latB.push(restaurantes.Latitud);
						lonB.push(restaurantes.Longitud);
						var latLocation = latP; 
						var lngLocation = longP; 
						
						var latDestination =  latB; 
						var lngDestination =  lonB; 
							
                    
                        
                            var getDistance =  function(latLocation,lngLocation,latDestination,lngDestination) {
                                const deg2rad = deg => (deg * Math.PI) / 180.0;
                                var R = 6371;
                                var dLat = deg2rad(latDestination-latLocation);
                                var dLon = deg2rad(lngDestination-lngLocation);
                                var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(deg2rad(latLocation)) * Math.cos(deg2rad(latDestination)) * Math.sin(dLon/2) 
                                * Math.sin(dLon/2);


                        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                        var d = R * c;
                        return d; 
                            }
       
        
                        function de2rad(n){return n * (Math.PI/180)}
                        var d = getDistance(latLocation,lngLocation , latDestination,lngDestination );
                        latB = [];
						lonB = [];
						var distanciaTemp = 0;
                       // console.log(d+"km");
						distanciaTemp = d;
						if(menor == 0){
							menor = distanciaTemp;
							latt = latDestination;
							longg = lngDestination;
						}
						if(menor >= distanciaTemp){
							menor = distanciaTemp;
							latt = latDestination;
							longg = lngDestination;

							
							return restaurantes;
						}
						return null;
    }
	

    // Auto Completed
	/*function IautoComplete() {
                    let autocomplete;
                    const autput = document.getElementById("direccion");

                    autocomplete = new google.maps.places.Autocomplete(autput);
                        autocomplete.addListener('place_changed', function() {
                            const place = autocomplete.getPlace();
                            
                           // map.setCenter(place.geometry.location);
                            //marker.setPosition(place.geometry.location);
                            console.log(place.geometry.location);
                            //autocomplete.bindTo("bounds", map);
                        })
    	}*/

               
//////////////////////////////////////// Posicion automatica por el usuario
    
async function getPosition() {

				/* const successCallback = (position) =>{
					console.log(position);
				};

				const errorCallback = (error) =>{
					console.error(error);
				};

				navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
					enableHighAccuracy: true,
					timeout: 5000
				}); */

 
        if (navigator.geolocation) {
            var options ={
                timeout: 5000
            };
            geoLoc = navigator.geolocation;
    	    watchId = geoLoc.getCurrentPosition(showLocationOnMap, errorHandler, options);
        }else{
            alert("Lo sentimos, el explorador no soporta geolocalizacion")
        }
		
} 
async function showLocationOnMap(position) {
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;
        latP = latitud;
        longP = longitud;
        //console.log("Latitud: "+ latitud +", " + "Longitud: "+ longitud);
       	await geocode();
		await reversegeocoding();
        const myLatLng = {lat: latitud, lng: longitud};
       // marker.setPosition(myLatLng);
        //map.setCenter(myLatLng);
}
async function errorHandler(err) {
        if (err.code == 1){
            alert("Error: Acceso denegado!");
        } else if(err.code == 2){
            alert("Error: Position no existe o no encontrada");
        }
}

 







</script>


	<!--<button class="btn btn-success flotante2">
		<i class="fa fa-filter" aria-hidden="true"></i>
	</button>

	<button class="btn btn-danger flotante3" id="quitarfiltro" title="Quitar filtro">
		<i class="fa fa-filter" aria-hidden="true"></i><i class="fa fa-times-circle-o fa-lg" aria-hidden="true"></i>
	</button>-->


</div>
