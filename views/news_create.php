<?php
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: /login');
    exit;
}

include '../includes/header.php';
?>

<h1 class="mb-4">Új hír létrehozása</h1>

<form id="createNewsForm" method="POST" action="/api/news_create/" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Cím</label>
        <input type="text" class="form-control" id="title" name="title" required>
        <div class="invalid-feedback">Kérjük, adja meg a hír címét!</div>
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Szerző</label>
        <input type="text" class="form-control" id="author" name="author" required>
        <div class="invalid-feedback">Kérjük, adja meg a szerző nevét!</div>
    </div>

    <div class="mb-3">
        <label for="intro_text" class="form-label">Bevezető szöveg</label>
        <textarea class="form-control" id="intro_text" name="intro_text" rows="3" required></textarea>
        <div class="invalid-feedback">Kérjük, adja meg a bevezető szöveget!</div>
    </div>

    <div class="mb-3">
        <label for="full_text" class="form-label">Teljes szöveg</label>
        <textarea class="form-control" id="full_text" name="full_text" rows="10" required></textarea>
        <div class="invalid-feedback">Kérjük, adja meg a teljes szöveget!</div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Kép (PNG, JPEG)</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg" required>
        <div class="invalid-feedback">Kérjük, válasszon képet!</div>
    </div>

    <button type="submit" class="btn btn-primary">Létrehozás</button>
    <a href="/" class="btn btn-secondary">Mégse</a>
</form>

<?php include '../includes/footer.php'; ?> 