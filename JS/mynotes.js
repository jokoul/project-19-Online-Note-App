//This file handle all Note ajax call and other functionality made with javascript
$(function () {
  //Define variables
  var activeNote = 0; //default value
  var editMode = false;
  //load notes on page load: AJAX call to loadnotes.php
  $.ajax({
    url: "../notes/loadnotes.php",
    success: function (data) {
      //fn if ajax is successfull, we retrieve the data retruned as parameter
      $("#notes").html(data);
      clickOnNote();
      clickOnDelete();
    },
    error: function () {
      $("#alertContent").text(
        "There was an error with the AJAX Call. Please try again later."
      );
      $("#alert").fadeIn();
    },
  });
  //add a new note: AJAX call to createnote.php
  $("#addNote").on("click", function () {
    $("#allNotes").css("color", "red");
    $.ajax({
      url: "../notes/createnote.php",
      success: function (data) {
        if (data == "error") {
          //if error
          $("#alertContent").text(
            "There was an issue inserting the new note in the database"
          );
          $("#alert").fadeIn(); //to make box alert appear smoothly
        } else {
          //update activeNote to the id of the new note
          activeNote = data;
          $("textarea").val(""); //change content to blank with empty string
          //show hide elements
          showHide(
            ["#notePad", "#allNotes"],
            ["#notes", "#addNote", "#edit", "#done"]
          );
          $("textarea").focus(); //to put the focus cursor inside the textarea after shown
        }
      },
      error: function () {
        $("#alertContent").text(
          "There was an error with the AJAX Call. Please try again later."
        );
        $("#alert").fadeIn();
      },
    });
  });
  //type note : AJAX call to updatenote.php
  $("textarea").on("keyup", function () {
    console.log($(this).val());
    //ajax call to update the task of id activeNote
    $.ajax({
      url: "../notes/updatenote.php",
      type: "POST", //to send data we need to specify the typee of ajax call in POST by default GET
      data: { note: $(this).val(), id: activeNote }, //we need to send the current note content with its id to the php file
      success: function (data) {
        //fn if ajax is successfull, we retrieve the data retruned as parameter
        if (data == "error") {
          $("#alertContent").text(
            "There was an issue updating the note in the database."
          );
          $("#alert").fadeIn();
        }
      },
      error: function () {
        $("#alertContent").text(
          "There was an error with the AJAX Call. Please try again later."
        );
        $("#alert").fadeIn();
      },
    });
  });
  //click on all notes button
  $("#allNotes").on("click", function () {
    $.ajax({
      url: "../notes/loadnotes.php",
      success: function (data) {
        //fn if ajax is successfull, we retrieve the data retruned as parameter
        $("#notes").html(data);
        showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad"]);
        clickOnNote();
        clickOnDelete();
      },
      error: function () {
        $("#alertContent").text(
          "There was an error with the AJAX Call. Please try again later."
        );
        $("#alert").fadeIn();
      },
    });
  });
  //click on done after editing: load notes again
  $("#done").on("click", function () {
    //switch to non edit mode
    editMode = false;
    //expand notes
    $(".noteContainer").removeClass("col-7 col-md-9");
    $(".noteContainer").addClass("col-12");
    //show hide elements
    showHide(["#edit"], [this, ".delete"]);
  });

  //click on edit : go to edit mode (show delete buttons,...)
  $("#edit").on("click", function () {
    //switch to edit mode
    editMode = true;
    //reduce the width of note
    $(".noteContainer").addClass("col-7 col-md-9");
    $(".noteContainer").removeClass("col-12");
    //show hide elements
    showHide(["#done", ".delete"], [this]);
  });
  //Functions
  //click on a note
  function clickOnNote() {
    $(".noteContainer").on("click", function () {
      // if (!editMode) {
      //   //update activeNote variable to id of note
      //   activeNote = $(this).attr("id");
      //   //fill text area using val() method, this represent the current note we select and want to add the content.
      //   $("textarea").val($(this).find(".noteText").text()); //In the .noteContainer div, we search and find an element with the class (.text) then we use his text content.
      //   //show hide elements
      //   showHide(
      //     ["#notePad", "#allNotes"],
      //     ["#notes", "#addNote", "#edit", "#done"]
      //   );
      //   $("textarea").focus();
      // }
      //update activeNote variable to id of note
      activeNote = $(this).attr("id");
      //fill text area using val() method, this represent the current note we select and want to add the content.
      $("textarea").val($(this).find(".noteText").text()); //In the .noteContainer div, we search and find an element with the class (.text) then we use his text content.
      //show hide elements
      showHide(
        ["#notePad", "#allNotes"],
        ["#notes", "#addNote", "#edit", "#done"]
      );
      $("textarea").focus();
    });
  }
  //click on delete
  function clickOnDelete() {
    $(".delete").on("click", function () {
      var deleteButton = $(this);
      $.ajax({
        url: "../notes/deletenote.php",
        type: "POST",
        data: { id: deleteButton.next().attr("id") }, //we select the next element of our current delete element which is .noteContainer div. Then we retrieve note id store as attribute.
        success: function (data) {
          if (data == "error") {
            $("#alertContent").text(
              "There was an issue on delete the note from the database."
            );
            $("#alert").fadeIn();
          } else {
            //if no error, remove containing div
            deleteButton.parent().remove(); //remove .note element div
          }
        },
      });
    });
  }
  //show hide function
  function showHide(array1, array2) {
    //array1:all id to show, array2: all id to hide
    for (i = 0; i < array1.length; i++) {
      $(array1[i]).show();
    }
    for (i = 0; i < array2.length; i++) {
      $(array2[i]).hide();
    }
  }
});
