<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header("Location: /login.php");
    exit;
}

require 'db_connection.php';

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa objednávek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Správa objednávek</h1>
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
                    <th>ID Objednávky</th>
                    <th>Uživatel</th>
                    <th>Email</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= $row['user_id'] ?: 'Nepřihlášený'; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['order_date']; ?></td>
                    <td>
                        <form method="POST" action="admin_orders_action.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= $row['order_id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Čekající</option>
                                <option value="In Progress" <?= $row['status'] === 'In Progress' ? 'selected' : ''; ?>>Probíhá</option>
                                <option value="Completed" <?= $row['status'] === 'Completed' ? 'selected' : ''; ?>>Dokončeno</option>
                                <option value="Cancelled" <?= $row['status'] === 'Cancelled' ? 'selected' : ''; ?>>Zrušeno</option>
                            </select>
                        </form>
                    </td>
                    <td><?= $row['total_price']; ?> Kč</td>
                    <td>
                        <form method="POST" action="admin_orders_action.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= $row['order_id']; ?>">
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