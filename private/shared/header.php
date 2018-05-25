<!doctype html>

<html lang="en">
  <head>
      <title><?php echo hsc($title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_to('/public/style/style.css'); ?>" />
  </head>

  <body>
        <header>
            <h1>Disaster Management System</h1>
            
        </header>
        
        <nav class="col-3">
            <ul>
                <?php                 
                if(isset($_SESSION['admin_id'])) {
                    $admin = "Menu";
                    $admin_path = url_to('/public/index.php');
                } else {
                    $admin = "";
                    $admin_path = "";
                }
                
                if(isset($_SESSION['email'])) {
                    $session = $_SESSION['email'];
                    $path = url_to('/public/logout.php');
                    $status = "Log Out";
                }else {
                    $session = "Not log in";
                    $path = "";
                    $status = "";
                }                
                               
                if(isset($_SESSION['admin_id'])) {
                    $login = $_SESSION['email'];
                    $login_path = url_to('/public/index.php');
                }elseif(isset($_SESSION['user_id'])) {
                    $login = $_SESSION['email'];
                    $login_path = url_to('/public/user/my_report.php');
                }else{
                    $login = "Login";
                    $login_path = url_to('/public/login.php');
                }
  
                ?>
                <li><a href="<?php echo url_to('/public/user/index.php'); ?>">Home</a></li>
                <li><a href="<?php echo url_to('/public/user/about.php'); ?>">About</a></li>
                <li><a href="<?php echo url_to('/public/user/news.php'); ?>">News</a></li>
                <li><a href="<?php echo url_to('/public/user/map.php'); ?>">Map</a></li>
                <li><a href="<?php echo url_to('/public/user/pie.php'); ?>">Analysis</a></li>
                <li><a href="<?php echo url_to('/public/user/new_user.php'); ?>">Create Account</a></li>
                
                <li><a href="<?php echo $admin_path; ?>"><?php echo $admin; ?></a></li>
                <li><a href="<?php echo $login_path; ?>"><?php echo $login; ?></a></li>
                <li><a href="<?php echo $path; ?>"><?php echo $status; ?></a></li>
                
            </ul>
        </nav>
  
        <?php echo display_message_session(); ?>