$(document).ready(function () {
  $("#title_validate").hide();
  $("#rate_validate").hide();
  $("#description_validate").hide();
  $("#trailer_link_validate").hide();
  $("#fullname_validate").hide();
  $("#email_validate").hide();

  $("#message_validate").hide();

  var $titleError = true;
  var $rateError = true;
  var $descriptionError = true;
  var $trailer_linkError = true;
  var $fullnameError = true;
  var $emailError = true;
  var $messageError = true;

  $("#title").keyup(function () {
    title_check();
  });

  function title_check() {
    var title_val = $("#title").val();

    if (title_val.length == "") {
      $("#title_validate").show();
      $("#title_validate").html("** title is required.");
      $("#title_validate").focus();
      $("#title_validate").css("color", "red");
      titleError = false;
      return false;
    } else {
      $("#title_validate").hide();
    }

    if (title_val.length < 3) {
      $("#title_validate").show();
      $("#title_validate").html("** title is too short.");
      $("#title_validate").focus();
      $("#title_validate").css("color", "red");
      titleError = false;
      return false;
    } else {
      $("#title_validate").hide();
    }

    if (title_val.length > 100) {
      $("#title_validate").show();
      $("#title_validate").html("** title is too long.");
      $("#title_validate").focus();
      $("#title_validate").css("color", "red");
      titleError = false;
      return false;
    } else {
      $("#title_validate").hide();
    }
  }
  $("#rate").keyup(function () {
    rate_check();
  });

  function rate_check() {
    var rate_val = $("#rate").val();

    if (rate_val.length == "") {
      $("#rate_validate").show();
      $("#rate_validate").html("** rate is required.");
      $("#rate_validate").focus();
      $("#rate_validate").css("color", "red");
      rateError = false;
      return false;
    } else {
      $("#rate_validate").hide();
    }

    if (rate_val.length > 4) {
      $("#rate_validate").show();
      $("#rate_validate").html("** Invalid! Up to 2 decimal places only.");
      $("#rate_validate").focus();
      $("#rate_validate").css("color", "red");
      rateError = false;
      return false;
    } else {
      $("#rate_validate").hide();
    }

    if (rate_val < 0) {
      $("#rate_validate").show();
      $("#rate_validate").html("** Invalid! rate must range from 0 to 10.");
      $("#rate_validate").focus();
      $("#rate_validate").css("color", "red");
      rateError = false;
      return false;
    } else {
      $("#rate_validate").hide();
    }

    if (rate_val > 10) {
      $("#rate_validate").show();
      $("#rate_validate").html("** Invalid! rate must range from 0 to 10.");
      $("#rate_validate").focus();
      $("#rate_validate").css("color", "red");
      rateError = false;
      return false;
    } else {
      $("#rate_validate").hide();
    }
  }

  $("#rate").keypress(function (e) {
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
      return true;
    } else {
      e.preventDefault();
      $("#rate_validate").show();
      $("#rate_validate").html("** rate must be a number.");
      $("#rate_validate").focus();
      $("#rate_validate").css("color", "red");
      return false;
    }
  });

  /////////////////////////////////////////////////////////////

  /////////////////////////////////////////////////////////////

  $("#description").keyup(function () {
    description_check();
  });

  function description_check() {
    var description_val = $("#description").val();

    if (description_val.length == "") {
      $("#description_validate").show();
      $("#description_validate").html("** description is required.");
      $("#description_validate").focus();
      $("#description_validate").css("color", "red");
      descriptionError = false;
      return false;
    } else {
      $("#description_validate").hide();
    }

    if (description_val.length < 30) {
      $("#description_validate").show();
      $("#description_validate").html("** description is too short.");
      $("#description_validate").focus();
      $("#description_validate").css("color", "red");
      descriptionError = false;
      return false;
    } else {
      $("#description_validate").hide();
    }

    if (description_val.length > 500) {
      $("#description_validate").show();
      $("#description_validate").html("** description is too long.");
      $("#description_validate").focus();
      $("#description_validate").css("color", "red");
      descriptionError = false;
      return false;
    } else {
      $("#description_validate").hide();
    }
  }

  /////////////////////////////////////////////////////////////

  $("#message").keyup(function () {
    message_check();
  });

  function message_check() {
    var message_val = $("#message").val();

    if (message_val.length == "") {
      $("#message_validate").show();
      $("#message_validate").html("** message is required.");
      $("#message_validate").focus();
      $("#message_validate").css("color", "red");
      messageError = false;
      return false;
    } else {
      $("#message_validate").hide();
    }

    if (message_val.length < 30) {
      $("#message_validate").show();
      $("#message_validate").html("** message is too short.");
      $("#message_validate").focus();
      $("#message_validate").css("color", "red");
      messageError = false;
      return false;
    } else {
      $("#message_validate").hide();
    }

    if (message_val.length > 500) {
      $("#message_validate").show();
      $("#message_validate").html("** message is too long.");
      $("#message_validate").focus();
      $("#message_validate").css("color", "red");
      messageError = false;
      return false;
    } else {
      $("#message_validate").hide();
    }
  }

  /////////////////////////////////////////////////////////////

  $("#trailer_link").keyup(function () {
    trailer_link_check();
  });

  function trailer_link_check() {
    var trailer_link_val = $("#trailer_link").val();

    if (trailer_link_val.length == "") {
      $("#trailer_link_validate").show();
      $("#trailer_link_validate").html("** trailer link is required.");
      $("#trailer_link_validate").focus();
      $("#trailer_link_validate").css("color", "red");
      trailer_linkError = false;
      return false;
    } else {
      $("#trailer_link_validate").hide();
    }

    if (trailer_link_val.startsWith("https://www.youtube.com/embed/")) {
      return true;
    } else {
      $("#trailer_link_validate").show();
      $("#trailer_link_validate").html(
        "** Please enter embeded youtube trailer link address."
      );
      $("#trailer_link_validate").focus();
      $("#trailer_link_validate").css("color", "red");
      trailer_link_err = false;
      return false;
    }
  }

  //////////////////////////////////////////

  $("#fullname").keyup(function () {
    fullname_check();
  });

  function fullname_check() {
    var fullname_val = $("#fullname").val();

    if (fullname_val.length == "") {
      $("#fullname_validate").show();
      $("#fullname_validate").html("** fullname is required.");
      $("#fullname_validate").focus();
      $("#fullname_validate").css("color", "red");
      fullnameError = false;
      return false;
    } else {
      $("#fullname_validate").hide();
    }

    if (fullname_val.length < 5) {
      $("#fullname_validate").show();
      $("#fullname_validate").html("** fullname is too short.");
      $("#fullname_validate").focus();
      $("#fullname_validate").css("color", "red");
      fullnameError = false;
      return false;
    } else {
      $("#fullname_validate").hide();
    }

    if (fullname_val.length > 100) {
      $("#fullname_validate").show();
      $("#fullname_validate").html("** fullname is too long.");
      $("#fullname_validate").focus();
      $("#fullname_validate").css("color", "red");
      fullnameError = false;
      return false;
    } else {
      $("#fullname_validate").hide();
    }
  }

  //////////////////////////////////////////

  $("#email").keyup(function () {
    email_check();
  });

  function email_check() {
    var email_val = $("#email").val();

    if (email_val.length == "") {
      $("#email_validate").show();
      $("#email_validate").html("** Email is required.");
      $("#email_validate").focus();
      $("#email_validate").css("color", "red");
      email_err = false;
      return false;
    } else {
      $("#email_validate").hide();
    }

    if (email_val.length < 12) {
      $("#email_validate").show();
      $("#email_validate").html("** Email is too short.");
      $("#email_validate").focus();
      $("#email_validate").css("color", "red");
      email_err = false;
      return false;
    } else {
      $("#email_validate").hide();
    }

    if (email_val.length > 45) {
      $("#email_validate").show();
      $("#email_validate").html("** Email is too long.");
      $("#email_validate").focus();
      $("#email_validate").css("color", "red");
      email_err = false;
      return false;
    } else {
      $("#email_validate").hide();
    }

    if (
      email_val.endsWith("@email.com") ||
      email_val.endsWith("@gmail.com") ||
      email_val.endsWith("@yahoo.com") ||
      email_val.endsWith("@clsu.edu.ph") ||
      email_val.endsWith("@clsu2.edu.ph")
    ) {
      return true;
    } else {
      $("#email_validate").show();
      $("#email_validate").html("** Please enter a valid email address.");
      $("#email_validate").focus();
      $("#email_validate").css("color", "red");
      email_err = false;
      return false;
    }
  }

  $("#email").keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z_@.]|[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
      return true;
    } else {
      e.preventDefault();
      $("#email_validate").show();
      $("#email_validate").html("** Email address should be valid characters.");
      $("#email_validate").focus();
      $("#email_validate").css("color", "red");
      return false;
    }
  });

  ///////////////////////////////////////////////////////////

  $("#validateSubmit").click(function () {
    $titleError = $rateError = $descriptionError = $trailer_linkError = true;

    $title_check();
    $rate_check();
    $description_check();
    $trailer_link_check();

    if (
      titleError == true &&
      rateError == true &&
      descriptionError == true &&
      trailer_linkError == true
    ) {
      return true;
    } else {
      return false;
    }
  });
});
