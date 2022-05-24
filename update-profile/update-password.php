<?php 
//start sesssion and connect database
session_start();
include('../model/connection.php');
//Define error messages
$missingCurrentPassword = '<p><strong>Please enter your Current Password!</strong></p>';
$incorrectCurrentPassword = '<p><strong>The password entered is incorrect!</strong></p>';
$missingPassword = '<p><strong>Please enter a new Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
//Check for errors
$errors="";
if(empty($_POST['currentPassword'])){
    $errors .= $missingCurrentPassword;
}else{
    $currentPassword = $_POST['currentPassword'];
    $currentPassword = filter_var($currentPassword,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $currentPassword = mysqli_real_escape_string($link,$currentPassword);//prepare the variable for sql query
    $currentPassword = hash('sha256',$currentPassword);
    //Check if given password is correct
    $user_id=$_SESSION['user_id'];
    $sql = "SELECT password FROM users WHERE `user_id`='$user_id'";
    $result = mysqli_query($link,$sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query.</div>';
    }else{
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($currentPassword != $row['password']){
            $errors .= $incorrectCurrentPassword;
        }
    }
}
if(empty($_POST['password'])){
    $errors .= $missingPassword;
}else if(!(strlen($_POST['password']) > 6 AND preg_match('/[A-Z]/',$_POST['password']) AND preg_match('/[0-9]/',$_POST['password']))){
    $errors .= $invalidPassword;
}else{
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($_POST['confirmPassword'])){
        $errors .= $missingPassword2;
    }else{
        $password2 = $_POST['confirmPassword'];
        $password2 = filter_var($password2,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}
//if there is an error print error message
$resultMessage="";
if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
}else{
    $password = mysqli_real_escape_string($link,$password);//escape special char before sql query
    $password = hash('sha256',$password);

    //else run query and update password
    $sql = "UPDATE users SET `password`='$password' WHERE `user_id`='$user_id'";
    $result = mysqli_query($link,$sql);
    if(!$result){
        echo "<div class='alert alert-danger'>The password could not be reset. Please try again later.</div>";
    }else{
        echo "<div class='alert alert-success'>The password has been updated successfully.</div>";

    }
}
