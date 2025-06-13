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