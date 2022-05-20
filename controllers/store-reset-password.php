<?php
//that file processes new password and store it in the table of the database.
// echo 'TEST!';
session_start();
include('../model/connection.php');
//If user_id or reset key is missing show an error
if(!isset($_POST['user_id']) || !isset($_POST['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by eamil.</div>';
    exit;
}
//else (none of them is missing)
$user_id = $_POST['user_id'];
$key = $_POST['key'];
$time = time() - 86400;//we store the time 24 hours ago to check later if the key is still valid. The key is set for 24 hours.
//Prepare variables for the query
$user_id = mysqli_real_escape_string($link,$user_id);//we clean it to avoid sql injection
$key = mysqli_real_escape_string($link,$key);
//Run query: check combination of user_id and key exists and less than 24h old.
$sql = "SELECT `user_id` FROM forgotpassword WHERE `resetkey`='$key' AND `user_id`='$user_id' AND `time` > '$time' AND `status`='pending'";
$result = mysqli_query($link,$sql);
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;//Exit and stop the script in case of error
}
//If combination does not exists, show an error message
$count = mysqli_num_rows($result);//Gets the number of rows in a result
if($count !== 1){
    echo '<div class="alert alert-danger">Please try again.</div>';
    exit;
}
//Define error message
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';
//Get passwords
$errors=$password="";
if(empty($_POST['password'])){
    $errors .= $missingPassword;
}else if(!(strlen($_POST['password']) > 6 and preg_match('/[A-Z]/',$_POST['password']) and preg_match('/[0-9]/',$_POST['password']))){
    $errors .= $invalidPassword;
}else{
    $password = filter_var($_POST['password'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //same check for password2
    if(empty($_POST['password2'])){
        $errors .= $missingPassword2;
    }else{
        //we filter the password 2 and CHECK IF PASSWORD AND PASSWORD2 MATCH!!
        $password2 = filter_var($_POST['password2'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //compare password and password2
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}
//If there are any errors print error
$resultMessage="";
if($errors){
    $resultMessage = '<div class="alert alert-danger"> ' . $errors . '</div>';
    echo $resultMessage;
    exit;
}
//no errors
//Prepare variables for the queries
$user_id = mysqli_real_escape_string($link,$user_id);
$password = mysqli_real_escape_string($link,$password);
//Hash the password before to store in the database (good practice). With md5 collision still possible as it's less secure fn.
//$password = md5($password);//md5() use a hash algorithm to hash the password. The output is 128 bits longs => means 32 characters.
$password = hash('sha256',$password);
//Run query : Update users password in the users table
$sql = "UPDATE users SET `password`='$password' WHERE `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">There was a problem storing the new password in the database!</div>';
    exit;//Exit and stop the script in case of error
}
//Set the key status to "used" in the forgotpassword table to prevent the key from being used twice
$sql = "UPDATE forgotpassword SET `status`='used' WHERE resetkey='$key' AND `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}else{
    echo '<div class="alert alert-success">Your password has been update successfully!<a href="../index.php">Login</a></div>';
}