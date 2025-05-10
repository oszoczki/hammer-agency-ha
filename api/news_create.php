<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
require_once '../classes/Logger.php';

try {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Bejelentkezés szükséges a hír létrehozásához';
        header('Location: /login');
        exit;
    }
    
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $intro_text = $_POST['intro_text'] ?? '';
    $full_text = $_POST['full_text'] ?? '';
    
    if (empty($title) || empty($author) || empty($intro_text) || empty($full_text)) {
        $_SESSION['error'] = 'Hiányzó adatok';
        header('Location: /news/create');
        exit;
    }
    
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_path = uploadImage($_FILES['image']);
        if ($image_path === false) {
            $_SESSION['error'] = 'Hiba történt a kép feltöltése során';
            header('Location: /news/create');
            exit;
        }
    }
    
    if (createNews($title, $author, $intro_text, $full_text, $image_path)) {
        $_SESSION['success'] = 'A hír sikeresen létrehozva';
        header('Location: /');
        exit;
    } else {
        $_SESSION['error'] = 'Hiba történt a hír létrehozása során';
        header('Location: /news/create');
        exit;
    }
} catch (Exception $e) {
    $logger = new Logger();
    $logger->error('Hiba történt a hír létrehozása során: ' . $e->getMessage());
    $_SESSION['error'] = 'Hiba történt a hír létrehozása során: ' . $e->getCode();
    header('Location: /news/create');
    exit;
}

