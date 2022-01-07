<?php
//echo $_POST["formSignUpEmail"];
//echo $_POST["formSignUpPassword"];
//echo $_POST["formSignUpPasswordConf"];

$user_email=$_POST["formSignUpEmail"];
$user_email_pattern= "~^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$~"; 
//~ is required at the beginning and the end of the regex pattern by the preg_match() function.
$user_password=$_POST["formSignUpPassword"];
$user_password_pattern="~(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}~";
$email_validation=preg_match($user_email_pattern,$user_email); //preg_match() function returns boolean
$password_validation=preg_match($user_password_pattern,$user_password);


if ($email_validation && $password_validation && $user_password == $_POST["formSignUpPasswordConf"]) {
    header('Location: index.php?msgid=811');
} else if ($user_password != $_POST["formSignUpPasswordConf"]){
    echo "Passwords don't match";
} else if (!$email_validation) {
    echo "Email doesn't meet the requirements";
} else if (!$password_validation) {
    echo "Password doesn't meet the requirements";
}

?>