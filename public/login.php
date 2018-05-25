<?php
require_once '../private/initialize.php';

  if(!isset($title)) { 
      $title = 'Login';      
  }
$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $useremail = $_POST['useremail'] ?? '';
  $password = $_POST['password'] ?? '';

  //login email validation
  if(check_blank($useremail)) {
      $errors[] = "Please Enter Email";
  }elseif(!check_valid_email($useremail)) {
      $errors[] = "Not  a Valid Email";
  }
  
  if(check_blank($password)) {
      $errors[] = "Please Enter Password";
  }
  
  //if there is not error value submit for query
  if(empty($errors)) {
      $admin = find_admin_by_email($useremail);
      $user = find_user_by_email($useremail);
      if($admin) {
          if(password_verify($password, $admin['pswrd'])) {
                log_admin($admin);
                $_SESSION['message'] = "Your are log In";
                redirect_to(url_to('/public/index.php'));
          }else {
                mysqli_free_result($admin);
                $_SESSION['message'] = "Password and Email not Matched";
                redirect_to(url_to('/public/login.php'));
          }
          
      }elseif($user) {
          if(password_verify($password, $user['pswrd'])) {
                log_user($user); 
                $_SESSION['message'] = "Your are log In";
                redirect_to(url_to('/public/user/my_report.php'));
          } else {
              mysqli_free_result($user);
              $_SESSION['message'] = "Password and Email not Matched";
              redirect_to(url_to('/public/login.php'));
          }
      }else {
          $errors[] = "Logging Unsuccessfull";
      }
  }
}

?>

<?php require(SHARED . '/header.php'); ?>

<div id="page">
<div id="content">
<center>
  <h1>Log in Here</h1>
  
      <?php echo report_set_error($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="email" name="useremail" value="<?php echo hsc($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>
</center>
</div>
</div>

<?php require(SHARED . '/footer.php'); ?>   