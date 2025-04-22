<?php
require 'db_connection.php';
$order_id = $_GET['id'] ?? null;

if (!$order_id || !is_numeric($order_id)) {
    echo "Neplatné ID.";
    exit;
}

$stmt = $conn->prepare("SELECT email FROM orders WHERE order_id = ? AND user_id IS NULL");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Objednávka nenalezena.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Potvrzení platby</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <div class="form">
            <h2>Děkujeme za platbu!</h2>
            <p>Vaše objednávka č. <?= $order_id ?> byla úspěšně zaplacena.</p>
            <p>O objednávce Vás budeme informovat na váš mail: <?= htmlspecialchars($order['email']) ?></p>
            <a href="index.php" class="back-link">Zpět na hlavní stránku</a>
        </div>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>