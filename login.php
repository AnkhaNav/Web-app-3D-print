<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <form action="login_process.php" method="POST" class="form">
            <h2>Přihlášení do účtu</h2>

            <?php if (!empty($_SESSION['login_error'])): ?>
                <p class="error"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Zadejte svůj e-mail" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Heslo:</label>
                <input type="password" id="password" name="password" required placeholder="Zadejte heslo" autocomplete="off">
            </div>
            <button type="submit" class="btn">Přihlásit se</button>
            <div class="links-container">
                <p>Nemáte účet? <a href="register.php">Registrovat se</a></p>
                <p><a href="forgot_password.php">Zapomněli jste heslo?</a></p>
            </div>
        </form>    
    </main>
<?php include 'footer.php'; ?>
</body>
</html>
