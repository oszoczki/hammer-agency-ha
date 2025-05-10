<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';
require_once '../classes/Logger.php';

try {
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
} catch (Exception $e) {
    $logger = new Logger();
    $logger->error('Hiba történt a bejelentkezés során: ' . $e->getMessage());
    $_SESSION['error'] = 'Hiba történt a bejelentkezés során: ' . $e->getCode();
    header('Location: /login');
    exit;
}