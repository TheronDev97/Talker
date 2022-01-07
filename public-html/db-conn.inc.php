<?php

require 'db-pswd.inc.php';

try {

    //DOCKER
    //$connection = new PDO('mysql:host=mysql;dbname=talker_db', 'root', 'talker-root-password');

    //VAGRANT
    $connection = new PDO('mysql:host=localhost;dbname=talker_db', VAGRANT[0], VAGRANT[1]);

    //XAMPP
    //$connection = new PDO('mysql:host=localhost;dbname=talker_db', 'root', '');

    print "Success! Connected to the database!";

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>