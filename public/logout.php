<?php
require_once '../private/initialize.php';
if(isset($_SESSION['email'])) {
    logout_admin();
    session_start();
    $_SESSION['message'] = "You are log out";
    redirect_to(url_to('/public/login.php'));
} else {
    redirect_to(url_to('/public/login.php'));
} 
