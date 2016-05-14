<html>
<head>
<style>
.result-box { margin-top:15px; }
.result-box span { display: inline-block; }
</style>
</head>
<body>
<div id="gmap">
	Enter Address: <input id="address" type="text" name="iAddress"><br>
	<button type="button">GeoCoder</button>
	<div class="result-box">
		<span class="lat"></span><br/>
		<span class="lng"></span><br/>
		<span class="result"></span>
	</div>
</div>
</body>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false"></script>
<script type="text/javascript" src="maps.google.polygon.containsLatLng.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script>
var inputAddress;
var inputRegion;
var latitude;
var longitude;
// Define the LatLng coordinates for the polygon.
var upperDE = [
		{lng: -75.79193115234375, lat: 39.846668346444154},
		{lng: -75.37994384765625, lat: 39.86986035881804},
		{lng: -75.3607177734375, lat: 39.42150825515972},
		{lng: -75.82489013671875, lat: 39.4236299444324}
];
$(document).ready(function(){
	$("#gmap button").click(function(){
		console.log($("#address").val());
		inputAddress = $("#address").val();
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': inputAddress }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				latitude = results[0].geometry.location.lat();
				longitude = results[0].geometry.location.lng();
				console.log("lat/long [2] = " + latitude + '/' + longitude);			

				// Construct the polygon.
				var polyRectangle = new google.maps.Polygon({
					paths: upperDE,
					strokeColor: '#FF0000',
					strokeOpacity: 0.8,
					strokeWeight: 3,
					fillColor: '#FF0000',
					fillOpacity: 0.35
				});

				var coordinate = new google.maps.LatLng(latitude, longitude);
				var isWithinPolygon = polyRectangle.containsLatLng(coordinate);
				console.log("lat/long = " + latitude + '/' + longitude);
				console.log("isWithinPolygon = " + isWithinPolygon);
				
				//display below the button
				$("#gmap span.lat").html("latitude = " + latitude);
				$("#gmap span.lng").html("longitude = " + longitude);
				if(isWithinPolygon == true) { var polyresult = "Yes"; } else { var polyresult = "No"; }
				$("#gmap span.result").html("Is it within the polygon area? " + polyresult);
			} 
		}); 
	});
});
</script>

</html>
