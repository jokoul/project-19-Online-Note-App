<?php 
//That file is used to direct user once they click on the activation link that they will receive by email after sign up.
//The user is re-directed to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation key

include('../model/connection.php');
//If email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the activation link you received by eamil.</div>';
    exit;
}
//else (none of them is missing)
$email = $_GET['email'];
$key = $_GET['key'];
//Prepare variables for the query
$email = mysqli_real_escape_string($link,$email);
$key = mysqli_real_escape_string($link,$key);
//Run query: set activation field to "activated" for the provided email
$sql = "UPDATE users SET activation = 'activated' WHERE email = '$email' AND activation = '$key' LIMIT 1";
$result = mysqli_query($link,$sql);
//If query is successful, show success message and invite user to login
if(mysqli_affected_rows($link) == 1){
    //If the number of affected rows of the last query is equal to one
    echo '<div class="alert alert-success">Your account has been activated. </div>';
    echo '<a type="button" class="btn btn-lg btn-success" href="../index.php">Log in</a>';
}else{
    //show error if the last query failed and mysqli_affected_rows return no corresponding rows
    echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
}