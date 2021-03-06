<?php ob_start()?>

<div id="map" style="width:100%;height:500px"></div>

<script>
function myMap() {
  var myCenter = new google.maps.LatLng(46.584839, 16.162009);
  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: myCenter, zoom: 17, mapTypeId:google.maps.MapTypeId.HYBRID};
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter, animation: google.maps.Animation.BOUNCE});
  marker.setMap(map);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvPheyvJXJlJyqcWfIvRJoalmoFfEkN04&callback=myMap"></script>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
