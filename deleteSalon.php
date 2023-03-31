<?php
error_reporting(0);
include "ConnectDB.php";
session_start();
$SID = $_GET['SID'];

$query="DELETE FROM `Review` WHERE `SID`='$SID'";
$result = mysqli_query($connection, $query);

$query="DELETE FROM `Rating` WHERE `SID`='$SID'";
$result = mysqli_query($connection, $query);

$query="DELETE FROM `SalonsList` WHERE `SID`='$SID'";
$result = mysqli_query($connection, $query);

?>
