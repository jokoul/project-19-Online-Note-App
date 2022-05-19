<?php
//this file processes the connection to the database

$link = mysqli_connect("localhost","root","","online-notes-db");
if(mysqli_connect_error()){
    die("ERROR: Unable to connect: " . mysqli_connect_error());
}