<?php
require '../content/database_conf.php';
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ../login.php?error=login_required');
        exit();
    }
}

function checkAdminRole() {
    checkLogin();
    
    if ($_SESSION['role'] !== 'admin') {
        $_SESSION['error_message'] = 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman admin.';
        header('Location: ../index.php?error=access_denied');
        exit();
    }
}

function getCurrentUser() {
    return [
        'user_id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}
?>