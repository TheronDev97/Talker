<?php

session_start();
require('system.ctrl.php');

//if session uid or cookie uid is not empty redirect to gate.php
//!empty($_SESSION["uid"]) is equivalent to $_SESSION["uid"]!="" but doesn't give off warning if value is empty (isset can also be used)
if (!empty($_SESSION["uid"]) || !empty($_COOKIE["cookieUserEmail"])) {
	header('Location: gate.php');
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TALKER</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Talker CSS -->
    <link rel="stylesheet" href="talker.css">
  </head>
  <body>
    <div class="container">

        <!-- SYSTEM-WIDE FEEDBACK -->
        <?php if (isset($_SESSION["msgid"]) && $_SESSION["msgid"]!="" && phpShowSystemFeedback($_SESSION["msgid"])[0]!="") { ?>

          <div class="row">
            <div class="col-12">
              <div class="alert alert-<?php echo (phpShowSystemFeedback($_SESSION['msgid'])[0]); ?>" role="alert">
                <?php echo (phpShowSystemFeedback($_SESSION['msgid'])[1]); ?>
              </div>
            </div>
          </div>

        <?php } ?>
        <!-- SYSTEM-WIDE FEEDBACK -->

        <!-- SIGN IN FORM -->
        <div class="row sign-in-row">
          <div class="col-lg-6"><h1>TALKER</h1></div>
          <div class="col-lg-6">
            <form name="formSignIn" action="signin.ctrl.php" method="post" novalidate>
              <div class="form-inline">
                <label class="sr-only" for="formSignInEmail">Email</label>
                <input type="email" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" id="formSignInEmail" name="formSignInEmail" placeholder="Email" onkeyup="jsSignInValidateEmail()">

                <label class="sr-only" for="formSignInPassword">Password</label>
                <input type="password" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" id="formSignInPassword" name="formSignInPassword" placeholder="Password" onkeyup='jsSignInValidatePassword()'>

                <button type="submit" id="formSignInSubmit" class="btn btn-primary btn-sm">Sign In</button>
              </div>
            </form>
          </div>
        </div>

        <h4>Create a new account</h4>
        <hr>

        <!-- SIGN UP FORM -->
        <div class="row">
            <div class="col-lg-6">
                <form name="formSignUp" action="signup.ctrl.php" method="post" novalidate>
                    <div class="form-group">
                        <label for="formSignUpEmail">Email address</label>
                        <input type="email" <?php echo phpShowEmailInputValue($_SESSION["formSignUpEmail"]); ?> class="form-control <?php if ($_SESSION["msgid"]!='801' && $_SESSION["msgid"]!=""){ echo 'is-valid';} else{ echo phpShowInputFeedback($_SESSION["msgid"])[0]; } ?>" id="formSignUpEmail" name="formSignUpEmail" placeholder="Enter your email address" onkeyup='jsSignUpValidateEmail();'>

                        <?php if ($_SESSION["msgid"]=="801") { ?>
                        <div class="invalid-feedback">
                        <?php echo phpShowInputFeedback($_SESSION["msgid"])[1] ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="formSignUpPassword">Password</label>
                        <input type="password" class="form-control <?php echo phpShowInputFeedback($_SESSION["msgid"])[0]; ?>" id="formSignUpPassword" name="formSignUpPassword" placeholder="Enter your password" onkeyup="jsSignUpValidatePassword()">

                        <?php if ($_SESSION["msgid"]=="802") { ?>
                        <div class="invalid-feedback">
                        <?php echo phpShowInputFeedback($_SESSION["msgid"])[1] ?>
                        </div>
                        <?php } ?>

                        <input type="password" class="form-control mt-4 <?php echo phpShowInputFeedback($_SESSION["msgid"])[0]; ?>" id="formSignUpPasswordConf" name="formSignUpPasswordConf" placeholder="Confirm your password" onkeyup="jsSignUpValidatePassword()">

                        <?php if ($_SESSION["msgid"]=="803") { ?>
                        <div class="invalid-feedback">
                        <?php echo phpShowInputFeedback($_SESSION["msgid"])[1] ?>
                        </div>
                        <?php } ?>

                    </div>
                    <p id="password_comparison"></p>
                    <button type="submit" id="formSignUpSubmit" class="btn btn-primary btn-success">Sign Up</button>
                </form>
            </div>

            <div class="col-lg-6">
                <p>Hello and welcome to Talker! We are very happy that you want to join our great community!</p>
                <p>Please, enter your email and password. Your must have access to your email because we will send
            a confirmation code to that address. Your password must be between 8 and 16 characters long, with at
            least one uppercase and one lowercase character, one number and one special character (@, *, $ or #).</p>
                <p>We hope you'll enjoy Talker!</p>
            </div>
        </div>
    </div>

    <?php
      //empty the msgid id only if no user is signed in
      if ($_SESSION["uid"]=="" || $_COOKIE["cookieUserEmail"]=="") {
        $_SESSION["msgid"]="";
      }
      $_SESSION["formSignUpEmail"]="";
    ?>

    <script>
      var jsSignUpEmail=document.getElementById("formSignUpEmail");
      var jsSignInEmail=document.getElementById("formSignInEmail");
      var jsEmailRegexPattern= /^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$/;
      var jsSignUpPassword = document.getElementById("formSignUpPassword");
      var jsSignInPassword = document.getElementById("formSignInPassword");
      var jsSignUpPasswordConf = document.getElementById("formSignUpPasswordConf");
      var jsPasswordRegexPattern= /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}/; // slash at beginning and end is required to define the pattern between them.

      document.getElementById("formSignUpSubmit").disabled=true;
      document.getElementById("formSignUpSubmit").classList.remove("btn-success");
      document.getElementById("formSignUpSubmit").classList.add("btn-danger");

      document.getElementById("formSignInSubmit").disabled=true;
      document.getElementById("formSignInSubmit").classList.remove("btn-success");
      document.getElementById("formSignInSubmit").classList.add("btn-danger");

      function jsSignUpSubmitEnable() {
        if (jsEmailRegexPattern.test(jsSignUpEmail.value) && jsPasswordRegexPattern.test(jsSignUpPassword.value) && jsSignUpPassword.value == jsSignUpPasswordConf.value) {
          document.getElementById("formSignUpSubmit").disabled = false;
          document.getElementById("formSignUpSubmit").classList.remove("btn-danger");
          document.getElementById("formSignUpSubmit").classList.add("btn-success");
        }else{
          document.getElementById("formSignUpSubmit").disabled = true;
          document.getElementById("formSignUpSubmit").classList.remove("btn-success");
          document.getElementById("formSignUpSubmit").classList.add("btn-danger");
        }
      }

      function jsSignInSubmitEnable() {
        if (jsEmailRegexPattern.test(jsSignInEmail.value) && jsPasswordRegexPattern.test(jsSignInPassword.value)) {
          document.getElementById("formSignInSubmit").disabled = false;
          document.getElementById("formSignInSubmit").classList.remove("btn-danger");
          document.getElementById("formSignInSubmit").classList.add("btn-success");
        }else{
          document.getElementById("formSignInSubmit").disabled = true;
          document.getElementById("formSignInSubmit").classList.remove("btn-success");
          document.getElementById("formSignInSubmit").classList.add("btn-danger");
        }
      }

      function jsSignUpValidateEmail() {
        jsSignUpSubmitEnable();
        if(!jsEmailRegexPattern.test(jsSignUpEmail.value)) {
          if (!document.getElementById("formSignUpEmailInvalidFeedback")) { //this if to not repeat message
            jsSignUpEmail.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSignUpEmailInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("This is not a valid email address");
            newElement.appendChild(newElementContent);
            jsSignUpEmail.parentNode.insertBefore(newElement, jsSignUpEmail.nextSibling);
          }
        }else{
          if (document.getElementById("formSignUpEmailInvalidFeedback")) {
            document.getElementById("formSignUpEmailInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpEmailInvalidFeedback"));
          }
          jsSignUpEmail.classList.remove("is-invalid");
          jsSignUpEmail.classList.add("is-valid");
        }
      }

      function jsSignInValidateEmail() {
        jsSignInSubmitEnable();
        if(!jsEmailRegexPattern.test(jsSignInEmail.value)) {
            jsSignInEmail.classList.add("is-invalid");
        }else{
          jsSignInEmail.classList.remove("is-invalid");
          jsSignInEmail.classList.add("is-valid");
        }
      }

      function jsSignUpValidatePassword(){
        jsSignUpSubmitEnable();
        if(!jsPasswordRegexPattern.test(jsSignUpPassword.value)){

          if(!document.getElementById("formSignUpPasswordInvalidFeedback")){ //client side validation for pass

            jsSignUpPassword.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id","formSignUpPasswordInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).");
            newElement.appendChild(newElementContent);
            jsSignUpPassword.parentNode.insertBefore(newElement, jsSignUpPassword.nextSibling);

          }

        }else if(jsSignUpPassword.value != jsSignUpPasswordConf.value) {
            if(!document.getElementById("formSignUpPasswordConfInvalidFeedback")){ //client side validation for pass conf

            jsSignUpPasswordConf.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id","formSignUpPasswordConfInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Passwords don't match!");
            newElement.appendChild(newElementContent);
            jsSignUpPasswordConf.parentNode.insertBefore(newElement, jsSignUpPasswordConf.nextSibling);

            }

          if(document.getElementById("formSignUpPasswordInvalidFeedback")){ //to remove the div message
            document.getElementById("formSignUpPasswordInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpPasswordInvalidFeedback"));
          }
          jsSignUpPassword.classList.remove("is-invalid");
          jsSignUpPassword.classList.add("is-valid");

        } else {
          if(document.getElementById("formSignUpPasswordConfInvalidFeedback")){ //to remove the div message
            document.getElementById("formSignUpPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpPasswordConfInvalidFeedback"));
          }
          jsSignUpPasswordConf.classList.remove("is-invalid");
          jsSignUpPasswordConf.classList.add("is-valid");
        }
      }

      function jsSignInValidatePassword() {
        jsSignInSubmitEnable();
        if(!jsPasswordRegexPattern.test(jsSignInPassword.value)) {
            jsSignInPassword.classList.add("is-invalid");
        }else{
          jsSignInPassword.classList.remove("is-invalid");
          jsSignInPassword.classList.add("is-valid");
        }
      }

    </script>

    <!-- Optional Javascript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>