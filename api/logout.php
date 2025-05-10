<?php
require_once '../includes/auth.php';

try {
    logoutUser();
    header('Location: /');
    exit;
} catch (Exception $e) {
    $logger = new Logger();
    $logger->error('Hiba történt a kijelentkezés során: ' . $e->getMessage());
    $_SESSION['error'] = 'Hiba történt a kijelentkezés során: ' . $e->getCode();
    header('Location: /');
    exit;
}