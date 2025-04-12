<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header("Location: /login.php");
    exit;
}

require 'db_connection.php';

$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa recenzí</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Správa recenzí</h1>
    </header>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Zpět na rozhraní</a></li>
        </ul>
    </nav>
    <main>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recenze</th>
                    <th>Hodnocení</th>
                    <th>Uživatel</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['review_text']; ?></td>
                    <td><?= $row['rating']; ?> / 5</td>
                    <td><?= $row['user_id']; ?></td>
                    <td>
                        <form method="POST" action="admin_reviews_action.php">
                            <input type="hidden" name="review_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>