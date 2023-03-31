<?php

error_reporting(0);
include "ConnectDB.php";
session_start();
$name = $_GET['name'];
$sql = "SELECT * FROM `SalonsList` WHERE `Name`='$name'";

$result = mysqli_query($connection, $sql);
    $myObj = array();
        if ($row = mysqli_fetch_assoc($result)){
            $myObj[] = $row;
        }
       
        print_r(json_encode($myObj));
        header('Content-Type: text/plain');

    
