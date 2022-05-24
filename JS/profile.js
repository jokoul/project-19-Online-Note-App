//This file is responsible of AJAX CALL related to the profile
//AJAX call for the update username form
//Once the form is submitted
$("#updateUsernameForm").submit(function (event) {
  //to prevent default php processing
  event.preventDefault();
  //collect user inputs
  //"this" represent the current object "signupForm" which is submitted.
  //serializeArray() allow to create a javascript array of object ready to be encoded as a JSON string.
  var dataToPost = $(this).serializeArray();
  console.log(dataToPost);
  // Send them to update-username.php using AJAX. There is also the post() method used with done() and fail().
  $.ajax({
    url: "../update-profile/update-username.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      //if the call success
      if (data) {
        $("#updateUsernameMessage").html(data); //here we define where all "echo" from signup.php have to appear
      } else {
        window.location.reload();
      }
    },
    error: function () {
      $("#updateUsernameMessage").html(
        '<div class="alert alert-danger"> There was an error with the Ajax Call. Please try again later.</div>'
      );
    },
  });
});
//AJAX call for the update password form
$("#updatePasswordForm").submit(function (event) {
  //to prevent default php processing
  event.preventDefault();
  //collect user inputs
  //"this" represent the current object "signupForm" which is submitted.
  //serializeArray() allow to create a javascript array of object ready to be encoded as a JSON string.
  var dataToPost = $(this).serializeArray();
  console.log(dataToPost);
  // Send them to update-username.php using AJAX. There is also the post() method used with done() and fail().
  $.ajax({
    url: "../update-profile/update-password.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      //if the call success
      if (data) {
        $("#updatePasswordMessage").html(data); //here we define where all "echo" from signup.php have to appear
      }
    },
    error: function () {
      $("#updateUsernameMessage").html(
        '<div class="alert alert-danger"> There was an error with the Ajax Call. Please try again later.</div>'
      );
    },
  });
});
//AJAX call for the update email form
$("#updateEmailForm").submit(function (event) {
  //to prevent default php processing
  event.preventDefault();
  //collect user inputs
  //"this" represent the current object "signupForm" which is submitted.
  //serializeArray() allow to create a javascript array of object ready to be encoded as a JSON string.
  var dataToPost = $(this).serializeArray();
  console.log(dataToPost);
  // Send them to update-username.php using AJAX. There is also the post() method used with done() and fail().
  $.ajax({
    url: "../update-profile/update-email.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      //if the call success
      if (data) {
        $("#updateEmailMessage").html(data); //here we define where all "echo" from signup.php have to appear
      }
    },
    error: function () {
      $("#updateEmailMessage").html(
        '<div class="alert alert-danger"> There was an error with the Ajax Call. Please try again later.</div>'
      );
    },
  });
});
//AJAX call for deleting user account
$("#deleteAccountForm").submit(function () {
  var deleteSubmit = $(this);
  console.log(deleteSubmit.attr("data"));
  $.ajax({
    url: "../controllers/delete-account.php",
    type: "POST",
    data: { user_id: deleteSubmit.attr("data") },
    success: function (data) {
      //if there is an error
      if (data == "error") {
        $("#deleteAccountMessage").html(
          '<div class="alert alert-danger">There was an issue on deleting your account from the database.</div>'
        ); //here we define where all "echo" have to appear
      } else {
        window.location.href = "../index.php";
      }
    },
    error: function () {
      $("#deleteAccountMessage").html(
        '<div class="alert alert-danger"> There was an error with the Ajax Call. Please try again later.</div>'
      );
    },
  });
});
