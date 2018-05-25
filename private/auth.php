<?php

//assign values to admin session
function log_admin($admin) {
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $admin['email'];
    return true;
}

//assign values to user session
function log_user($user) {
    session_regenerate_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $user['email'];
    return true;
}

//destroy all the stored infomations in session. this use to destroy user session too
function logout_admin() {
    session_destroy();
    return true;
}

//used in require_login function
function check_logged_in() {
    return isset($_SESSION['admin_id']);
}

//permision for admin's pages
function require_login() {
    if(!check_logged_in()) {
        $_SESSION['message'] = "Only Admin have access to those pages";
      redirect_to(url_to('/public/login.php'));
    } else {
    }
}

//used in user_require_login function
function check_user_logged_in() {
    return isset($_SESSION['user_id']);
}

//permision for admin's pages
function user_require_login() {
    if(!check_user_logged_in()) {
      $_SESSION['message'] = "You don't have access for these pages";
      redirect_to(url_to('/public/login.php'));
    } 
}
