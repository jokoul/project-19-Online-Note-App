<?php 
//That file is used to re-direct user once they click on the activation link that they will receive by email after sign up.
//The user is re-directed to this file after clicking the link received by email and aiming at proving they own the new email address.
//link contains three GET parameters: email, newEmail and activation key

include('../model/connection.php');
//If email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by eamil.</div>';
    exit;
}
//else (none of them is missing)
$email = $_GET['email'];
$newEmail = $_GET['newemail'];
$key = $_GET['key'];
//Prepare variables for the query
$email = mysqli_real_escape_string($link,$email);
$newEmail = mysqli_real_escape_string($link,$newEmail);
$key = mysqli_real_escape_string($link,$key);
//Run query: update email
$sql = "UPDATE users SET `email` = '$newEmail', activation2='0' WHERE (email = '$email' AND activation2 = '$key') LIMIT 1";
$result = mysqli_query($link,$sql);
//If query is successful, show success message and invite user to login
if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie('rememberme','',time()-3600);
    //If the number of affected rows of the last query is equal to one
    echo '<div class="alert alert-success">Your email has been activated. </div>';
    echo '<a type="button" class="btn btn-lg btn-success" href="../index.php">Log in</a>';
}else{
    //show error if the last query failed and mysqli_affected_rows return no corresponding rows
    echo '<div class="alert alert-danger">Your Email could not be updated. Please try again later.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
}