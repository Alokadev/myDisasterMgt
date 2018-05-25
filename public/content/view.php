<?php
require_once '../../private/initialize.php';
require_login();
$title = 'View Content';      
?>

<?php 
    $id = $_GET['id'] ?? '28';
    $content = find_content_by_id($id);
    
    if(is_post_request()) {  
    $status = $_POST['status'] ?? '';
    $visible = $_POST['visible'] ?? '';
    $content = find_content_by_id($id);
    $result = grant_content($id,$visible,$status);
    //$row = mysqli_fetch_array($info);
    redirect_to(url_to('/public/content/view.php?id=' . hsc(uc($content['contentId']))));
    } 
?>
<?php require(SHARED . '/header.php'); ?>

<div id="content">
    <br>

  <a class="back-link" href="<?php echo url_to('/public/content/index.php'); ?>">&laquo; Back to Contents</a>

  <div class="content new">
    <h1>Content Info</h1>
    
    <div class="attributes">
        <dl>
            <dt>Content Id :</dt>
            <dd><?php echo $content['contentId']?></dd>
        </dl>
        
        <dl>
            <dt>User Id :</dt>
            <dd><?php echo $content['p_id']?></dd>
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
        
        <form action="<?php echo url_to('/public/content/view.php?id=' . hsc(uc($content['contentId']))); ?>" method="post">
            
        <dl>     
            <dt>Content Active:</dt>
            <dd>
                <input type="hidden" name="visible" value="0">
                <input type="checkbox" name="visible" value="1"<?php echo ($content['visible']==1 ? 'checked' : '');?>>
            </dd>
        </dl>
 
        <dl>
            <dt>Threat Level :</dt>
            <dd>
                <input type="radio" name="status" value="High"<?php echo ($content['status']=="High" ? 'checked' : '');?>>High<br>
                <input type="radio" name="status" value="Medium"<?php echo ($content['status']=="Medium" ? 'checked' : '');?>>Medium<br>
                <input type="radio" name="status" value="Low"<?php echo ($content['status']=="Low" ? 'checked' : '');?>>Low<br>
                <input type="radio" name="status" value="N/A"<?php echo ($content['status']=="N/A" ? 'checked' : '');?>>N/A
            </dd>
        </dl>
            
        <div id="operations">
            <input type="submit" value="Permit" />
        </div>
        </form>
        
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