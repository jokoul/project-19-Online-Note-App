<?php
//This file is used to load the notes
session_start();
include('../model/connection.php');
//Get the user_id using session variables because after user login we store the user_id in the session array
$user_id = $_SESSION['user_id'];
//Run a query to delete empty notes
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link,$sql);//this request return FALSE or the data so we can use this line to check
if(!$result){
    //if request don't succeed
    echo '<div class="alert alert-warning">An error occured!</div>';
    exit;
}
//Run a query to look for notes corresponding to our user_id and order them by time in descending.
$sql = "SELECT * FROM notes WHERE `user_id`='$user_id' ORDER BY timenote DESC";
//Show notes or alert message
if($result = mysqli_query($link,$sql)){
    //"mysqli_query($link,$sql)" return FALSE or the data so we can use this line to check if the request is successfull
    if(mysqli_num_rows($result) > 0){
        //extract all the user note from result array and store it at the same in row variable which become a associative array.
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            //Show note data
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['timenote'];
            //convert timestamp to date format
            $time = date('F d, Y h:i:s A',$time);
            
            echo "
                <div class='note d-flex justify-content-center align-items-center'>
                    <div class='col-5 col-md-3 delete'>
                        <button class='btn btn-lg btn-danger col-10'>Delete</button>
                    </div>
                    <div class='noteContainer col-12' id='$note_id'>
                        <div class='noteText'>$note</div>
                        <div class='noteDate'>$time</div>
                    </div>
                </div>";
        }
    }else{
        //otherwise, alert message
        echo '<div class="alert alert-warning">You have not created any notes yet!</div>';
        exit;
    }
}else{
    //if FALSE => error message
    echo '<div class="alert alert-warning">An error occured!</div>';
    exit;
    // echo "ERROR: Unable to execute : $sql." . mysqli_error($link);//for debuging purpose we can use mysqli_error that take the link and return error on the las SQL request.
}
