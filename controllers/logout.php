<?php
//this file processes the logout
if(isset($_SESSION['user_id']) && isset($_GET['logout']) && $_GET['logout'] == 1){
    session_destroy();//destroy session
    //destroy cookie
    setcookie('rememberme',"", time()-3600);//we set a past time and empty value 
}