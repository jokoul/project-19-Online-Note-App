<?php 
// That file processes email of the forgot password form. 
// When the form is submitted, user receive an email with a link to direct them to an other file called reset-password.php 
//start session
session_start();
//Connect to the database
include('../model/connection.php');
//Check user inputs
//Define error message
 $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
 $invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
//get email
$errors="";
    if(empty($_POST['forgotemail'])){
        $errors .= $missingEmail;
    }else{
        //email is set correctly
        $email = filter_var($_POST['forgotemail'],FILTER_SANITIZE_EMAIL);
        //Check if email is valid
        if(!filter_var($_POST['forgotemail'],FILTER_SANITIZE_EMAIL)){
            $errors .= $invalidEmail;
        }
    }
//If there are any errors print error
$resultMessage="";
if($errors){
    $resultMessage = '<div class="alert alert-danger"> ' . $errors . '</div>';
    echo $resultMessage;
    exit;
}
//no errors
//Prepare variables for the queries
$email = mysqli_real_escape_string($link,$email);
//Run query to check if the email exists in the user table
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($link,$sql);//$result store data fetch by query if it's not succeed, $result store "false".
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;//Exit and stop the script in case of error
}
$count = mysqli_num_rows($result);//this method return the number of rows
if(!$count){
    //if count is false (no rows / $count !== 1)
    echo '<div>That email does not exist on our database!</div>';
    exit;
}
//If $count is true 
//get the user_id
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$user_id = $row['user_id'];
//Create a unique activation code by converting binary to hexadecimal (and each character have an hexadecimal number).
$key = bin2hex(openssl_random_pseudo_bytes(16));
//Insert user details and activation code in the forgotpassword table
$time = time();//current time
$status = "pending";//it's gonna stay pending until the key is used
$sql = "INSERT INTO forgotpassword 
(`user_id`,`resetkey`,`time`,`status`)
VALUES
('$user_id','$key','$time','$status')";
$result = mysqli_query($link,$sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
    exit;
}
//Send email with link to resetpassword.php with user id  and activation code
$message = "Please click on this link to reset your password:\n\n";
$message .= "http://online-note-app/vue/reset-password-page.php?user_id=$user_id&key=$key";
if(mail($email,'Reset your password', $message, 'From:'.'joankouloumba90@gmail.com')){
    //If email sent successfully, print success message
    echo '<div class="alert alert-success">An email has been sent to ' . $email . '. Please click on the link to reset your password.</div>';
}