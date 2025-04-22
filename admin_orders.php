<?php
require 'admin_check.php';
require 'db_connection.php';

$stmt = $conn->prepare("
    SELECT o.order_id, o.user_id, o.email, o.order_date, o.order_status, o.price, u.user_name
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Správa objednávek</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table.admin-table th, table.admin-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table.admin-table th {
            background-color: #f4f4f4;
        }

        .action-form {
            display: inline-block;
            margin: 0;
        }

        .action-form select, .action-form button {
            padding: 5px;
        }

        .delete-btn {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>Správa objednávek</h2>
    <a href="admin_dashboard.php" class="back-link">← Zpět na přehled administrace</a>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Uživatel</th>
                <th>Datum</th>
                <th>Stav</th>
                <th>Cena</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['user_name'] ?? '<i>nepřihlášený</i>' ?></td>
                <td><?= date("j. n. Y H:i", strtotime($row['order_date'])) ?></td>
                <td>
                    <form method="POST" action="update_order_status.php" class="action-form">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <select name="order_status">
                            <?php
                            $statuses = ['čeká na potvrzení', 'zpracováno', 'zaplaceno', 'odesláno', 'dokončeno', 'zrušeno'];
                            foreach ($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= $row['order_status'] === $status ? 'selected' : '' ?>>
                                    <?= $status ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Uložit</button>
                    </form>
                </td>
                <td><?= number_format($row['price'], 2, ',', ' ') ?> Kč</td>
                <td>
                    <form method="POST" action="delete_order.php" class="action-form" onsubmit="return confirm('Opravdu smazat objednávku?');">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <button type="submit" class="delete-btn">Smazat</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
