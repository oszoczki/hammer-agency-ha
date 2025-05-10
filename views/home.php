<?php
require_once '../includes/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;
$offset = ($page - 1) * $per_page;

$news = getAllNews($per_page, $offset);
$total_news = count(getAllNews());
$total_pages = ceil($total_news / $per_page);

include '../includes/header.php';
?>

<h1 class="mb-4">Legfrissebb hírek</h1>

<?php if (empty($news)): ?>
    <div class="alert alert-info">
        Jelenleg nincs elérhető hír. Kérjük, látogasson vissza később!
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($news as $item): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card news-card">
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="card-img-top news-image" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <div class="card-body">
                    <h5 class="card-title news-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                    <div class="news-meta">
                        <small>
                            Szerző: <?php echo htmlspecialchars($item['author']); ?><br>
                            Közzétéve: <?php echo date('Y.m.d H:i', strtotime($item['created_at'])); ?>
                        </small>
                    </div>
                    <p class="card-text news-intro"><?php echo htmlspecialchars($item['intro_text']); ?></p>
                    <a href="/news/<?php echo $item['id']; ?>" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <nav aria-label="Oldal navigáció" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
<?php endif; ?>

<?php include '../includes/footer.php'; ?> 