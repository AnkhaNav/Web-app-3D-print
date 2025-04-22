<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <form action="register_process.php" method="POST" class="form">
            <h2>Registrace uživatele</h2>
            <?php if (!empty($_SESSION['login_error'])): ?>
                <p class="error"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Uživatelské jméno:</label>
                <input type="text" id="username" name="username" required placeholder="Zadejte uživatelské jméno">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Zadejte svůj email">
            </div>
            <div class="form-group">
                <label for="password">Heslo:</label>
                <input type="password" id="password" name="password" required placeholder="Zadejte heslo">
            </div>
            <div class="form-group">
                <label for="confirm-password">Potvrďte heslo:</label>
                <input type="password" id="confirm-password" name="confirm-password" required placeholder="Potvrďte heslo">
            </div>
            <button type="submit" class="btn">Registrovat se</button>
            <div class="links-container">
                <p>Máte již účet? <a href="login.php">Přihlásit se</a></p>
            </div>
        </form>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>
