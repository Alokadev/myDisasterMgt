<?php
require_once '../../private/initialize.php';
user_require_login();
$title = 'Report Incident'; 

if(is_post_request()) {
    $content = [];
    $content['Uid'] = $_SESSION['user_id'];
    $content['InciType'] = $_POST['InciType'] ?? '';
    $content['properties'] = addslashes($_FILES['userImage']['tmp_name']) ?? '';

    $content['imageData'] = addslashes($_FILES['userImage']['name']) ?? '';
    $content['properties'] = file_get_contents($content['properties']) ?? '';

    $content['properties'] = base64_encode($content['properties']) ?? '';  
    $content['lat'] = $_POST['lat'] ?? '';
    $content['lon'] = $_POST['lon'] ?? '';
    $content['visible'] = 0;
    $content['date'] = $_POST['date'] ?? '';
    $content['content'] = $_POST['content'] ?? '';
    

    
    $result = insert_content($content);
    
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "Report Created Successfully Please Wait Untill Approval";
        redirect_to(url_to('/public/user/view.php?id=' . $new_id));
    } else {
        $errors = $result;
    }
}
?>


<?php require(SHARED . '/header.php'); ?>

<div id="content"><br>
    
      <a class="back-link" href="<?php echo url_to('/public/user/my_report.php'); ?>">&laquo; Back to Contents</a>

  <div class="subject new">
    <h1>Create New Content</h1>
    
    <?php 
    if(!isset($errors)){
        $errors = "";
    }
    echo report_set_error($errors); 
    ?>
    
<p>Click the button "Try It" to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<form action="<?php echo url_to('/public/user/create.php'); ?>" method="post" enctype="multipart/form-data">

<dl>
<dt>User ID : </dt>
<dd><input type="text" id="Uid" name="Uid" value="<?php echo $_SESSION['user_id']; ?>" readonly></dd>
</dl>

<dl>
<dt>Incident Type : </dt>
<dd>
    <select name='InciType'>
        <option value="">choose</option>
        <option value="Flood">Flood</option>
        <option value="RTA">Road Traffic Accident</option>
        <option value="Storm">Storm</option>
        <option value="Elec">Electrical Failure</option>
        <option value="Fire">Fire</option>
        <option value="Tsunami">Tsunami</option>
        <option value="Earthquake">Earthquake</option>
    </select>
</dd>
</dl>
    
<dl>
<dt>Insert Image :</dt>   
<dd><input type="file" name="userImage" required></dd>
</dl>

<dl>
<dt>Latitute : </dt>
<dd><input type="text" id="lat" name="lat" readonly></dd>
</dl>

<dl>
<dt>Longitute: </dt>
<dd><input type="text" id="lon" name="lon" readonly></dd>
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

</div>
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

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvxD0HjAwjJ_wMJVHq6hIpQ_GuyfKqEtE&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

<?php require(SHARED . '/footer.php');  ?>