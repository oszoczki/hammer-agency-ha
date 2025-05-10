<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
require_once '../classes/Logger.php';

try {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Bejelentkezés szükséges';
        header('Location: /login');
        exit;
    }
    
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id === 0) {
        $_SESSION['error'] = 'Érvénytelen azonosító';
        header('Location: /');
        exit;
    }
    
    $news = getNewsById($id);
    if (!$news || $news['user_id'] !== getCurrentUserId()) {
        $_SESSION['error'] = 'Nincs jogosultság a hír törléséhez';
        header('Location: /news/' . $id);
        exit;
    }
    
    if (deleteNews($id)) {
        $_SESSION['success'] = 'Hír sikeresen törölve';
        header('Location: /');
        exit;
    } else {
        $_SESSION['error'] = 'Hiba történt a hír törlése során';
        header('Location: /news/' . $id);
        exit;
    }
} catch (Exception $e) {
    $logger = new Logger();
    $logger->error('Hiba történt a hír törlése során: ' . $e->getMessage());
    $_SESSION['error'] = 'Hiba történt a hír törlése során: ' . $e->getMessage();
    header('Location: /news/' . $id);
    exit;
}


