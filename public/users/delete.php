<?php
require_once '../../private/initialize.php';
?>
<?php require_login(); ?>

<?php 
$title = 'Delete User';      

if(!isset($_GET['id'])) {
    redirect_to(url_to('/public/users/index.php'));
}
$id = $_GET['id'];

$user = find_user_by_id($id);

if(is_post_request()) {

    $result = delete_user($id);
    $_SESSION['message'] = "The User Deleted Successfully";
    redirect_to(url_to('/public/users/index.php'));
    
}
?>
<?php require(SHARED . '/header.php'); ?>

<div id="content">
    <br>

  <a class="back-link" href="<?php echo url_to('/public/users/index.php'); ?>">&laquo; Back to Users</a>
  
    <h1>Delete User</h1>
    
    <div class="user delete">      
    
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
        
        <dl>
            <dt>Visible :</dt>
            <dd><?php echo $user['visible']?></dd>
        </dl>
            
        <p>Are you sure want to delete this User</p>
        
        <form action="<?php url_to('/public/users/delete.php?id=' .
 hsc(uc($user['id']))); ?>" method="post">
            
            <div id="operations">
                <input type="submit" name="delete" value="Delete User"/>
            </div>
            
        </form>
                
    </div>
    </div>
</div>

<?php require(SHARED . '/footer.php'); ?>  
