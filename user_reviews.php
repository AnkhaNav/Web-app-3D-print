<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM reviews WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje recenze</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recenze</th>
                    <th>Hodnocení</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['review_id']) ?></td>
                        <td><?= htmlspecialchars($review['content']) ?></td>
                        <td><?= htmlspecialchars($review['rating']) ?>/5</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <form action="add_review.php" method="POST">
            <textarea name="content" placeholder="Napište recenzi" required></textarea>
            <input type="number" name="rating" min="1" max="5" placeholder="Hodnocení (1-5)" required>
            <button type="submit">Přidat recenzi</button>
        </form>
        <a href="account.php">Zpět na účet</a>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>