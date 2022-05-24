<?php 
//start session and connect
session_start();
include('../model/connection.php');
//Get user_id and new email sent through AJAX
$user_id = $_SESSION['user_id'];
$newEmail = $_POST['email'];
//Check if new email exists
$sql = "SELECT email FROM users WHERE email='$newEmail'";
$result = mysqli_query($link,$sql);
$count = mysqli_num_rows($result);
if($count>0){
    echo "<div>There is already a user registered with that email. Please choose another one.</idv>";
    exit;
}
//Get the current email 
$sql = "SELECT * FROM users WHERE `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
$count = mysqli_num_rows($result);
if($count == 1){
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);//transform an sql table entry (line) to a associative array line=[field=>value,...]
   $email = $row['email']; 
}else{
    echo "There was an error retrieving the email and email from the database.";
    exit;//We use exit when we want the code to stop 
}
//Create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
//Insert the new activation code in our users table
$sql = "UPDATE users SET activation2='$activationKey' WHERE `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error inserting the user details in the database.</div>';
    exit;
}else{
    //Send email with link to activatenewemail.php with current email,new email and activation code
    $message="Please click on this link to prove that you own this email:\n\n";
    //we mask the email by encoding because it's sensible information that passs through get parameter
    $message.="http://online-note-app/vue/activationnewemailpage.php?email=" . urlencode($email) . "&newemail=" . urlencode($newEmail) . "&key=$activationKey";
    if(mail($newEmail,'Email update for you Online Notes App',$message,'From: '.'joankouloumba90@gmail.com')){
        echo "<div class='alert alert-success'>An email has been send to $newEmail. Please click on the link to prove you own that email address.</div>";
    }
}