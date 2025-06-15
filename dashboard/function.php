<?php
session_start();

if(isset($_POST['deletehistori'])){
    $id_booking = $_POST['id_booking'];

    $delete = mysqli_query($conn,"DELETE FROM booking WHERE booking_id='$id_booking'");

    if($delete){
        header('location:index.php');
    } else {
        echo "Tidak ada data yang ditemukan";
        header('location:index.php');
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