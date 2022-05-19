<?php
// unset($_SESSION['user_id']);
//that file processes the data if the user log in or check remember-me box
//If the user is not logged in & rememberme cookie exists
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    //if $_COOKIE rememberme key is not empty and user_id not exists (we can use also this fn to check : array_key_exists('user_id',$_SESSION))
    //function f1 : cookie rememberme content : $a . ',' . bin2hex($b)
    //function f2 : hash('sha256',$a)
    //Extract $authentificator 1 & 2 from the cookie
    //list method assign variables in parameter if they are in an array
     list($authentificator1,$authentificator2) = explode(',',$_COOKIE['rememberme']);//explode is like split in JS, first parameter is separating operator and second is the array itself
     //Convert hexadecimal string to its binary representation.
     $authentificator2 = hex2bin($authentificator2);
     //apply f2 fn to $authentificator2
     $f2authentificator2 = hash('sha256',$authentificator2);
     //Look for authentificator1 in the rememberme table
     $sql = "SELECT * FROM rememberme WHERE authentificator1='$authentificator1'";
     $result = mysqli_query($link,$sql);
     if(!$result){
         echo '<div class="alert alert-danger">There was an error running the query.</div>';
         exit;
     }else{
        $count = mysqli_num_rows($result);//Gets the number of rows in a result
        if($count !== 1){
            echo '<div class="alert alert-danger">Remember me process failed!</div>';
            exit;
        }
        //if $count = 1
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);//Fetch a result row as an associative, a numeric array, or both.
        // var_dump($row['f2authentificator2']);
        // var_dump($row);
        // var_dump($f2authentificator2);
        // var_dump($f2authentificator1);
        //If authentificator2 does not match
        if(!hash_equals($row['f2authentificator2'], $f2authentificator2)){
            //if not equal
            echo '<div class="alert alert-danger">Hash_equals return false!</div>';
        }else{
            //if equal, we log the user and re-direct him to main page
            //generate new tokens (authentificators)
            //Store them in cookie and rememberme table
            $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));//openssl_random_pseudo_bytes take as parameter the number of bytes wanted for the generated pseudo-random string.
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
                time() + 1296000 //expiration date of the cookie is set at 15 days in seconds (15*24*60*60) from the creation date defined in timestamp
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
                echo '<div class="alert alert-danger">There was an error storing data to remember you next time.</div>';
            }
            $_SESSION['user_id'] = $row['user_id'];//we store the user_id in super global session variables.
            header('Location: ../vue/mainpage.php');
        }
     }
}