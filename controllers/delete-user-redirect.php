<?php
//After cleaning the database
//destroy session
session_destroy();
//destroy cookie
setcookie('rememberme',"",time()-3600,'/');
