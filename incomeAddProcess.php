<?php
include 'connection.php';
session_start();
$user = $_SESSION['u'];
$income = $_POST["amount"];
$income_type = $_POST["type"];
$user_id = $user['user_id'];
$status = 1;
 
if (empty($income)) {
    echo("Please enter your income amount");
    exit;
} elseif ($income_type == 0) {
    echo("Please select your income type");
    exit;
} else {

    // exit;
    $date = new DateTime();  
    $tz = new DateTimeZone('Asia/Colombo');  
    $date->setTimezone($tz);  

    $nowDate = $date->format('Y-m-d H:i:s'); 

    $q = "INSERT INTO `income`(`income`,`income_type`,`user_id`,`status_id`,`date`)
      VALUES('" . $income . "','" . $income_type . "','" . $user_id . "','" . $status . "','" . $nowDate . "')";

    Database::iud($q);
    echo ("Successful added");
}
