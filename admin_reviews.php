<?php
require 'admin_check.php';
require 'db_connection.php';

$stmt = $conn->prepare("SELECT r.review_id, r.rating, r.comment, r.review_date, u.user_name, u.profile_picture 
                        FROM reviews r
                        JOIN users u ON r.user_id = u.user_id
                        ORDER BY r.review_date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Správa recenzí</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .reviews-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .review-card {
            background-color: #fff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }

        .review-card .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .review-card .stars {
            color: #FFD700;
            font-size: 1.1em;
        }

        .review-card .comment {
            margin: 10px 0;
        }

        .review-card .meta {
            font-size: 0.9em;
            color: #666;
        }

        .review-card form {
            text-align: right;
        }

        .review-card button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .review-card button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <div class="reviews-container">
    <h2>Správa recenzí</h2>
    <a href="admin_dashboard.php" class="back-link">← Zpět na přehled administrace</a>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="review-card">
            <div class="header">
            <img src="<?= htmlspecialchars($row['profile_picture']) ?>" alt="Profilovka" class="profile-img">
                <strong><?= htmlspecialchars($row['user_name']) ?></strong>
                <span class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= $row['rating'] ? '★' : '☆' ?>
                    <?php endfor; ?>
                </span>
            </div>
            <div class="comment"><?= nl2br(htmlspecialchars($row['comment'])) ?></div>
            <div class="meta">Přidáno: <?= date("j. n. Y H:i", strtotime($row['review_date'])) ?></div>
            <form action="admin_delete_review.php" method="POST" onsubmit="return confirm('Opravdu smazat recenzi?');">
                <input type="hidden" name="review_id" value="<?= $row['review_id'] ?>">
                <button type="submit">Smazat recenzi</button>
            </form>
        </div>
    <?php endwhile; ?>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
