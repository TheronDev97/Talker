<?php

session_start();
require ('system.ctrl.php');

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
    $db_data=array($user_email,$user_password);
    phpModifyDB('INSERT INTO users (user_email,user_password) values (?,?)',$db_data); //system.ctrl.php
    $_SESSION["msgid"] = "811";
    header('Location: index.php');
} else if (!$email_validation) {
    $_SESSION["msgid"] = "801";
    header('Location: index.php');
} else if (!$password_validation) {
    $_SESSION["msgid"] = "802";
    header('Location: index.php');
} else if ($user_password != $_POST["formSignUpPasswordConf"]){
    $_SESSION["msgid"] = "803";
    header('Location: index.php');
}

?>