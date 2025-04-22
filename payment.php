<?php
require 'session_check.php';
require 'db_connection.php';

$order_id = (int)($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Objednávka nebyla nalezena nebo vám nepatří.");
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Simulace platby</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <section class="form">
            <h2>Simulace platby</h2>
            <div class="form-group">
                <p><strong>Číslo objednávky:</strong> <?= $order_id ?></p>
                <p><strong>Cena:</strong> <?= number_format($order['price'], 2, ',', ' ') ?> Kč</p>
                <p><strong>Stav:</strong> <?= htmlspecialchars($order['order_status']) ?></p>
            </div>
            <?php if ($order['order_status'] === 'zaplaceno'): ?>
                <p class="success"><strong>Objednávka je již zaplacena.</strong></p>
            <?php else: ?>
                <form action="payment_process.php" method="POST">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                    <button type="submit" class="btn">Zaplatit nyní</button>
                </form>
            <?php endif; ?>
            <div class="links-container">
                <a href="user_orders.php" class="back-link">← Zpět na objednávky</a>
            </div>
        </section>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>