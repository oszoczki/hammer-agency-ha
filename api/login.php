<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Hiányzó adatok';
    header('Location: /login');
    exit;
}

if (loginUser($username, $password)) {
    header('Location: /');
    exit;
} else {
    $_SESSION['error'] = 'Hibás felhasználónév vagy jelszó';
    header('Location: /login');
    exit;
}
