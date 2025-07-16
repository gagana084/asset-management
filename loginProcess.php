<?php
session_start();
include 'connection.php';

$email = $_POST["email"];
$pw = $_POST["pw"];


$rs = Database::search("SELECT * FROM `user` WHERE `user`.`email` = '" . $email . "' ");
$num = $rs->num_rows;

if ($num == 1) {

    $d = $rs->fetch_assoc();

    $dbEncodePw = $d['password'];

    if (password_verify($pw, $dbEncodePw)) {
        echo ("success");
        $_SESSION["u"] = $d;
    } else {
        echo ("Invalid email or password");
    }
    
} else {
    echo ("Invalid email or password");
}
