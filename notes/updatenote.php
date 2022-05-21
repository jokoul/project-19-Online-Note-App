<?php
//This file is used to update a note
session_start();
include('../model/connection.php');
// mysqli_report(MYSQLI_REPORT_OFF);
//Get the id of the note sent through AJAX call
$id = $_POST['id'];

//Get the content of the note
$note = $_POST['note'];
echo "UPDATENOTE LINE 11" . $note;
var_dump("UPDATENOTE LINE 11" . $note);
//Get the time to update time column
$time = time();
//Run a query to update the note 
$sql = "UPDATE notes SET `note`='$note', `timenote`='$time' WHERE `id`='$id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo 'error';
}else{
    echo 'REQUETE SUCCEED';
}