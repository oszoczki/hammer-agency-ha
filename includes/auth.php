<?php
session_start();
require_once __DIR__ . '/../config/database.php';

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login');
        exit;
    }
}

function loginUser($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function registerUser($username, $password, $email) {
    global $conn;
    
    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $email]);
    } catch (PDOException $e) {
        return false;
    }
}

function logoutUser() {
    session_destroy();
    header('Location: /');
    exit;
}

function getCurrentUserId() {
    return $_SESSION['user']['id'] ?? null;
}

function getCurrentUsername() {
    return $_SESSION['user']['username'] ?? null;
}
?> 