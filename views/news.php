<?php
require_once '../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$news = getNewsById($id);

if (!$news) {
    $_SESSION['error'] = 'Hír nem található';
    header('Location: /');
    exit;
}

include '../includes/header.php';
?>

<div class="news-full">
    <h1 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h1>
    
    <div class="news-meta mb-4">
        <small>
            Szerző: <?php echo htmlspecialchars($news['author']); ?><br>
            Közzétéve: <?php echo date('Y.m.d H:i', strtotime($news['created_at'])); ?>
        </small>
    </div>
    
    <img src="<?php echo htmlspecialchars($news['image_path']); ?>" class="img-fluid mb-4" alt="<?php echo htmlspecialchars($news['title']); ?>">
    
    <div class="news-intro mb-4">
        <p class="lead"><?php echo htmlspecialchars($news['intro_text']); ?></p>
    </div>
    
    <div class="news-content">
        <?php echo nl2br(htmlspecialchars($news['full_text'])); ?>
    </div>
</div>
<?php if (isLoggedIn() && $news['user_id'] === getCurrentUserId()): ?>
    <div class="btn-group mt-4">
        <a href="/news/edit/<?php echo $news['id']; ?>" class="btn btn-primary flex-grow-1">Szerkesztés</a>
        <button type="button" class="btn btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteModal">Törlés</button>
    </div>
    
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hír törlése</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Biztosan törölni szeretnéd ezt a hírt?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                    <form action="/api/news_delete/" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                        <button type="submit" class="btn btn-danger">Törlés</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php include '../includes/footer.php'; ?> 