<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT o.*, m.model_id, m.name AS model_name, m.material, m.color, m.file_path
    FROM orders o
    LEFT JOIN models m ON o.order_id = m.order_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'order_date' => $row['order_date'],
            'status' => $row['order_status'],
            'price' => $row['price'],
            'details' => $row['details'],
            'models' => []
        ];
    }
    if ($row['model_id']) {
        $orders[$order_id]['models'][] = [
            'name' => $row['model_name'],
            'material' => $row['material'],
            'color' => $row['color'],
            'file_path' => $row['file_path']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Moje objednávky</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .order-card {
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .orders-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .order-card.status-zaplaceno {
            background-color: #e6ffec;
        }

        .order-card.status-zruseno {
            background-color: #ffe6e6;
        }

        .order-card.status-default {
            background-color: #fffde7;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
        }

        .order-details {
            margin-top: 10px;
        }

        .models-list {
            margin-top: 10px;
            padding-left: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 6px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <h2 style="text-align: center;">Moje objednávky</h2>
        <?php
        $back_link = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] ? 'admin_dashboard.php' : 'account.php';
        ?>
        <div class="orders-container">
        <a href="<?= $back_link ?>" class="back-link">← Zpět na účet</a>
        <?php if (empty($orders)): ?>
            <p style="text-align: center;">Nemáte zatím žádné objednávky.</p>
        <?php else: ?>
            <?php foreach ($orders as $order_id => $order): ?>
                <?php
                    $statusClass = 'status-default';
                    if ($order['status'] === 'zaplaceno') {
                        $statusClass = 'status-zaplaceno';
                    } elseif ($order['status'] === 'zrušeno') {
                        $statusClass = 'status-zruseno';
                    }
                ?>
                <div class="order-card <?= $statusClass ?>">
                    <div class="order-header">
                        <strong>Objednávka č. <?= $order_id ?></strong>
                        <span><?= date("j. n. Y H:i", strtotime($order['order_date'])) ?></span>
                    </div>
                    <div class="order-details">
                        <p><strong>Stav:</strong> <?= htmlspecialchars($order['status']) ?></p>
                        <p><strong>Cena:</strong> <?= number_format($order['price'], 2, ',', ' ') ?> Kč</p>
                        <p><strong>Detaily:</strong><br><?= nl2br(htmlspecialchars($order['details'])) ?></p>
                        <?php if (!empty($order['models'])): ?>
                            <div class="models-list">
                                <strong>Modely:</strong>
                                <ul>
                                    <?php foreach ($order['models'] as $model): ?>
                                        <li>
                                            <a href="<?= htmlspecialchars($model['file_path']) ?>" download>
                                                <?= htmlspecialchars($model['name']) ?>
                                            </a>
                                            – <?= $model['material'] ?> (<?= $model['color'] ?>)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (in_array($order['status'], ['čeká na potvrzení', 'zpracováno'])): ?>
                            <div class="btn-row">
                                <a href="payment.php?id=<?= $order_id ?>" class="btn">Zaplatit</a>
                                <form action="cancel_order.php" method="POST" onsubmit="return confirm('Opravdu chcete objednávku zrušit?');">
                                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                    <button type="submit" class="btn cancel-btn">Stornovat</button>
                                </form>
                            </div>
                        <?php elseif ($order['status'] === 'zaplaceno'): ?>
                            <p style="color: green;"><strong>Objednávka je zaplacena.</strong></p>
                        <?php elseif ($order['status'] === 'zrušeno'): ?>
                            <p style="color: red;"><strong>Objednávka byla zrušena.</strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>
