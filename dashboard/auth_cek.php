<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function simpleAdminCheck() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit();
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../index.php');
        exit();
    }
}

function getSessionUser() {
    return [
        'username' => $_SESSION['username'] ?? 'Unknown',
        'role' => $_SESSION['role'] ?? 'unknown'
    ];
}
?>