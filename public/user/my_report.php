<?php
require_once '../../private/initialize.php';
user_require_login();
$title = 'Content List';   
?>

<?php
$id = $_SESSION['user_id'];
$page = $_GET['page'] ?? '';

if($page=="" || $page=="1") {
    $pageNum = 0;
}else {
    $pageNum = ($page*5)-5;
}
$content_set = find_all_content_pid($id,$pageNum);

$numPage = find_all_content_pid_page($id);

?>
<?php require(SHARED . '/header.php'); ?>

<div id="page">     
<div id="content">
    
<div class="users listing">
    
    <h1>Content</h1>
    Pages&nbsp;&nbsp;&nbsp;
    <?php
        for($i=1;$i<=$numPage;$i++) {
            ?><a href="my_report.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>"
    ?>

    <div class="actions">
        <a class="action" href="<?php echo url_to('/public/user/create.php'); ?>">Create New Content</a>
    </div>

    <table class="list">
        <tr>
            <th>Content ID</th>
            <th>Visible</th>
  	    <th>Incident Type</th>
            <th>Threat Level</th>
            <th>Image</th>
  	    <th>&nbsp;</th>
            <th>&nbsp;</th>
  	    <th>&nbsp;</th>
  	 </tr>

      <?php while($content = mysqli_fetch_assoc($content_set)) { ?>
        <tr>
          <td><?php echo hsc($content['contentId']); ?></td>
          <td><?php echo $content['visible'] == 1 ? 'true' : 'false'; ?></td>
    	  <td><?php echo $content['InciType']; ?></td>
          <?php
          if($content['status'] == "") {
              $status = "Under Review";
          }else {
              $status = $content['status'];
          }
          ?>
          <td><?php echo $status; ?></td>
          <td><?php echo '<img id="news" src="data:imagetmp;base64, '.$content['image']. ' ">'; ?></td>
          
          <td><a class="action" href="<?php echo url_to('/public/user/view.php?id=' . $content['contentId']); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_to('/public/user/edit.php?id=' . $content['contentId']); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_to('/public/user/delete.php?id=' . $content['contentId']); ?>">Delete</a></td>
    	</tr>
      <?php } ?>
  	</table>
    <br>
    <?php
    mysqli_free_result($content_set);
    ?>

  </div>


</div>
    

</div>
<div id="pageNum">
    Pages&nbsp;&nbsp;&nbsp;
    <?php
        for($i=1;$i<=$numPage;$i++) {
            ?><a href="my_report.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>";
    ?>
</div>

<?php require(SHARED . '/footer.php'); ?>  