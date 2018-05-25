<?php
require_once '../../private/initialize.php';
require_login();
$title = 'Newly Created User';      
?>

<?php 
    $id = $_GET['id'] ?? '1';
    $user = find_user_by_id($id);
?>

<?php require(SHARED . '/header.php'); ?>

<div id="content"> <br>

  <div class="subject new">
    <h1>User Info</h1>
    
    <div class="attributes">
        <dl>
            <dt>ID :</dt>
            <dd><?php echo $user['id']?></dd>
        </dl>
        
        <dl>
            <dt>Email :</dt>
            <dd><?php echo $user['email']?></dd>
        </dl>
        
        <dl>
            <dt>Password :</dt>
            <dd><?php echo $user['pswrd']?></dd>
        </dl>
        
        <dl>
            <dt>First Name :</dt>
            <dd><?php echo $user['fName']?></dd>
        </dl>
        
        <dl>
            <dt>Last Name :</dt>
            <dd><?php echo $user['lName']?></dd>
        </dl>
        
        <dl>
            <dt>Government ID :</dt>
            <dd><?php echo $user['govId']?></dd>
        </dl>
        
        <dl>
            <dt>Department :</dt>
            <dd><?php echo $user['dept']?></dd>
        </dl>
        
        <dl>
            <dt>Position :</dt>
            <dd><?php echo $user['postn']?></dd>
        </dl>      
                
    </div>
    

  </div>

</div>

<?php require(SHARED . '/footer.php');  ?>
