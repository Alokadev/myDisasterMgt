<?php

//function for users table
function find_all_users($pageNum) {
global $db; 
$sql = "SELECT * FROM users ";
$sql .= "ORDER BY id DESC ";
$sql .= "LIMIT $pageNum,10";
$user_set = mysqli_query($db, $sql);
confirm_result_set($user_set);
return $user_set;
}

function get_users_pages_num() {
global $db; 
$sql = "SELECT * FROM users";
$result = mysqli_query($db, $sql);
$countRows = mysqli_num_rows($result);
$recPerPage = $countRows/10;
$numPage = ceil($recPerPage);
return $numPage;   
}

function find_user_by_id($id) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id = '" . $id . "'";
    $info = mysqli_query($db, $sql);
    confirm_result_set($info);
    $user = mysqli_fetch_assoc($info);
    mysqli_free_result($info);
    return $user;
}

function find_admin_by_email($useremail) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email = '" . $useremail . "'";
    $sql .= "AND visible = '1' ";
    $sql .= "AND postn = 'admin';";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin;
}

function find_user_by_email($useremail) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email = '" . $useremail . "' ";
    $sql .= "AND visible = '1';";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
}

function validate_user($user){
    $errors = [];
    //email
    if(check_blank($user['email'])) {
        $errors[] = "Email Cannot be blank.";
    } elseif(!check_lenght($user['email'], array('max' => 100 ))) {
        $errors[] = "Email Must Have less than 100 characters";
    }elseif(!check_valid_email($user['email'])) {
        $errors[] = "Not  a Valid Email";
    }

    
    if(check_blank($user['pswrd'])) {
        $errors[] = "Password cannot be blank";
    }
    if(check_blank($user['fName'])) {
        $errors[] = "First Name cannot be blank";
    }
    
    if(check_blank($user['lName'])) {
        $errors[] = "Last Name cannot be blank";
    }
    
    if(check_blank($user['govId'])) {
        $errors[] = "Government ID cannot be blank";
    }
    
    if(check_blank($user['dept'])) {
        $errors[] = "Department cannot be blank";
    }
    
    if(check_blank($user['postn'])) {
        $errors[] = "Position cannot be blank";
    }    
    
    return $errors;
}

function check_existing_emails($user) {
    $errors = [];
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email = '" . $user . "'";
    $result = mysqli_query($db, $sql);
    $Row = mysqli_num_rows($result);
    if($Row != 0) {    
        $errors[] = "Submitted Email Already Exist";
    }
    return $errors;
}

