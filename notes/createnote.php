<?php
//This file is used to create a note
session_start();
include('../model/connection.php');
mysqli_report(MYSQLI_REPORT_OFF);
//Get the user_id to know which user has created the notes
$user_id = $_SESSION['user_id'];
//Get the current time using the time function returning a timestamp
$time = time();
//Run a query to create new note
$sql = "INSERT INTO notes (`user_id`,`note`,`timenote`) VALUES ('$user_id','','$time')";
$result = mysqli_query($link,$sql);
if(!$result){
    echo 'error';
}else{
    //mysqli_insert_id returns the auto generated id used in the last query (in our case $sql just above)
    echo mysqli_insert_id($link);
}