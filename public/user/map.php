<?php
require_once '../../private/initialize.php';
$title = 'Map';  

if(is_post_request()) {
    if($_POST['InciType'] == "") {
        redirect_to(url_to('/public/user/map.php'));
    } else {
        $incident = $_POST['InciType'];
        $_SESSION['message'] = $incident;
        $results = find_by_incident($incident);
    }
} else {
    $results = find_all_displays_loc();
}
?>

<?php require(SHARED . '/header.php');?>

<div id='page'>
    <div id ='condition'>
        <form action="<?php echo url_to('/public/user/map.php'); ?>" method="post">
        
        <dl>
        <dt>Incident Type : </dt>
        <dd>
        <select name='InciType'>
        <option value="">All</option>
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
        
        <input type="submit" name = "submit" value="Check" />
            
        </form>
    </div>

<div id='allMap'></div>
</div>

<script type="text/javascript">
    function initMap() {
    var map = new google.maps.Map(document.getElementById('allMap'), {
        zoom: 9,
        center: {lat: 7.114179366016706, lng: 80.0244140625}
    });
    <?php foreach($results as $result){ ?>
        var location = new google.maps.LatLng(<?php echo $result['lat']; ?>, <?php echo $result['lon']; ?>);
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    <?php } ?>
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvxD0HjAwjJ_wMJVHq6hIpQ_GuyfKqEtE&callback=initMap">
</script>


</body>



<?php require(SHARED . '/footer.php');  ?>
