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
        
        <nav>
            <ul>
                <?php 
                if(isset($_SESSION['email'])) {
                     $session = $_SESSION['email'];
                     $status = "logout";
                }else {
                    $session = "Not log in";
                    $status = "";
                }
                ?>
                <li>User: <?php echo $session; ?></li>
                <li><a href="<?php echo url_to('/public/user/index.php'); ?>">Home</a></li>
                <li><a href="<?php echo url_to('/public/logout.php'); ?>"><?php echo $status; ?></a></li>
            </ul>
        </nav>
  
        <?php echo display_message_session(); ?>