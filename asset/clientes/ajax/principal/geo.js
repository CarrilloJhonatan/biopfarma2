
	var latP = "", longP = "", latD = "", longD = "", latB = [], lonB = [], menor = 0, latt = 0, longg = 0, reversedireccion="";
    $(document).ready(function(){
		//IautoComplete();
		getPosition();	
		 consultarRestaurantes();
		 

		$('#btnGuardarVenta').hide();
		
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
		fetch('http://localhost/ecommerce/ecommerce/ecommerce/api/consultar.php', {
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
		fetch('http://localhost/ecommerce/ecommerce/ecommerce/api/consultar.php', {
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
                        console.log(d+"km");
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
        console.log("Latitud: "+ latitud +", " + "Longitud: "+ longitud);
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
