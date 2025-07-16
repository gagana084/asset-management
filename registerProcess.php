<?php
include 'connection.php';

$name = $_POST["name"];
$email = $_POST["email"];
$pw = $_POST["pw"];
$cpw = $_POST["cpw"];
$status = 1;

$date = new DateTime();  
$tz = new DateTimeZone('Asia/Colombo');  
$date->setTimezone($tz);  

$nowDate = $date->format('Y-m-d H:i:s'); 

if (empty($name)) {
    echo "Please enter your name";
} elseif (strlen($name) > 90) {
    echo "Your name must be less than 90 characters";
} elseif (empty($email)) {
    echo "Please enter your email";
} elseif (strlen($email) > 95) {
    echo "Email must be less than 95 characters";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email";
} elseif (empty($pw)) {
    echo "Please enter your password";
} elseif (
    strlen($pw) < 8 ||
    !preg_match("/[A-Z]/", $pw) ||
    !preg_match("/[a-z]/", $pw) ||
    !preg_match("/[0-9]/", $pw) ||
    !preg_match("/[\W]/", $pw)
) {
    echo "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character";
} elseif (empty($cpw)) {
    echo "Please enter your confirm password";
} elseif ($pw !== $cpw) {
    echo "Passwords do not match";
} else {
 
    $q = "SELECT * FROM `user` WHERE `email` = '".$email."' AND `user_name` = '".$name."'  ";
    $rs = Database::search($q);
    $num = $rs->num_rows;

    if($num > 0){
        echo("User already exists");
        exit;
    }

    $encodePw = password_hash($pw, PASSWORD_DEFAULT);

    $q = "INSERT INTO `user`(`user_name`,`email`,`password`,`date`,`status`)
         VALUES('" . $name . "','" . $email . "','" . $encodePw . "','" . $nowDate . "','" . $status . "')";
    Database::iud($q);

    echo "success";
}
