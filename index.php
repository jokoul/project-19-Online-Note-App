<?php
session_start();

include('./model/connection.php');
//logout
include('./controllers/logout.php');
//remember me
include('./controllers/remember.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style-->
    <link rel="stylesheet" href="./css/style.css">
    <!--favicon-->
    <link rel="shortcut icon" type="image/png"  href="./img/favicon_io/logo-makr.png"/>
    <!--GOOGLE FONTS ARVO-->
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
    <!--Fontawesome-->
    <script
      src="https://kit.fontawesome.com/52339f9582.js"
      crossorigin="anonymous"
    ></script>

    <title>Online-Note-App</title>
  </head>
  <body class="homeBody">
      <!--NAVIGATION-->
      <nav role="navigation" class="navbar navbar-expand-md navbar-light fixed-top">
          <div class="container-fluid">
                <a class="navbar-brand" href="./vue/mainpage.php">Online Notes</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
            <div class="navbar-collapse colapse d-md-flex justify-content-between mt-2" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#loginModal" data-bs-toggle="modal">Login</a></li>
                </ul>
            </div>
          </div>
      </nav>
    
    <!--JUMBOTRON-->
    <div class="jumbotron d-flex flex-column justify-content-center align-items-center offset-2 col-8 text-center" id="myContainer">
    <h1>Online Notes App</h1>
    <p>Your Notes with you wherever you go. <br> Easy to use, protects all your notes!</p>
    <button type="button" class="btn btn-lg signup green" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up It's free</button>
    </div>

    <!--LOGIN FORM-->
    <form id="loginForm" action="index.php" method="POST">
        <div class="modal fade" id="loginModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login :</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="loginMessage">
                        <?php //Login message from PHP file! ?>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="loginemail">E-mail:</label>
                            <input type="email" class="form-control" id="loginemail" name="loginemail" placeholder="Email" maxlength="50">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="loginpassword">Password:</label>
                            <input type="password" class="form-control" id="loginpassword" name="loginpassword" placeholder="Password" maxlength="30">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme">
                                <label class="form-check-label" for="rememberme">Remember me</label>
                            </div>
                            <a data-bs-dismiss="modal" data-bs-toggle="modal" href="#forgotPasswordModal">Forgot password ?</a>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Register</button>
                        <div>
                            <input type="submit" name="login" class="btn green" value="Login">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--FORGOT PASSWORD FORM-->
    <form id="forgotPasswordForm" action="index.php" method="POST">
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password ? Enter your email address :</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="forgotMessage">
                        <?php //forgot password message from PHP file! ?>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="forgotemail">E-mail:</label>
                            <input type="email" class="form-control" id="forgotemail" name="forgotemail" placeholder="Email" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Register</button>
                        <div>
                            <input type="submit" name="forgotpassword" class="btn green" value="Submit">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--SIGN UP FORM-->
    <form id="signupForm"  method="POST">
        <div class="modal fade" id="signupModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sign up today and Start using our Online Notes App!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="signupMessage"><!--Signup message from PHP file!--></div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="username" maxlength="30">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" maxlength="50">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="password">Choose a password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Choose a password" maxlength="30">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="password2">Confirm password:</label>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm password" maxlength="30">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="signup" class="btn green" value="Sign up">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--FOOTER-->
    <footer class="footer">
      <p>Online Notes, Copyright &copy; <?php $date = date("Y"); echo $date ?> develop by Joan Kouloumba</p>
      <div>
        <ul class="social-media">
          <li>
            <a
              href="https://www.linkedin.com/in/joan-kouloumba-570a7680/"
              target="_blank"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </li>
          <li>
            <a href="https://twitter.com/joanKouloumba" target="_blank"
              ><i class="fa-brands fa-twitter"></i
            ></a>
          </li>
          <li>
            <a href="https://github.com/jokoul" target="_blank"
              ><i class="fa-brands fa-github"></i
            ></a>
          </li>
        </ul>
        <p>
          <a
            href="https://joan-kouloumba.in/professional-site/index.html#achievements"
            >Visit more site like this on the professional site.</a
          >
        </p>
      </div>
    </footer>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--jQuery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!--script-->
    <script src="./JS/index.js"></script>
  </body>
</html>