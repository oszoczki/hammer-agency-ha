<?php
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: /login');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$news = getNewsById($id);

if (!$news || $_SESSION['user']['id'] !== $news['user_id']) {
    header('Location: /');
    exit;
}

include '../includes/header.php';
?>

<h1 class="mb-4">Hír szerkesztése</h1>

<form id="editNewsForm" action="/api/news_edit/" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
    
    <div class="mb-3">
        <label for="title" class="form-label">Cím</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>
        <div class="invalid-feedback">Kérjük, adja meg a hír címét!</div>
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Szerző</label>
        <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($news['author']); ?>" required>
        <div class="invalid-feedback">Kérjük, adja meg a szerző nevét!</div>
    </div>

    <div class="mb-3">
        <label for="intro_text" class="form-label">Bevezető szöveg</label>
        <textarea class="form-control" id="intro_text" name="intro_text" rows="3" required><?php echo htmlspecialchars($news['intro_text']); ?></textarea>
        <div class="invalid-feedback">Kérjük, adja meg a bevezető szöveget!</div>
    </div>

    <div class="mb-3">
        <label for="full_text" class="form-label">Teljes szöveg</label>
        <textarea class="form-control" id="full_text" name="full_text" rows="10" required><?php echo htmlspecialchars($news['full_text']); ?></textarea>
        <div class="invalid-feedback">Kérjük, adja meg a teljes szöveget!</div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Kép</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <div class="form-text">Csak akkor válasszon új képet, ha lecserélné a meglévőt.</div>
    </div>

    <div class="mb-3">
        <img src="<?php echo htmlspecialchars($news['image_path']); ?>" class="img-thumbnail" alt="Jelenlegi kép" style="max-width: 200px;">
    </div>

    <button type="submit" class="btn btn-primary">Mentés</button>
    <a href="/news/<?php echo $news['id']; ?>" class="btn btn-secondary">Mégse</a>
</form>

<?php include '../includes/footer.php'; ?> 