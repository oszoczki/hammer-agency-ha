<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';

function getAllNews($limit = null, $offset = 0) {
    global $conn;
    
    $sql = "SELECT * FROM news ORDER BY created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNewsById($id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createNews($title, $author, $intro_text, $full_text, $image_path) {
    global $conn;
    
    if (!isLoggedIn()) {
        return false;
    }
    
    $user_id = getCurrentUserId();
    if (!$user_id) {
        return false;
    }
    
    $stmt = $conn->prepare("
        INSERT INTO news (title, author, intro_text, full_text, image_path, user_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    return $stmt->execute([
        $title,
        $author,
        $intro_text,
        $full_text,
        $image_path,
        $user_id
    ]);
}

function updateNews($id, $title, $author, $intro_text, $full_text, $image_path = null) {
    global $conn;
    
    if ($image_path) {
        $stmt = $conn->prepare("
            UPDATE news 
            SET title = ?, author = ?, intro_text = ?, full_text = ?, image_path = ?
            WHERE id = ? AND user_id = ?
        ");
        $params = [$title, $author, $intro_text, $full_text, $image_path, $id, getCurrentUserId()];
    } else {
        $stmt = $conn->prepare("
            UPDATE news 
            SET title = ?, author = ?, intro_text = ?, full_text = ?
            WHERE id = ? AND user_id = ?
        ");
        $params = [$title, $author, $intro_text, $full_text, $id, getCurrentUserId()];
    }
    
    return $stmt->execute($params);
}

function deleteNews($id) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ? AND user_id = ?");
    return $stmt->execute([$id, getCurrentUserId()]);
}

function searchNews($query) {
    global $conn;
    
    $searchTerm = "%{$query}%";
    $stmt = $conn->prepare("
        SELECT * FROM news 
        WHERE title LIKE ? OR author LIKE ? OR intro_text LIKE ? OR full_text LIKE ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function uploadImage($file) {
    $target_dir = __DIR__ . "/../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return false;
    }
    
    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        return false;
    }
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "/uploads/" . $new_filename;
    }
    
    return false;
}
?> 