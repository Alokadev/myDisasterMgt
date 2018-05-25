<?php
require_once '../../private/initialize.php';

?>

<?php require_login(); ?>


<?php
$title = 'Content List';      
?>

<?php
$page = $_GET['page'] ?? '';

if($page=="" || $page=="1") {
    $pageNum = 0;
}else {
    $pageNum = ($page*5)-5;
}
$content_set = find_all_content($pageNum);

$numPage = get_content_pages_num();

?>
<?php require(SHARED . '/header.php'); ?>

      
<div id="content">
    
<div class="users listing">
    
    <h1>Content</h1>Pages&nbsp;&nbsp;&nbsp;
    <?php
        for($i=1;$i<=$numPage;$i++) {
        ?><a href="index.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>"
    ?>

    <div class="actions">
        <a class="action" href="<?php echo url_to('/public/content/create.php'); ?>">Create New Content</a>
    </div>

    <table class="list">
        <tr>
            <th>Content ID</th>
            <th>User ID</th>
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
          <td><?php echo $content['p_id']; ?></td>
          <td><?php echo $content['visible'] == 1 ? 'true' : 'false'; ?></td>
    	  <td><?php echo $content['InciType']; ?></td>
          <td><?php echo $content['status']; ?></td>
          <td><?php echo '<img id="news" height="250" width="250" src="data:imagetmp;base64, '.$content['image']. ' ">'; ?></td>
          
          <td><a class="action" href="<?php echo url_to('/public/content/view.php?id=' . $content['contentId']); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_to('/public/content/edit.php?id=' . $content['contentId']); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_to('/public/content/delete.php?id=' . $content['contentId']); ?>">Delete</a></td>
    	</tr>
      <?php } ?>
  	</table>
    <br>
    <?php
    mysqli_free_result($content_set);
    ?>

  </div>
Pages&nbsp;&nbsp;&nbsp;
    <?php

    for($i=1;$i<=$numPage;$i++) {
    ?><a href="index.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
    }
        
    echo "<br><br>"
?>

</div>

<?php require(SHARED . '/footer.php'); ?>  