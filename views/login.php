<?php
require_once '../includes/functions.php';

if (isLoggedIn()) {
    header('Location: /');
    exit;
}

include '../includes/header.php';
?>

<div class="auth-container">
    <h2 class="text-center mb-4">Bejelentkezés</h2>
    
    <form method="POST" action="/api/login">
        <div class="mb-3">
            <label for="username" class="form-label">Felhasználónév</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Bejelentkezés</button>
        </div>
    </form>
    
    <div class="text-center mt-3">
        <p>Még nincs fiókod? <a href="/register">Regisztrálj!</a></p>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 