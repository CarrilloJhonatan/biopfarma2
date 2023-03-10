/*let map, marker, watchId, geoLoc, autocomplete;
function initMap() {
    const myLatLng = {lat:3.458619536736577, lng:-73.12320051171845};
        map = new google.maps.Map(document.getElementById("map"), {
                zoom:5,
                center: myLatLng,
        });
        marker = new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Esto es colombia",
            draggable: true
        });
            getPosition();
            IautoComplete();
            draggEvente();
    }

    function getPosition() {
        if (navigator.geolocation) {
            var options ={
                timeout: 5000
            };
            geoLoc = navigator.geolocation;
            watchId = geoLoc.watchPosition(showLocationOnMap, errorHandler, options);
        }else{
            alert("Lo sentimos, el explorador no soporta geolocalizacion")
        }
    }

    function showLocationOnMap(position) {
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;
        console.log("Latitud: "+ latitud +", " + "Longitud: "+ longitud);

        const myLatLng = {lat: latitud, lng: longitud};
        marker.setPosition(myLatLng);
        map.setCenter(myLatLng);
    }

    function errorHandler(err) {
        if (err.code == 1){
            alert("Error: Acceso denegado!");
        } else if(err.code == 2){
            alert("Error: Position no existe o no encontrada");
        }
    }

    function IautoComplete() {
        const autput = document.getElementById("places_input");

        autocomplete = new google.maps.places.Autocomplete(autput);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            console.log(place.geometry.location);
            autocomplete.bindTo("bounds", map);
        })
    }

    function draggEvente() {
        google.maps.event.addListener(marker,'drag', function (event) {
            let lan =(event.latLng.lat());
            let lon =(event.latLng.lng());
            let lanlon = lan+","+lon;
            console.log(lanlon)
        })
    }
    */