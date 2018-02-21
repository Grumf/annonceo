     				
    var geocoder;
    var map;   
    function TrouverADR(adresse)
    {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { "address": adresse}, function(results, status) {
        
        if (status == google.maps.GeocoderStatus.OK) {

                
                var strposition = results[0].geometry.location.toString();
                var latlng = new google.maps.LatLng(strposition);
                
                var mapOptions = {
                        zoom      : 15,
                        center    : latlng,
                        scrollwheel:false,
                        zoomControl: true,
                        scaleControl: true,
                        streetViewControl: true
                        }
                        
                map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);	  
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location
                                });
                }
                    
            }  );
        }

        
          
   

    