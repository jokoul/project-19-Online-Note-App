<?php
//This file is used to delete a note
session_start();
include('../model/connection.php');

//Get the id of the note through AJAX
$note_id = $_POST['id'];
//Run the query to delete the note
$sql = "DELETE FROM notes WHERE id='$note_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo 'error';
}
