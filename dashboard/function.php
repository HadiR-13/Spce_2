<?php
session_start();

if (isset($_POST['deletehistori'])) {
    $id_booking = $_POST['id_booking'];

    // Gunakan prepared statement untuk keamanan (opsional tapi direkomendasikan)
    $query = "DELETE FROM booking WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id_booking);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($success) {
            header('Location: index.php');
            exit(); // pastikan untuk mengakhiri eksekusi setelah header
        } else {
            // Debug log ke file atau tampilkan error
            echo "<script>alert('Gagal menghapus data.'); window.location.href='index.php';</script>";
            exit();
        }
    } else {
        // Debug saat prepare statement gagal
        echo "<script>alert('Terjadi kesalahan pada query.'); window.location.href='index.php';</script>";
        exit();
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