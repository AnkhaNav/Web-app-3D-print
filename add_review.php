<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)$_POST['rating'] ?? 0;
    $comment = trim($_POST['comment'] ?? '');

    if ($rating < 1 || $rating > 5 || empty($comment)) {
        $message = "Zadejte platné hodnocení a komentář.";
    } else {
        $stmt = $conn->prepare("INSERT INTO REVIEWS (user_id, rating, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_SESSION['user_id'], $rating, $comment);

        if ($stmt->execute()) {
            header("Location: index.php#reviews");
            exit;
        } else {
            $message = "Chyba při ukládání recenze.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Přidat recenzi</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .stars-input label {
      font-size: 2em;
      color: #ccc;
      cursor: pointer;
    }

    .stars-input input:checked ~ label,
    .stars-input input:hover ~ label {
      color: #FFD700;
    }

    .stars-input {
      direction: rtl;
      unicode-bidi: bidi-override;
      display: inline-flex;
    }

    .stars-input input {
      display: none;
    }

    .stars-input label:hover,
    .stars-input label:hover ~ label {
      color: #FFD700;
    }

    form {
      max-width: 500px;
      margin: 0 auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    textarea {
      width: 100%;
      height: 120px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-family: inherit;
      font-size: 1rem;
    }

    textarea::placeholder {
      font-family: inherit;
      font-size: 1rem;
      color: #777;
    }

    .message {
      color: red;
      margin-bottom: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
  <div class="review-form">
    <h2>Přidat recenzi</h2>
    <?php if ($message): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Vaše hodnocení:</label>
        <div class="stars-input">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>">
            <label for="star<?= $i ?>">★</label>
          <?php endfor; ?>
        </div>
      </div>
      <div class="form-group">
        <label for="comment">Komentář:</label>
        <textarea name="comment" id="comment" required placeholder="Napište, co se vám líbilo nebo nelíbilo..."></textarea>
      </div>
      <button type="submit">Odeslat recenzi</button>
      <a href="index.php#reviews" class="back-link">← Zpět na recenze</a>
    </form>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
