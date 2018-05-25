<?php
require_once '../private/initialize.php';
?>

<?php require_login(); ?>


<?php
  if(!isset($title)) { 
      $title = 'Menu';      
  }
?>

<?php require(SHARED . '/header.php'); ?>
      
<div id="content">
    <div id="content">
        <div id="main_menu">
            <center>
            <h2>Main Menu</h2>
            <nav class="under">
            <ul>
                <li><a href="<?php echo url_to('/public/users/index.php'); ?>">User Info</a></li>
                <li><a href="<?php echo url_to('/public/content/index.php'); ?>">Content Info</a></li>
            </ul>
            </nav>
            <img id="contentImg" src="<?php echo url_to('/public/images/admin.jpg'); ?>"/>
            </center>
        </div>
    </div>
</div>

<?php require(SHARED . '/footer.php'); ?>   