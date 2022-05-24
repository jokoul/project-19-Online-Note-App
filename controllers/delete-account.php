<?php 
//start session and connect to database
session_start();
include('../model/connection.php');
//Get the user_id
$user_id = $_POST['user_id'];
var_dump($user_id);
//Run the query to delete user account
$sql = "DELETE FROM users WHERE `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo 'error';
}
//after deleting user account, delete all rows linked to the user_id
//clean rememberme table
$sql = "DELETE FROM rememberme WHERE `user_id`='$user_id'";
$resultRemember = mysqli_query($link,$sql);
if(!$resultRemember){
    echo 'error';
}
//clean notes table
$sql = "DELETE FROM notes WHERE `user_id`='$user_id'";
$resultNotes = mysqli_query($link,$sql);
if(!$resultNotes){
    echo 'error';
}
//clean forgotpassword table
$sql = "DELETE FROM forgotpassword WHERE `user_id`='$user_id'";
$resultForgot = mysqli_query($link,$sql);
if(!$resultForgot){
    echo 'error';
}
//Redirect User to landpage
// header('Location: ../index.php');