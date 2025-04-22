<?php
require 'db_connection.php';
session_start();

$order_id = $_GET['id'] ?? null;

if (!$order_id || !is_numeric($order_id)) {
    echo "Neplatné ID objednávky.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id IS NULL");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Objednávka nenalezena nebo již přiřazena k účtu.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Platba objednávky</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
  <main>
    <div class="form">
      <h2>Platba objednávky č. <?= $order_id ?></h2>
      <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
      <p><strong>Cena:</strong> <?= number_format($order['price'], 2, ',', ' ') ?> Kč</p>
      <p><strong>Stav:</strong> <?= htmlspecialchars($order['order_status']) ?></p>

      <?php if (in_array($order['order_status'], ['čeká na potvrzení', 'zpracováno'])): ?>
      <form method="POST" action="payment_process.php">
          <input type="hidden" name="order_id" value="<?= $order_id ?>">
          <button type="submit" class="btn">Zaplatit objednávku</button>
      </form>
    </div>
    <?php else: ?>
      <p>Objednávku již nelze zaplatit.</p>
    <?php endif; ?>
  </main>
<?php include 'footer.php'; ?>
</body>
</html>