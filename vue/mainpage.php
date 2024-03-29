<?php
//before using session variable
session_start();
//redirect if no session
if(!isset($_SESSION['user_id'])){
  header('Location: ../index.php');
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

    <title>My notes</title>
  </head>
  <body class="mainBody">
      <!--NAVIGATION-->
      <nav role="navigation" class="navbar navbar-expand-md navbar-light fixed-top">
          <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">Online Notes</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
            <div class="navbar-collapse colapse d-md-flex justify-content-between mt-2" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://joan-kouloumba.in/professional-site/html/contact.php" target="_blank">Contact</a></li>
                    <li class="nav-item"><a class="nav-link active" href="mainpage.php">My Notes</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="profile.php" >Logged in as <b><?php echo $_SESSION['username'] ?></b></a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php?logout=1" >Log out</a></li>
                </ul>
            </div>
          </div>
      </nav>
    
    <!--CONTAINER-->
    <div class="container allContainer">
      <div id="alert" class="alert alert-danger alert-dismissible collapse" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <!--Alert message from PHP file-->
        <p id="alertContent"></p>
      </div>
      <div class="row">
          <div class=" offset-md-2 col-md-8 col-12">
              <div class="buttons d-flex justify-content-between mb-3">
                  <div>
                      <button type="button" id="addNote" class="btn btn-lg btn-info">Add Note</button>
                      <button type="button" id="allNotes" class="btn btn-lg btn-info">All Notes</button>
                  </div>
                  <div>

                      <button type="button" id="done" class="btn btn-lg green doneBtn">Done</button>
                      <button type="button" id="edit" class="btn btn-lg btn-info">Edit</button>
                  </div>
              </div>
              <div id="notePad" class="notePad">
                  <textarea rows="10"></textarea>
              </div>
              <div id="notes" class="notes">
                  <!--AJAX call to a php file to populate note div with notes-->
              </div>
          </div>
      </div>
    </div>    

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
    <script src="../js/mynotes.js"></script>
  </body>
</html>