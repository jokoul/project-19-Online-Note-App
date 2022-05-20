<?php
//We start a session before any line of code that means everytime at the top of the file to avoid errors
session_start();
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

    <title>Reset Password</title>
  </head>
  <body>
      
    <!--CONTAINER-->
    <div class="container mt-5">
        <div class="activation p-5">
            <h1 class="h1">Reset Password</h1>
            <div id="resultMessage"><!--PHP resultMessage--></div>
            <?php include('../controllers/reset-password.php') ?>
        </div>
    </div>
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <!--jQuery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!--AJAX SCRIPT-->
    <script>
      //Script for AJAX call to store-reset-password.php which processes reset password form data
      //Once the form is submitted
        $("#passwordReset").submit(function (event) {
          event.preventDefault();
          var dataToPost = $(this).serializeArray();
          $.ajax({
            url: "../controllers/store-reset-password.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
              $("#resultMessage").html(data);
            },
            error: function () {
              $("#resultMessage").html(
                '<div class="alert alert-danger">There was an error with the Ajax Call. Please try again later.</div>'
              );
            },
          });
        });
    </script>
  </body>
</html>