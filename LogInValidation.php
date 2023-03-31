<?php

session_start();
include 'ConnectDB.php';

if (isset($_POST['submit'])) {
    $Man_User = $_POST['Manuser'];
    $ManPass = $_POST['ManPass'];

    $sql = "SELECT * FROM Manager WHERE user_name = '$Man_User'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $StoredPass = $row['password'];

    if (password_verify($ManPass, $StoredPass)) {
        $_SESSION['role'] = "Manager";
        $_SESSION['ID'] = $row['ID'];
        header("Location: manager_Home.php");
        exit();
    } else {
        echo '<script>window.location="LogIn.php"; alert("There is no account associated with the given information, You can re-check your input or sign-up now!");</script>';
    }
}


