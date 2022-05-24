<?php
//start session and connect to database
session_start();
include('../model/connection.php');
mysqli_report(MYSQLI_REPORT_OFF);
//get the user id from session array
$id=$_SESSION['user_id'];
//Get username sent through Ajax
$username = $_POST['username'];
//Run query and updateemail.php
$sql = "UPDATE users SET `username`='$username' WHERE `user_id`='$id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error storing the new username in the database.</div>';
}