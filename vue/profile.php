<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
}
include('../model/connection.php');
$user_id = $_SESSION['user_id'];
// var_dump($user_id);
//get username and email
$sql = "SELECT * FROM users WHERE `user_id`='$user_id'";
$result = mysqli_query($link,$sql);
$count = mysqli_num_rows($result);
if($count == 1){
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);//transform an sql table entry (line) to a associative array line=[field=>value,...]
   $username = $row['username'];
   $email = $row['email']; 
}else{
    echo "There was an error retrieving the username and email from the database.";
}
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
    <link rel="stylesheet" href="../css/style.css">
    <!--favicon-->
    <link rel="shortcut icon" type="image/png"  href="../img/favicon_io/logo-makr.png"/>
    <!--GOOGLE FONTS ARVO-->
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
    <!--Fontawesome-->
    <script
      src="https://kit.fontawesome.com/52339f9582.js"
      crossorigin="anonymous"
    ></script>

    <title>Profiles</title>
  </head>
  <body class="profileBody">
      <!--NAVIGATION-->
      <nav role="navigation" class="navbar navbar-expand-md navbar-light fixed-top">
          <div class="container-fluid">
                <a class="navbar-brand" href="">Online Notes</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
            <div class="navbar-collapse colapse d-md-flex justify-content-between mt-2" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="./profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://joan-kouloumba.in/professional-site/html/contact.php" target="_blank">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="./mainpage.php">My Notes</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#" >Logged in as <b><?php echo $username ?></b></a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php?logout=1" >Log out</a></li>
                </ul>
            </div>
          </div>
      </nav>
    
    
    <div class="table-responsive container allContainer">
        <div class="row">
            <div class="profile offset-md-2 col-md-8 col-12 p-3 rounded">  
                <h1>General Account Settings</h1>
                <table class="table table-hover table-condensed table-bordered">
                    <tr data-bs-target="#updateUsername" data-bs-toggle="modal">
                        <td>Username</td>
                        <td><?php echo $username; ?></td>
                    </tr>
                    <tr data-bs-target="#updateEmail" data-bs-toggle="modal">
                        <td>Email</td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr data-bs-target="#updatePassword" data-bs-toggle="modal">
                        <td>Password</td>
                        <td>hidden</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div id="deleteAccountMessage"><!--Fill by php echo --></div>
        <form id="deleteAccountForm" data="<?php echo $user_id; ?>" method="POST" class="col-6 offset-md-2">
            <input type="submit" name="deleteAccount" class="btn btn-lg btn-danger deleteUser" value="Delete my account">
        </form>
    </div>
    

    <!--UPDATE USERNAME FORM-->
    <form id="updateUsernameForm" method="POST">
        <div class="modal fade" id="updateUsername" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="updateUsernameMessage">
                        <?php //Update username message from PHP file! ?>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center">
                        <div>
                            <input type="submit" name="updateUsername" class="btn green" value="Submit">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--UPDATE EMAIL FORM-->
    <form id="updateEmailForm" action="index.php" method="POST">
        <div class="modal fade" id="updateEmail" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter new email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="updateEmailMessage">
                        <?php //update email message from PHP file! ?>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center">
                        <div>
                            <input type="submit" name="updateUsername" class="btn green" value="Submit">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--UPDATE PASSWORD FORM-->
    <form id="updatePasswordForm" action="index.php" method="POST">
        <div class="modal fade" id="updatePassword" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter Current and New password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="updatePasswordMessage">
                        <?php //Login message from PHP file! ?>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label class="sr-only" for="currentPassword">Your current password:</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Your current password" maxlength="30">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="password">Choose a password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Choose a password" maxlength="30">
                        </div>
                        <div class="form-group mt-3">
                            <label class="sr-only" for="confirmPassword">Confirm password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" maxlength="30">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center">
                        <div>
                            <input type="submit" name="updateUsername" class="btn green" value="Submit">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div> 
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
    <script src="../js/profile.js"></script>
  </body>
</html>