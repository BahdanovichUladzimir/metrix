var map, marker;
var geocoder;
var defLtn = <?php echo $this->ltnCenter;?>;
var defLng = <?php echo $this->lngCenter;?>;
$(document).ready(function() {
	geocoder = new google.maps.Geocoder();
	var mapOptions = {
		center: new google.maps.LatLng(defLtn, defLng),
		zoom: 11,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
    map = new google.maps.Map(document.getElementById("clocationmap"), mapOptions);
	
	marker = new google.maps.Marker({
		position: new google.maps.LatLng(defLtn, defLng),
		map: map
	});
	
	google.maps.event.addListener(map, 'drag', function() {
		onChange();
	});
	
	if($('.lat_<?php echo $randNumber; ?>').val()!='' && $('.lon_<?php echo $randNumber; ?>').val()!=''){
		var lokasi = new google.maps.LatLng(
			$('.lat_<?php echo $randNumber; ?>').val(), 
			$('.lon_<?php echo $randNumber; ?>').val());
		map.panTo(lokasi);
		marker.setPosition(lokasi);
	}else{
		$('.lat_<?php echo $randNumber; ?>').val(defLtn);
		$('.lon_<?php echo $randNumber; ?>').val(defLng);
		onChange();
	}
	
	$("#searchbutton").click(function(){
		geocodeFunct($("#searchtext").val());
		return false;
	});
    $("#clear_coordinates_button").click(function(){
        $('.lat_<?php echo $randNumber; ?>').val(0);
        $('.lon_<?php echo $randNumber; ?>').val(0);
        var lokasi = new google.maps.LatLng(0,0);
        map.panTo(lokasi);
        marker.setPosition(lokasi);
    })
});

function onChange() {
	var lokasi = map.getCenter();
	marker.setPosition(lokasi);
	$('.lat_<?php echo $randNumber; ?>').val(lokasi.lat().toFixed(5));
	$('.lon_<?php echo $randNumber; ?>').val(lokasi.lng().toFixed(5));
}

function geocodeFunct(name){
	geocoder.geocode( { 'address': name}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			marker.setPosition(results[0].geometry.location);
		}
		else
		{
			alert("Some Problem in Geocode : " + status);
		}
	}); 
}
/*
$("#deals-form").on('update_deal_categories_params', function(){
	console.log("geocoder ->");
	console.log(geocoder);
});*/
