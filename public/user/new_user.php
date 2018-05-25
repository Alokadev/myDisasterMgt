<?php
require_once '../../private/initialize.php';
$title = 'Create Account';      
require(SHARED . '/header.php'); 
?>
<?php if(is_post_request()) {
    $user = [];
    $user['email'] = $_POST['email'] ?? '';
    $user['pswrd'] = $_POST['pswrd'] ?? '';
    $user['fName'] = $_POST['fName'] ?? '';
    $user['lName'] = $_POST['lName'] ?? '';
    $user['govId'] = $_POST['govId'] ?? '';
    $user['dept'] = $_POST['depart'] ?? '';
    $user['postn'] = $_POST['pos'] ?? '';
    $user['visible'] = '0';
        
    $result = insert_user($user);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "The User Created Successfully";
        redirect_to(url_to('/public/user/new_view.php?id=' . $new_id));
    } else {
        $errors = $result;
    }
}
?>
<div id="page">
<div id="content">

  <div class="subject new">
    <h1>Create an Account</h1>

    <?php 
    if(!isset($errors)){
        $errors = "";
    }
    echo report_set_error($errors); 
    ?>

    <form action="<?php echo url_to('/public/user/new_user.php'); ?>" method="post">
      <dl>
        <dt>Email:</dt>
        <dd><input type="email" name="email" value="" /></dd>
      </dl>
          
      <dl>
        <dt>Password:</dt>
        <dd><input type="password" name="pswrd" value="" /></dd>
      </dl>
          
      <dl>
        <dt>First Name:</dt>
        <dd><input type="text" name="fName" value="" /></dd>
      </dl>
      <dl>
      
      <dl>
        <dt>Last Name:</dt>
        <dd><input type="text" name="lName" value="" /></dd>
      </dl>
      <dl>
          
      <dl>
        <dt>Government ID Number</dt>
        <dd><input type="text" name="govId" value="" /></dd>
      </dl>
      <dl>
          
        <dl>
        <dt>Department</dt>
        <dd>
            <select name='depart'>
                <option value="Police">Police</option>
                <option value="Government service">Government Service</option>
                <option value="Politics">Political Officer</option>
            </select>
        </dd>
        </dl>
      <dl>
          
      <dl>
        <dt>Position</dt>
        <dd><input type="text" name="pos" value="" /></dd>
      </dl>

      <div id="operations">
        <input type="submit" value="Create User" />
      </div>
    </form>

  </div>

</div>
</div>

<?php require(SHARED . '/footer.php');  ?>
