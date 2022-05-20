<?php 
//This file will take care of signup process once user fill and submit the signup form
// echo "success";//test
//Start a session
session_start();
//Connect to the database
include('../model/connection.php');
//Check users inputs
    //define error messages
    $missingUsername = '<p><strong>Please enter a username!</strong></p>';
    $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
    $invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
    $missingPassword = '<p><strong>Please enter a Password!</strong></p>';
    $invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
    $differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
    $missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';
    //Get username, email, password, password2
    $errors=$username=$email=$password="";
    //Get username
    if(empty($_POST["username"])){
        //if username is missing/empty. Be careful the isset return true as we provide an empty field.
        $errors .= $missingUsername;
    }else{
        $username = filter_var($_POST["username"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    //Get email
    if(empty($_POST['email'])){
        $errors .= $missingEmail;
    }else{
        //email is set correctly
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        //Check if email is valid
        if(!filter_var($_POST['email'],FILTER_SANITIZE_EMAIL)){
            $errors .= $invalidEmail;
        }
    }
    //Get passwords
    if(empty($_POST['password'])){
        $errors .= $missingPassword;
    }else if(!(strlen($_POST['password']) > 6 and preg_match('/[A-Z]/',$_POST['password']) and preg_match('/[0-9]/',$_POST['password']))){
        $errors .= $invalidPassword;
    }else{
        $password = filter_var($_POST['password'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //same check for password2
        if(empty($_POST['password2'])){
            $errors .= $missingPassword2;
        }else{
            //we filter the password 2 and CHECK IF PASSWORD AND PASSWORD2 MATCH!!
            $password2 = filter_var($_POST['password2'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //compare password and password2
            if($password !== $password2){
                $errors .= $differentPassword;
            }
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
$username = mysqli_real_escape_string($link,$username);//this method escape special characters for use in SQL statement
$email = mysqli_real_escape_string($link,$email);
$password = mysqli_real_escape_string($link,$password);
//Hash the password before to store in the database (good practice). With md5 collision still possible as it's less secure fn.
//$password = md5($password);//md5() use a hash algorithm to hash the password. The output is 128 bits longs => means 32 characters.
$password = hash('sha256',$password);//256bits => 64 character : we need to change number of character in the database for password field (length:64).
//If username exists  in the users table print error
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($link,$sql);//$result store data fetch by query if it's not succeed, $result store "false".
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">Error running the query!</div>';
    // echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';//show error and help in debuging
    exit;//Exit and stop the script in case of error
}
$results = mysqli_num_rows($result);//this method return the number of rows
if($results){
    echo '<div>That username is already registered.Do you want to log in ?</div>';
    exit;
}
//If email exists in the user table print error
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($link,$sql);//$result store data fetch by query if it's not succeed, $result store "false".
if(!$result){
    //if query is not successful (result is false), Always check if the query succeed before using data retrieve
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;//Exit and stop the script in case of error
}
$results = mysqli_num_rows($result);//this method return the number of rows
if($results){
    echo '<div>That email is already registered.Do you want to log in ?</div>';
    exit;
}
//Create a unique activation code by converting binary to hexadecimal (and each character have an hexadecimal number).
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));//byte:unit of data = 8 bits so 16*8=128 bits (bit= 0 or 1) binary.
//16 bytes = 16*8=128 bits
//(2*2*2*2)*2*.....*2
//16*16*......*16
//32 characters

//Insert user details and activation code in the users table
$sql = "INSERT INTO users (username,email,password,activation) VALUES ('$username','$email','$password','$activationKey')";
$result = mysqli_query($link,$sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
    exit;
}
//Send the user an email with a link to activate.php with their email and activation code
$message = "Please click on this link to activate your account:\n\n";
$message .= "http://online-note-app/vue/activation-page.php?email=" . urlencode($email) . "&key=$activationKey";//we have to encode the email before sending it through the url
if(mail($email,'Confirm your Registration', $message, 'From:'.'joankouloumba90@gmail.com')){
    echo '<div class="alert alert-success">Thank you for your registring! A confirmation email has been sent to ' . $email . '. Please click on the activation link to activate your account.</div>';
}