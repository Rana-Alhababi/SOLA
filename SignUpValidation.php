<?php

session_start();
include 'ConnectDB.php';

if (isset($_POST['submit'])) {
    $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM Manager WHERE ID = '" . $_POST['ID'] . "'";
    $result = mysqli_query($connection, $sql);
    if (!(mysqli_num_rows($result) > 0)) {
        $sql = "INSERT INTO Manager (ID,first_name,last_name,user_name,password) Values('" . $_POST['ID'] . "' , '" . $_POST['Fname'] . "' , '" . $_POST['Lname'] . "' , '" . $_POST['Uname'] . "' , '" . $pass . "')";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $_SESSION['role'] = "Manager";
            $_SESSION['ID'] = $_POST['ID'];
            header("Location: manager_Home.php");
            exit();
        } else {
            echo '<script>window.location="SignUp.php"; alert("Somthing went wrong, Try again!");</script>';
        }
    } else {
        echo '<script>window.location="SignUp.php"; alert("ID already exists! Try again or log-in");</script>';
    }
}
