<?php
require '../content/database_conf.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
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
        'username' => $_SESSION['username'] ?? 'Unknown',
        'email' => $_SESSION['email'] ?? null,
        'phone' => $_SESSION['phone'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}
?>