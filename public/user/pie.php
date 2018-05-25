<?php
require_once '../../private/initialize.php';
$title = 'Analysis'; 

$result = find_incidentnum();
?>

<?php require(SHARED . '/header.php'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current',{'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart()
        {
            var data = google.visualization.arrayToDataTable([
                ['InciType', 'number'],
                <?php 
                while($row = mysqli_fetch_array($result))
                {
                    echo"['".$row["InciType"]."',".$row["number"]."],";  
                }
                ?>
            ]);
            var option = {
                title: 'Percentage of Each Incident',
                is3D:true,  
                
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data,option);
        }
    </script>
<div id="page">
 
      <div id="piechart"></div>
   
  

      
      
</div>
<?php require(SHARED . '/footer.php');  ?>