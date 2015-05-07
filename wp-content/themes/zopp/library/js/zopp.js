var rutaimagenes = 'http://citricaldas.com.co/wp-content/themes/citricaldas/library/images/';
var rutalibrary = 'http://citricaldas.com.co/wp-content/themes/plantillageneral/library/';

jQuery(document).ready(function(){
        // Ejemplo de omo utilizar JSON TEMPLATE ENGINE
        // var resultados = select_post_cat_slug('');
        // resultados = JSON.parse(resultados);
        // var html   = cargar_plantilla('frases',resultados);
        // jQuery('.frases').html(html);
				
		if(jQuery("#map-canvas").length){
			initialize();
		}
   
    //jQuery(".owl").owlCarousel({items:2});
    //jQuery(window).fancy_scroll();
    /*jQuery('.item-body').addClass("hidden_").viewportChecker({
        classToAdd: 'visible_ animated bounceIn',
        offset: 100
    });*/

});

function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(5.06192694109057,-75.501698863385),
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
		
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
		
		var contentString = '<div id="content-map">'+
		  '<h3 id="firstHeading" class="firstHeading">Citricaldas</h3>'+
		  '<div id="bodyContent">'+
          '<p>Email: citricaldas2014@hotmail</p>'+
		  '<p>Direccion: cra 21 # 24 - 35</p>'+
		  '</div>'+
		  '</div>';

		  var infowindow = new google.maps.InfoWindow({
			  content: contentString
		  });
	  
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(5.067132, -75.51828799999998),
			map: map,
			title:"Citricaldas",
			icon : "http://citricaldas.com.co/wp-content/themes/citricaldas/library/images/marker_map.png"
		});
		
		infowindow.open(map,marker);
  }