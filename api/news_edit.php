<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

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
    $_SESSION['error'] = 'Nincs jogosultság a hír szerkesztéséhez';
    header('Location: /news/' . $id);
    exit;
}

$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$intro_text = $_POST['intro_text'] ?? '';
$full_text = $_POST['full_text'] ?? '';

if (empty($title) || empty($author) || empty($intro_text) || empty($full_text)) {
    $_SESSION['error'] = 'Hiányzó adatok';
    header('Location: /news/edit/' . $id);
    exit;
}

$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_path = uploadImage($_FILES['image']);
    if ($image_path === false) {
        $_SESSION['error'] = 'Hiba történt a kép feltöltése során';
        header('Location: /news/edit/' . $id);
        exit;
    }
}

if (updateNews($id, $title, $author, $intro_text, $full_text, $image_path)) {
    echo json_encode(['success' => true]);
    $_SESSION['success'] = 'Hír sikeresen szerkesztve';
    header('Location: /news/' . $id);
    exit;
} else {
    http_response_code(500);
    $_SESSION['error'] = 'Hiba történt a hír szerkesztése során';
    header('Location: /news/edit/' . $id);
    exit;
}