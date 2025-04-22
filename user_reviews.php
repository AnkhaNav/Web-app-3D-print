<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT review_id, rating, comment, review_date FROM reviews WHERE user_id = ? ORDER BY review_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Moje recenze</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .reviews-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .user-review {
      background: #fff;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .user-review .stars {
      color: #FFD700;
      font-size: 1.2em;
      margin-bottom: 8px;
    }

    .user-review .date {
      font-size: 0.9em;
      color: #888;
    }

    .user-review .comment {
      margin: 10px 0;
    }

    .delete-btn {
      background: none;
      border: none;
      color: #d00;
      cursor: pointer;
      font-weight: bold;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
  <main>
    <div class="reviews-container">
      <h2 style="text-align: center;">Moje recenze</h2>
      <a href="account.php" class="back-link">← Zpět na účet</a>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="user-review">
            <div class="stars">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <?= $i <= $row['rating'] ? '★' : '☆' ?>
              <?php endfor; ?>
            </div>
            <div class="comment"><?= nl2br(htmlspecialchars($row['comment'])) ?></div>
            <div class="date"><?= date("j. n. Y H:i", strtotime($row['review_date'])) ?></div>
            <form method="POST" action="delete_review.php" onsubmit="return confirm('Opravdu chcete recenzi smazat?');">
              <input type="hidden" name="review_id" value="<?= $row['review_id'] ?>">
              <button type="submit" class="delete-btn">Smazat</button>
            </form>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align: center;">Zatím jste nenapsali žádnou recenzi.</p>
      <?php endif; ?>
    </div>
  </main>
<?php include 'footer.php'; ?>
</body>
</html>
