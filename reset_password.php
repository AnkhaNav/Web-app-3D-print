<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['reset_user_id']) || !isset($_SESSION['reset_time']) || time() - $_SESSION['reset_time'] > 600) {
    unset($_SESSION['reset_user_id']);
    unset($_SESSION['reset_time']);
    $_SESSION['reset_error'] = "Platnost odkazu vypršela. Zkuste to prosím znovu.";
    header("Location: forgot_password.php");
    exit;
}

$user_id = $_SESSION['reset_user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['new_password']);

    if (strlen($new_password) < 6) {
        $message = "Heslo musí mít alespoň 6 znaků.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();

        unset($_SESSION['reset_user_id']);
        unset($_SESSION['reset_time']);

        $_SESSION['login_success'] = "Heslo bylo úspěšně změněno. Nyní se můžete přihlásit.";
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Reset hesla</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <form method="POST" class="form">
            <h2>Obnova hesla</h2>
            <?php if ($message): ?>
                <p class="error"><?= $message ?></p>
            <?php endif; ?>
        
                <div class="form-group">
                    <label for="new_password">Nové heslo</label>
                    <input type="password" name="new_password" id="new_password" required placeholder="Zadejte nové heslo">
                </div>
                <button type="submit" class="btn">Nastavit nové heslo</button>
        </form>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>