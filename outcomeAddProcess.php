<?php
include 'connection.php';
session_start();

$user_id = $_SESSION['u']['user_id'];
$outcome = $_POST["outcome"];
$outcome_type = $_POST["type"];
$status = 1;
 
$date = new DateTime();  
$tz = new DateTimeZone('Asia/Colombo');  
$date->setTimezone($tz);  

$nowDate = $date->format('Y-m-d H:i:s'); 



if (empty($outcome)) {
    echo ("Please enter your outcome amount");
    exit;
} elseif ($outcome_type == 0) {
    echo ("Please enter your outcome type");
    exit;
} else {
    $q = "INSERT INTO `outcome`(`outcome`,`outcome_type`,`user_id`,`status_id`,`date`)
         VALUES('" . $outcome . "','" . $outcome_type . "','" . $user_id . "','" . $status . "','" . $nowDate . "')";

    Database::iud($q);
    echo ("Outcome added successful");
}