function insert_user($user) {   
    $errors = validate_user($user);
    if(!empty($errors)) {
        return $errors;
    }
    
    $errors = check_existing_emails($user['email']);
    if(!empty($errors)) {
        return $errors;
    }
    
        
    $user['pswrd'] = password_hash($_POST['pswrd'],PASSWORD_BCRYPT);
    global $db;
    $sql = "INSERT INTO users ";
    $sql .= "(email,pswrd,fName,lName,govId,dept,postn,visible) ";
    $sql .= "VALUES (";
    $sql .= "'". $user['email'] . "',";
    $sql .= "'" . $user['pswrd'] . "',";
    $sql .= "'" . $user['fName'] . "',";
    $sql .= "'" . $user['lName'] . "',";
    $sql .= "'" . $user['govId'] . "',";
    $sql .= "'" . $user['dept'] . "',";
    $sql .= "'" . $user['postn'] . "',";
    $sql .= "'" . $user['visible'] . "' ";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    if($result) {
        return true;
    }else {
        //echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user($user) {
    
    $errors = validate_user($user);
    if(!empty($errors)) {
        return $errors;
    }
    $user['pswrd'] = password_hash($user['pswrd'],PASSWORD_BCRYPT);
    global $db;
    $sql = "UPDATE users SET ";
    $sql .= "email='" . $user['email'] . "', ";
    $sql .= "pswrd='" . $user['pswrd'] . "', ";
    $sql .= "fName='" . $user['fName'] . "', ";
    $sql .= "lName='" . $user['lName'] . "', ";
    $sql .= "govId='" . $user['govId'] . "', ";
    $sql .= "dept='" . $user['dept'] . "', ";
    $sql .= "postn='" . $user['postn'] . "' ";
    $sql .= "WHERE id='" . $user['id'] . "' ";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    if($result) {
        return true;
    } else {
        echo mysqli_error($db);
        $db_disconnect($db); 
        exit;
    }
}

function delete_user($id) {
    global $db;
    $sql = "DELETE FROM users ";
    $sql .= "WHERE id='" . $id . "'";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    
    if($result) {
        return true;
    } else {
        echo mysqli_error($db);
        $db_disconnect($db);
        exit;
    }
}

function grant_user($id) {
    global $db;
    $user = find_user_by_id($id);
    if ($user['visible'] == 1) {
        $user['visible'] = 0;
    } else if ($user['visible'] == 0) {
        $user['visible'] = 1;
    }
    $sql = "UPDATE users SET ";
    $sql .= "visible='" . $user['visible'] . "'";
    $sql .= "WHERE id='" . $id . "' ";
    $result = mysqli_query($db, $sql);
    if ($result) {
        true;
    } else {
    echo mysqli_error($db);
    $db_disconnect($db);
    exit;
    }
}


//functions for content table

function validate_content($content){
    $errors = [];

    if(check_blank($content['InciType'])) {
        $errors[] = "Incident cannot be blank";
    }
    
    if(check_blank($content['imageData'])) {
        if(check_blank($content['properties'])) {
    }
        $errors[] = "Please insert an image";
    }
   
    if(check_blank($content['lat'])) {
        $errors[] = "Please Mark location Correctly";
    }
    
    if(check_blank($content['content'])) {
        $errors[] = "Please give some information about Incident";
    } elseif(!check_lenght($content['content'], array('max' => 300 ))) {
        $errors[] = "Description must less than 300 letters";
    } elseif(!check_lenght($content['content'], array('min' => 20 ))) {
        $errors[] = "Description must Higher than 20 letters";
    }
    return $errors;
}

function insert_content($content) {
    
    $errors = validate_content($content);
    
    if(!empty($errors)) {
        return $errors;
    }
    
    global $db;
    $sql = "INSERT INTO content ";
    $sql .= "(p_id,InciType,imgData,image,lat,lon,visible,content) ";
    $sql .= "VALUES (";
    $sql .= "'". $content['Uid'] . "',";
    $sql .= "'" . $content['InciType'] . "',";
    $sql .= "'" . $contet['imageData'] . "',";
    $sql .= "'" . $content['properties'] . "',";
    $sql .= "'" . $content['lat'] . "',";
    $sql .= "'" . $content['lon'] . "',";
    $sql .= "'" . $content['visible'] . "', ";
    $sql .= "'" . $content['content'] . "' ";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    if($result) {
    return true;
    }else {
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
    }
}

function update_content($content) { 
    
    $errors = validate_content($content);
    
    if(!empty($errors)) {
        return $errors;
    }
    
    global $db;   
    $sql = "UPDATE content SET ";
    $sql .= "InciType='" . $content['InciType'] . "', ";
    $sql .= "imgData='" . $content['imageData'] . "', ";
    $sql .= "image='" . $content['properties'] . "', ";
    $sql .= "lat='" . $content['lat'] . "', ";
    $sql .= "lon='" . $content['lon'] . "', ";
    $sql .= "visible='" . $content['visible'] . "', ";
    $sql .= "content='" . $content['content'] . "' ";
    $sql .= "WHERE contentId='" . $content['contentId'] . "' ";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    if($result) {
        true;
    } else {
        echo mysqli_error($db);
        $db_disconnect($db); 
        exit;
    }
}


function find_content_by_id($id) {
    global $db;
    $sql = "SELECT * FROM content ";
    $sql .= "WHERE contentId = '" . $id . "'";
    $info = mysqli_query($db, $sql);
    confirm_result_set($info);
    $content = mysqli_fetch_assoc($info);
    return $content;
}

function find_all_content_pid_page($id) {
    global $db;
    $sql = "SELECT * FROM content ";
    $sql .= "WHERE p_id = '" . $id . "' ";
    $result = mysqli_query($db, $sql);
    $countRows = mysqli_num_rows($result);
    $recPerPage = $countRows/5;
    $numPage = ceil($recPerPage);
    return $numPage;
}

function find_all_content_pid($id,$pageNum){
    global $db; 
    $sql = "SELECT * FROM content ";
    $sql .= "WHERE p_id = '" . $id . "' ";
    $sql .= "ORDER BY contentId DESC ";
    $sql .= "LIMIT $pageNum,5";
    $content_set = mysqli_query($db, $sql);
    confirm_result_set($content_set);
    return $content_set;
}


function grant_content($id,$visible,$status){
    global $db;
    $content = find_content_by_id($id);

    $sql = "UPDATE content SET ";
    $sql .= "visible='" . $visible . "', ";
    $sql .= "status='" . $status . "' ";
    $sql .= "WHERE contentId='" . $id . "' ";
  
    $result = mysqli_query($db, $sql);
    if ($result) {
        true;
    } else {
    echo mysqli_error($db);
    $db_disconnect($db);
    exit;
    }
}

function find_all_content($pageNum){
    global $db; 
    $sql = "SELECT * FROM content ";
    $sql .= "ORDER BY contentId DESC ";
    $sql .= "LIMIT $pageNum,5";
    $content_set = mysqli_query($db, $sql);
    confirm_result_set($content_set);
    return $content_set;
}

function delete_content($id) {
    global $db;
    $sql = "DELETE FROM content ";
    $sql .= "WHERE contentId='" . $id . "'";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    
    if($result) {
        return true;
    } else {
        echo mysqli_error($db);
        $db_disconnect($db);
        exit;
    }  
}

function get_content_pages_num() {
    global $db;
    $sql = "SELECT * FROM content";
    $result = mysqli_query($db, $sql);
    $countRows = mysqli_num_rows($result);
    $recPerPage = $countRows/5;
    $numPage = ceil($recPerPage);
    return $numPage;
}

//function for display (view display)

function find_all_displays($pageNum) {
    global $db; 
    $sql = "SELECT * FROM display ";
    $sql .= "ORDER BY cDate DESC ";
    $sql .= "LIMIT $pageNum,5";
    $display_set = mysqli_query($db, $sql);
    confirm_result_set($display_set);
    return $display_set;
}

function find_all_displays_loc() {
    global $db; 
    $sql = "SELECT * FROM display ";
    $display_set = mysqli_query($db, $sql);
    confirm_result_set($display_set);
    return $display_set;
}

function get_displays_pages_num() {
    global $db; 
    $sql = "SELECT * FROM display";
    $result = mysqli_query($db, $sql);
    $countRows = mysqli_num_rows($result);
    $recPerPage = $countRows/5;
    $numPage = ceil($recPerPage);
    return $numPage;   
}

function find_display_by_id($id) {
    global $db;
    $sql = "SELECT * FROM display ";
    $sql .= "WHERE contentId = '" . $id . "'";
    $info = mysqli_query($db, $sql);
    confirm_result_set($info);
    $result = mysqli_fetch_assoc($info);
    mysqli_free_result($info);
    return $result;  
}

function find_by_incident($condition) {
    global $db;
    $sql = "SELECT * FROM display ";
    $sql .= "WHERE InciType = '" . $condition . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_incidentnum() {
    global $db;
    $sql = "SELECT InciType, COUNT(*) AS number ";
    $sql .= "FROM display GROUP BY InciType";
    $result = mysqli_query($db, $sql);
    return $result;
}