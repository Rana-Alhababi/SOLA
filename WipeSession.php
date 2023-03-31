<?php

session_start();
if (isset($_SESSION["role"])) {
    session_destroy();
    echo '<script>window.location="index.php"; alert("Loged out successfully.");</script>';
}
?>
