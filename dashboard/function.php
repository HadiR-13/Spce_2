<?php
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_space");

//DELETE - Menghapus Histori
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