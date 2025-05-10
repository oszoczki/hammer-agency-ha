<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';
require_once '../classes/Logger.php';

try {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($username) || empty($password) || empty($email)) {
        $_SESSION['error'] = 'Hiányzó adatok';
        header('Location: /register');
        exit;
    }
    
    if (registerUser($username, $password, $email)) {
        $_SESSION['success'] = 'Sikeres regisztráció! Most már bejelentkezhetsz.';
        header('Location: /login');
        exit;
    } else {
        $_SESSION['error'] = 'A regisztráció sikertelen. A felhasználónév vagy email cím már foglalt.';
        header('Location: /register');
        exit;
    }
} catch (Exception $e) {
    $logger = new Logger();
    $logger->error('Hiba történt a regisztráció során: ' . $e->getMessage());
    $_SESSION['error'] = 'Hiba történt a regisztráció során: ' . $e->getCode();
    header('Location: /register');
    exit;
}