<?php 
//That file is used to direct user once they click on the activation link that they will receive by email after sign up.
//The user is re-directed to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation key

include('../model/connection.php');
//If user_id or activation key is missing show an error
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by eamil.</div>';
    exit;
}
//else (none of them is missing)
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;//we store the time 24 hours ago to check later if the key is still valid. The key is set for 24 hours.
//Prepare variables for the query
$user_id = mysqli_real_escape_string($link,$user_id);//we clean it to avoid sql injection
$key = mysqli_real_escape_string($link,$key);
//Run query: check combination of user_id and key exists and less than 24h old.
$sql = "SELECT `user_id` FROM forgotpassword WHERE `resetkey`='$key' AND `user_id`='$user_id' AND `time` > '$time' AND `status`='pending'";
$result = mysqli_query($link,$sql);
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;//Exit and stop the script in case of error
}
//If combination does not exists, show an error message
$count = mysqli_num_rows($result);//Gets the number of rows in a result
if($count !== 1){
    echo '<div class="alert alert-danger">Please try again.</div>';
    exit;
}
//If count success, print reset password form with hidden user_id and key fields
echo '
    <form method="POST" id="passwordReset">
        <input type="hidden" name="key" value="' . $key . '">
        <input type="hidden" name="user_id" value="' . $user_id . '">
        <div class="form-group">
            <label for="password">Enter your new password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password2">Re-enter your password:</label>
            <input type="password" id="password2" name="password2" placeholder="Re-enter Password" class="form-control">
        </div>
        <input type="submit" name="resetpassword" class="btn btn-lg btn-success mt-3" value="Reset Password">
    </form>
';



