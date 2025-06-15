<?php
session_start();
require '../content/database_conf.php';

if (isset($_POST['deletehistori'])) {
    $id_booking = mysqli_real_escape_string($conn, $_POST['id_booking']);

    if (!$id_booking) {
        die("ID tidak valid.");
    }

    $delete = mysqli_query($conn, "DELETE FROM booking WHERE booking_id = '$id_booking'");

    if ($delete) {
        header("Location: index.php");
        exit();
    } else {
        die("Query gagal: " . mysqli_error($conn));
    }
}


//UPDATE - Edit Histori
if(isset($_POST['edithistori'])){
    $id_booking = $_POST['id_booking'];
    $planet_id = $_POST['planet-edit'];
    $seat_number = $_POST['seat-edit'];

    $update = mysqli_query($conn,"UPDATE booking SET planet_id = '$planet_id', seat_number = '$seat_number' WHERE booking_id ='$id_booking' ");
    
    if($update){
        header('location:index.php');
    } else {
        echo "Tidak ada data yang ditemukan";
        header('location:index.php');
    }
}