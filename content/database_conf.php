<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "db_space";

    $conn = mysqli_connect($host,$user,$password,$db);

    if ($conn -> connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>