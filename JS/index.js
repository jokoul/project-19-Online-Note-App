//This file will include all the AJAX calls which will use to process the user inputs inside the index.php file.
//AJAX call for the Signup form
//Once the form is submitted
$("#signupForm").submit(function (event) {
  //to prevent default php processing
  event.preventDefault();
  //collect user inputs
  //"this" represent the current object "signupForm" which is submitted.
  //serializeArray() allow to create a javascript array of object ready to be encoded as a JSON string.
  var dataToPost = $(this).serializeArray();
  // console.log(dataToPost);
  // Send them to signup.php using AJAX. There is also the post() method used with done() and fail().
  $.ajax({
    url: "../controllers/signup.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      //if the call success
      if (data) {
        $("#signupMessage").html(data);
      }
    },
    error: function () {
      $("#signupMessage").html(
        '<div class="alert alert-danger"> There was an error with the Ajax Call. Please try again later.</div>'
      );
    },
  });
});
//AJAX call for the login form
//Once the form is submitted
$("#loginForm").submit(function (event) {
  event.preventDefault();
  var dataToPost = $(this).serializeArray();
  $.ajax({
    url: "../controllers/login.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data == "success") {
        window.location = "../vue/mainpage.php";
      }
    },
  });
});
