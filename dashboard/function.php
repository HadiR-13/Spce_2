<?php
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_spacestation");

//CREATE - menambah histori
if(isset($_POST['addnewhistori'])){
    $user = $_POST['user'];
    $tiket = $_POST['tiket'];
    $tujuan = $_POST['tujuan'];
    $tanggal = $_POST['tanggal'];
    $pukul = $_POST['pukul'];

        $addtotable = mysqli_query($conn,"INSERT INTO histori_booking (id_user,id_tiket,tujuan,tanggal,pukul) 
        values ('$user','$tiket','$tujuan','$tanggal','$pukul')");
        if($addtotable){
            header('location:index.php');
        } else {
            echo "Tidak ada data yang ditemukan";
            header('location:index.php');
        }
}

//UPDATE - Perbarui Histori
if(isset($_POST['updatehistori'])){
    $id_histori = $_POST['id_histori'];
    $tanggal = $_POST['tanggal'];
    $pukul = $_POST['pukul'];

    $update = mysqli_query($conn,"UPDATE histori_booking SET tanggal = '$tanggal', pukul = '$pukul' WHERE id_histori ='$id_histori' ");
    
    if($update){
        header('location:index.php');
    } else {
        echo "Tidak ada data yang ditemukan";
        header('location:index.php');
    }
}

//DELETE - Menghapus Histori
if(isset($_POST['deletehistori'])){
    $id_histori = $_POST['id_histori'];

    $delete = mysqli_query($conn,"DELETE FROM histori_booking WHERE id_histori='$id_histori'");

    if($delete){
        header('location:index.php');
    } else {
        echo "Tidak ada data yang ditemukan";
        header('location:index.php');
    }
}