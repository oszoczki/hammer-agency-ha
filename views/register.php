<?php
require_once '../includes/functions.php';

if (isLoggedIn()) {
    header('Location: /');
    exit;
}

include '../includes/header.php';
?>

<div class="auth-container">
    <h2 class="text-center mb-4">Regisztráció</h2>
    
    <form method="POST" action="/api/register">
        <div class="mb-3">
            <label for="username" class="form-label">Felhasználónév</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email cím</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="form-text">A jelszónak legalább 6 karakter hosszúnak kell lennie.</div>
        </div>
        
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Jelszó megerősítése</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Regisztráció</button>
        </div>
    </form>
    
    <div class="text-center mt-3">
        <p>Már van fiókod? <a href="/login">Jelentkezz be!</a></p>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 