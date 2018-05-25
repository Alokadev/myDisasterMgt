<?php
require_once '../../private/initialize.php';

?>

<?php require_login(); ?>


<?php
$title = 'Edit Content';      
?>

<?php

if(!isset($_GET['id'])) {
    redirect_to(url_to('/public/content/index.php'));
}   
$id = $_GET['id'];

if(is_post_request()) { 
    $content = [];
    $content['contentId'] = $id;
    $content['Uid'] = $_POST['p_id'] ?? '';
    $content['InciType'] = $_POST['InciType'] ?? '';
    $content['properties'] = addslashes($_FILES['userImage']['tmp_name']) ?? '';

    $content['imageData'] = addslashes($_FILES['userImage']['name']) ?? '';
    $content['properties'] = file_get_contents($content['properties']) ?? '';

    $content['properties'] = base64_encode($content['properties']) ?? '';  
    $content['lat'] = $_POST['lat'] ?? '';
    $content['lon'] = $_POST['lon'] ?? '';
    $content['visible'] = 0;
    $content['content'] = $_POST['content'] ?? '';
   
    $result = update_content($content);
    $_SESSION['message'] = "Report Has Updated";
    redirect_to(url_to('/public/content/view.php?id=' . $id));
    } else {
    $content = find_content_by_id($id);
    }



?>

<?php require(SHARED . '/header.php'); ?>

<div id="content">
<br>
  <a class="back-link" href="<?php echo url_to('/public/content/index.php'); ?>">&laquo; Back to Content</a>

  <div class="subject new">
    <h1>Create New Content</h1>
<p>Click the button "Try It" to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<form action="<?php echo url_to('/public/content/edit.php?id=' . $id); ?>" method="post" enctype="multipart/form-data">

<dl>
<dt>Incident Type : </dt>
<dd>
	<select name='InciType'>  
        <option value="">Choose</option>
        <option value="Flood" <?php if($content['InciType']=="Flood") echo 'selected="selected"'; ?>>Flood</option>
        <option value="RTA" <?php if($content['InciType']=="RTA") echo 'selected="selected"'; ?>>Road Traffic Accident</option>
        <option value="Storm" <?php if($content['InciType']=="Storm") echo 'selected="selected"'; ?>>Storm</option>
        <option value="Elec" <?php if($content['InciType']=="Elec") echo 'selected="selected"'; ?>>Electrical Failure</option>
        <option value="Fire" <?php if($content['InciType']=="Fire") echo 'selected="selected"'; ?>>Fire</option>
        <option value="Tsunami" <?php if($content['InciType']=="Tsunami") echo 'selected="selected"'; ?>>Tsunami</option>
        <option value="Earthquake" <?php if($content['InciType']=="Earthquake") echo 'selected="selected"'; ?>>Earthquake</option>
    </select>
</dd>
</dl>
    <div>
        <h3 class="flash">If you update content please re upload the Image again </h3>
    </div>   
<dl>
<dt>Image :</dt>   
<dd><?php echo '<img height="250" width="250" src="data:imagetmp;base64, '.$content['image']. ' ">'; ?></dd>
</dl>
    
<dl>
<dt>Insert Image :</dt>   
<dd><input type="file" name="userImage" required></dd>
</dl>

<dl>
<dt>Latitue : </dt>
<dd><input type="text" id="lat" name="lat" value="<?php echo $content['lat']; ?>" readonly></dd>
</dl>

<dl>
<dt>Longitute: </dt>
<dd><input type="text" id="lon" name="lon" value="<?php echo $content['lon']; ?>" readonly></dd>
</dl>

<dl>
<dt>Description: </dt>
<dd><textarea name="content" cols="60" rows="10"></textarea></dd>
</dl>


<div id="operations">
        <input type="submit" name = "submit" value="Create Content" />
</div><br>
</form>
</div>

<div id="googleMap"></div><br>


<script>
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(7.114179366016706,80.0244140625),
    zoom:10,
};
var geocoder = new google.maps.Geocoder;
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
 google.maps.event.addListener(map, "click", function (e) {

    //lat and lng is available in e object
    var latLng = e.latLng;
    var str = e.latLng.toString().slice(1,-1);
    var lat = latLng.lat();
    var lon = latLng.lng();
    document.getElementById("lat").value = lat;
    document.getElementById("lon").value = lon;
    document.getElementById("latlng").value = str;
    geocodeLatLng(geocoder, map);
});


function geocodeLatLng(geocoder, map) {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
	var marker;
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
				map.setZoom(11);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
}

var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
	var lat = position.coords.latitude;
	var lon = position.coords.longitude;
    /*x.innerHTML = "Latitude: " + lat + 
    "<br>Longitude: " + lon;*/
	document.getElementById("lat").value = lat;
	document.getElementById("lon").value = lon;
	document.getElementById("latlng").value = lat+","+lon;
	
	
}
function alternateColor(color, textId, myInterval) {
    if(!myInterval){
        myInterval = 1000;    
    }
    var colors = ['grey', color];
    var currentColor = 1;
    document.getElementById(textId).style.color = colors[0];
    setInterval(function() {
        document.getElementById(textId).style.color = colors[currentColor];
        if (currentColor < colors.length-1) {
            ++currentColor;
        } else {
            currentColor = 0;
        }
    }, myInterval);
}
alternateColor('red','myText');
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvxD0HjAwjJ_wMJVHq6hIpQ_GuyfKqEtE&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

<?php require(SHARED . '/footer.php');  ?>