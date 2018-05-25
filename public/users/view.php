<?php
require_once '../../private/initialize.php';
require_login();
$title = 'View User';      
?>

<?php 
    $id = $_GET['id'] ?? '1';
    $user = find_user_by_id($id);
if(is_post_request()) {
    
    $id = $_GET['id'];
    $result = grant_user($id);
    redirect_to(url_to('/public/users/view.php?id=' . hsc(uc($user['id']))));
}
    
?>

<?php require(SHARED . '/header.php'); ?>

<div id="content"> <br>

  <a class="back-link" href="<?php echo url_to('/public/users/index.php'); ?>">&laquo; Back to Users</a>

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
                
        <form action="<?php echo url_to('/public/users/view.php?id=' . hsc(uc($user['id']))); ?>" method="post">
        <dl>
            <?php if ($user['visible'] == 1) {
                $status = "Active";
                $grant = "Block Profile";
            } else {
                $status = "Blocked";
                $grant = "Unblock Profile";
            }
            ?>
            
            <dt>Profile Status :</dt>
            <dd><?php echo $status; ?></dd>
        </dl>
            
        <div id="operations">
            <input type="submit" value="<?php echo $grant; ?>" />
        </div>
        </form>
                
    </div>
    

  </div>

</div>

<?php require(SHARED . '/footer.php');  ?>
