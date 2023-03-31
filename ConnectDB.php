<?php

$connection = mysqli_connect("localhost", "root", "root", "Salons");

if(!$connection) {
    die("<script>alert('Connection failed!')</script>");
}

