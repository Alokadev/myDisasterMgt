<?php
require_once '../../private/initialize.php';
$title = 'News';      

$page = $_GET['page'] ?? '';

if($page=="" || $page=="1") {
    $pageNum = 0;
}else {
    $pageNum = ($page*5)-5;
}
$display_set = find_all_displays($pageNum);

$numPage = get_displays_pages_num();

?>

<?php require(SHARED . '/header.php'); ?>    
    
<div id="content">
  <div id="page"> <br>
      
<div id="pageNum">
    Page &nbsp;&nbsp;&nbsp;    
    <?php 

        for($i=1;$i<=$numPage;$i++) {
            ?><a href="news.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>"
    ?>
</div>
       <center>
       <table class="list">
        <tr>
            <th>Person Name</th>
            <th>Department</th>
  	    <th>Incident Type</th>
            <th>Threat Level</th>
            <th>Image</th>
            <th>Updated Date</th>
  	    <th>&nbsp;</th>

  	 </tr>
        <?php while($display = mysqli_fetch_assoc($display_set)) { ?>
        <tr>
          <td><?php echo hsc($display['fName'] . " " .$display['lName']); ?></td>
          <td><?php echo hsc($display['dept']); ?></td>
          <td><?php echo hsc($display['InciType']); ?></td>
    	  <td><?php echo hsc($display['status']); ?></td>
          <td><?php echo '<img id ="news" src="data:imagetmp;base64, '.$display['image']. ' ">'; ?></td>
          <td><?php echo hsc($display['cDate']); ?></td>
          
          <td><a href="<?php echo url_to('/public/user/public_view.php?id=' . $display['contentId']); ?>">View</a></td>

    	</tr>
        <?php } ?>
  	</table>
       </center><br>
    <?php
    mysqli_free_result($display_set);
    ?>
    
  </div>
<div id="pageNum">
    Pages&nbsp;&nbsp;&nbsp;
    <?php
        for($i=1;$i<=$numPage;$i++) {
            ?><a href="news.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>";
    ?>
</div>
</div>

<?php require(SHARED . '/footer.php');  ?>