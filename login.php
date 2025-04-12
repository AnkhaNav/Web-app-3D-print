<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlásit se</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="form-section">
            <h2>Přihlásit se</h2>
            <form action="login_process.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Uživatelské jméno</label>
                    <input type="text" id="username" name="username" required placeholder="Zadejte uživatelské jméno" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" required placeholder="Zadejte heslo" autocomplete="off">
                </div>
                <button type="submit" class="btn">Přihlásit se</button>
                <p>Nemáte účet? <a href="register.php">Registrovat se</a></p>
                <p><a href="forgot_password.php">Zapomněli jste heslo?</a></p>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>