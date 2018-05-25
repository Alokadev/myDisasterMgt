<?php
require_once '../../private/initialize.php';
?>

<?php require_login(); ?>


<?php 
$title = 'User List';      
?>

<?php
$page = $_GET['page'] ?? '';

if($page=="" || $page=="1") {
    $pageNum = 0;
}else {
    $pageNum = ($page*10)-10;
}
$user_set = find_all_users($pageNum);

$numPage = get_users_pages_num();
?>

<?php require(SHARED . '/header.php'); ?>
      
<div id="content">
    
<div class="users listing">
    <h1>Users</h1>
Pages&nbsp;&nbsp;&nbsp;    
    <?php
        for($i=1;$i<=$numPage;$i++) {
        ?><a href="index.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
        }
        
        echo "<br><br>"
    ?>

    <div class="actions">
        <a class="action" href="<?php echo url_to('/public/users/create.php'); ?>">Create a New User</a>
    </div>

    <table class="list">
        <tr>
            <th>ID</th>
            <th>Department</th>
            <th>Visible</th>
  	    <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
            <th>&nbsp;</th>
  	 </tr>

      <?php while($user = mysqli_fetch_assoc($user_set)) { ?>
        <tr>
          <td><?php echo hsc($user['id']); ?></td>
          <td><?php echo $user['dept']; ?></td>
          <td><?php echo $user['visible'] == 1 ? 'true' : 'false'; ?></td>
    	  <td><?php echo $user['fName']; ?></td>
          <td><?php echo $user['lName']; ?></td>
          <td><?php echo $user['postn']; ?></td>
          
          <td><a class="action" href="<?php echo url_to('/public/users/view.php?id=' . $user['id']); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_to('/public/users/edit.php?id=' . $user['id']); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_to('/public/users/delete.php?id=' . $user['id']); ?>">Delete</a></td>
    	</tr>
      <?php } ?>
  	</table>
    <?php
    mysqli_free_result($user_set);
    ?>

  </div><br><br>
Pages&nbsp;&nbsp;&nbsp;
<?php
    for($i=1;$i<=$numPage;$i++) {
    ?><a href="index.php?page=<?php echo $i; ?>" style="text-decoration: none"><?php echo $i." "?></a><?php
    }
        
    echo "<br><br>";
?>
</div>

<?php require(SHARED . '/footer.php'); ?>   