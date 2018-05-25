<?php
//This is the function which use to declare path to specific file
function url_to($path) {
    //add '/' infront on $path url if it not exist
    if($path[0] != '/') {
        $path = "/" . $path;
    }

    return WWW_ROOT . $path;
}

//URL decoding method
function uc($string) {
    return urlencode($string);
}

//data validation by avoid passing script in URL
function hsc($string) {
    return htmlspecialchars($string);
}


function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function report_set_error($errors=array()) {
    $report = '';
    if(!empty($errors)) {
        $report .= "<div class=\"errors\">";
        $report .= "Please fix errors listed below:";
        $report .= "<ul>";
        foreach ($errors as $error) {
            $report .= "<li>" . hsc($error) . "</li>";
        }
        $report .= "</ul>";
        $report .= "</div>";
    }
    return $report;
}

function swap_and_clear_session() {
    if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }
}

function display_message_session() {
    $message = swap_and_clear_session();
    if(!check_blank($message)) {
        return '<div id="message">' . hsc($message) . '</div>';
    }
} 
