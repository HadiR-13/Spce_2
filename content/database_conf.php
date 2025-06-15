<?php
    $host = "localhost";
    $user = "u532713666_MMOSHI";
    $password = "MMOSHII_The_Hero_1142";
    $db = "u532713666_Space_web";

    $conn = mysqli_connect($host,$user,$password,$db);

    if ($conn -> connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>