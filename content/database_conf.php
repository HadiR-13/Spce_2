<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "db_space";

    $data = mysqli_connect($host,$user,$password,$db);

    if ($data -> connect_error) {
        die("Connection failed: " . $data->connect_error);
    }
?>