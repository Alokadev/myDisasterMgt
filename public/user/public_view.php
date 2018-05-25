<?php
require_once '../../private/initialize.php';
$title = 'View Content';      

    $id = $_GET['id'] ?? '28';
    $content = find_display_by_id($id);
 
?>
<?php require(SHARED . '/header.php'); ?>

<div id="content"><br>


  <div class="content new">
    <h1>Content Info</h1>
    
    <div class="attributes">
        <dl>
            <dt>Content Id :</dt>
            <dd><?php echo $content['contentId']?></dd>
        </dl>
        
        <dl>
            <dt>User Name :</dt>
            <dd><?php echo $content['fName'] . " " . $content['lName']; ?></dd>
        </dl>
        
        <dl>
            <dt>Incident Type :</dt>
            <dd><?php echo $content['InciType']?></dd>
        </dl>
        <dl>
            <dt>Incident Image :</dt>
            <dd><?php echo '<img id="news" src="data:imagetmp;base64, '.$content['image']. ' ">'; ?></dd>
        </dl>

        
        <dl>
            <dt>Last Updated Date :</dt>
            <dd><?php echo $content['cDate']?></dd>
        </dl> 
        
        <dl>
            <dt>Description :</dt>
            <dd><?php echo $content['content']?></dd>
        </dl>
        
        <?php 
        $latlng = $content['lat'].",".$content['lon'];
        ?>
        

        <dl>
            <dt>Location :</dt>
            <dd><input id="latlng" type="text" value="<?php echo $latlng; ?>" style="display: none"></dd>

        </dl>
                        
        

        <div id="map"></div> <br>      
    </div>
  </div>

</div>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {lat: 7.114179366016706, lng: 80.0244140625}
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(15);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map,
              });
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
      
      
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvxD0HjAwjJ_wMJVHq6hIpQ_GuyfKqEtE&callback=initMap">
    </script>


<?php require(SHARED . '/footer.php');  ?>