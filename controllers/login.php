<?php
//that file processes the logging data
//first we start a session
session_start();
//Connect to the database
include('../model/connection.php');
//Check user inputs
    //Define error messages
    $missingEmail = '<p><strong>Please enter your email address!.</strong></p>';
    $missingPassword = '<p><strong>Please enter your password.</strong></p>';
    //Get email and password
    //Store errors in errors variables
    $errors=$email=$password="";
    if(empty($_POST['loginemail'])){
        $errors .= $missingEmail;
    }else{
        $email = filter_var($_POST['loginemail'],FILTER_SANITIZE_EMAIL);//in login case, no need to validate the email
    }
    if(empty($_POST['loginpassword'])){
        $errors .= $missingPassword;
    }else{
        $password = filter_var($_POST['loginpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);//in login case, no need to validate the email
    }
//If there are any errors
$resultMessage = "";
if($errors){
    //Print error message
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
}else{
    //Else, No errors found
    //Prepare two variable for the SQL query
    $email = mysqli_real_escape_string($link,$email);//escape special character in the string before SQL statement.
    $password = mysqli_real_escape_string($link,$password);
    $password = hash('sha256',$password);//hash password with sha256 algorithm is more secure than md5 and limit risk of collision (same output pasword hashed) 
    
    //Run query: Check combination of email & password exists
    $sql = "SELECT  * FROM users WHERE email='$email' AND password='$password' AND activation='activated'";//the account should be activated
    $result = mysqli_query($link,$sql);
    //Best practice is to check if the query run successfully before using the result
    if(!$result){
        echo '<div class="alert alert-danger">Error running the query!</div>';
        exit;
    }
    //If email & password don't match, print error
    $count = mysqli_num_rows($result);//get the number of row in a result sql output.
    if($count !== 1){
        echo '<div class="alert alert-danger">Wrong Email or Password.</div>';
    }else{
        //if $count == 1, Log the user in 
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);//Fetch the next row of a result set as an associative, a numeric array or both.
        //To Log our user, we set SESSION variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        if(empty($_POST['rememberme'])){
            //If "remember me" is not checked
            echo "success";
        }else{
            //If "remember me" is checked, Create 2 variables $authentificator1 and $authentificator2
            $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));//openssl_random_pseudo_bytes take as parameter the number of bytes wanted for the generated pseudo-random string.
            //10bytes= 2*2*...*2(80 times becaue 1 byte=8bits with each bit as binary 0/1) 
            //base 16 = 2*2*2*2(4times); character hexadecimal number representation is in base 16.
            //so 80 / 4 = 20;
            //So we need to set char(20) as the type of our column inside rememberme table
            $authentificator2 = openssl_random_pseudo_bytes(20);
            //Store them in a cookie we gonna create
             function f1($a,$b){
              $c = $a . ',' . bin2hex($b);
              return $c;
            }
            $cookieValue = f1($authentificator1,$authentificator2);
            setcookie(
                "rememberme",
                $cookieValue,
                time() + 1296000, //expiration date of the cookie is set at 15 days in seconds (15*24*60*60) from the creation date defined in timestamp
                "/"
            );
            //Run query to store them in rememberme table
            //prepare variables before the query
            function f2($a){
                $b = hash('sha256',$a);//hash output is 256 bits / 4 = 64 So type of column f2authentificator2 in the table is char(64).
                return $b;
            }
            $f2authentificator2 = f2($authentificator2);
            $user_id = $_SESSION['user_id'];
            $expiration = date('Y-m-d H:i:s', time() + 1296000); //we format the expiring date of the cookie as expected by the database.
            $sql = "INSERT INTO rememberme(`authentificator1`,`f2authentificator2`,`user_id`,`expires`) VALUES ('$authentificator1','$f2authentificator2','$user_id','$expiration')";
            $result = mysqli_query($link,$sql);
            if(!$result){
                //result return false
                echo '<div>There was an error storing data to remember you next time.</div>';
            }else{
                //result succeed
                echo "success";
            }
        } 
    }
}