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
            <h2>Obnovit heslo</h2>
            <form action="send_reset_link.php" method="POST" class="forgot-password-form">
                <div class="form-group">
                    <label for="email">Zadejte svůj email</label>
                    <input type="email" id="email" name="email" required placeholder="Zadejte email pro obnovení hesla">
                </div>
                <button type="submit" class="btn">Odeslat odkaz pro obnovení hesla</button>
                <p>Máte účet? <a href="login.php">Přihlásit se</a></p>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>