<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header("Location: /login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin rozhraní</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Vítejte v administrátorském rozhraní</h1>
    </header>
    <nav>
        <ul>
            <li><a href="admin_orders.php">Správa objednávek</a></li>
            <li><a href="admin_users.php">Správa uživatelů</a></li>
            <li><a href="admin_reviews.php">Správa recenzí</a></li>
        </ul>
    </nav>
    <main>
        <h2>Vyberte sekci, kterou chcete spravovat:</h2>
        <p>Klikněte na jednu z možností v navigaci výše.</p>
    </main>
</body>
</html>