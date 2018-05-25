<?php
require_once '../../private/initialize.php';
?>
<?php require_login(); ?>


<?php
$title = 'Edit User';

if(!isset($_GET['id'])) {
    redirect_to(url_to('/public/users/index.php'));
}

$id = $_GET['id'];
        
if(is_post_request()) { 
$user = [];
$user['id'] = $id;
$user['email'] = $_POST['email'] ?? '';
$user['pswrd'] = $_POST['pswrd'] ?? '';
$user['fName'] = $_POST['fName'] ?? '';
$user['lName'] = $_POST['lName'] ?? '';
$user['govId'] = $_POST['govId'] ?? '';
$user['dept'] = $_POST['dept'] ?? '';
$user['postn'] = $_POST['postn'] ?? '';
   
$result = update_user($user);
if($result === true) {
    $_SESSION['message'] = "The User Updated Successfully";
    redirect_to(url_to('/public/users/view.php?id=' . $id)); 
} else {
    $errors = $result;
}


} else {
    $user = find_user_by_id($id);
}
?>



<?php require(SHARED . '/header.php'); ?>
<div id="content">
    <br>

  <a class="back-link" href="<?php echo url_to('/public/users/index.php'); ?>">&laquo; Back to Users</a>

  
    <h1>Edit New User</h1>
    
    <?php 
    if(!isset($errors)){
        $errors = "";
    }
    echo report_set_error($errors); 
    ?>

    <form action="<?php echo url_to('/public/users/edit.php?id=' . $id); ?>" method="post">
      <dl>
        <dt>Email:</dt>
        <dd><input type="email" name="email" value="<?php echo $user['email']; ?>" /></dd>
      </dl>
          
      <dl>
        <dt>Password:</dt>
        <dd><input type="password" name="pswrd" value="" /></dd>
      </dl>
          
      <dl>
        <dt>First Name:</dt>
        <dd><input type="text" name="fName" value="<?php echo $user['fName']; ?>" /></dd>
      </dl>
      <dl>
      
      <dl>
        <dt>Last Name:</dt>
        <dd><input type="text" name="lName" value="<?php echo $user['lName']; ?>" /></dd>
      </dl>
      <dl>
          
      <dl>
        <dt>Government ID Number</dt>
        <dd><input type="text" name="govId" value="<?php echo $user['govId']; ?>" /></dd>
      </dl>
      <dl>
          
        <dl>
        <dt>Department</dt>
        <dd>
            <select name="dept">
                <option value="Police">Police</option>
                <option value="Government service">Government Service</option>
                <option value="Politics">Political Officer</option>
            </select>
        </dd>
        </dl>
      <dl>
          
      <dl>
        <dt>Position</dt>
        <dd><input type="text" name="postn" value="<?php echo $user['postn']; ?>" /></dd>
      </dl>

      <div id="operations">
        <input type="submit" value="Create User" />
      </div>
    </form>

  

</div>

<?php require(SHARED . '/footer.php'); ?> 
