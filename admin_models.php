<?php
require 'admin_check.php';
require 'db_connection.php';

$stmt = $conn->prepare("
    SELECT m.model_id, m.name, m.material, m.color, m.width, m.height, m.depth, m.weight, m.file_path,
           m.order_id, o.email, o.order_date
    FROM models m
    JOIN orders o ON m.order_id = o.order_id
    ORDER BY o.order_date DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Správa modelů</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.admin-table th, table.admin-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        table.admin-table th {
            background-color: #f4f4f4;
        }

        .btn-delete {
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
    <h2>Správa modelů</h2>
    <a href="admin_dashboard.php" class="back-link">← Zpět na přehled administrace</a>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Název modelu</th>
                <th>Objednávka</th>
                <th>Email</th>
                <th>Materiál</th>
                <th>Barva</th>
                <th>Rozměry (mm)</th>
                <th>Hmotnost (g)</th>
                <th>Soubor</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['model_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>#<?= $row['order_id'] ?> <br><small><?= date("j. n. Y H:i", strtotime($row['order_date'])) ?></small></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['material'] ?></td>
                <td><?= $row['color'] ?></td>
                <td><?= $row['width'] ?>×<?= $row['height'] ?>×<?= $row['depth'] ?></td>
                <td><?= $row['weight'] ?></td>
                <td><a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">📂 Zobrazit</a></td>
                <td>
                    <form method="POST" action="delete_model.php" onsubmit="return confirm('Opravdu smazat tento model?');">
                        <input type="hidden" name="model_id" value="<?= $row['model_id'] ?>">
                        <button type="submit" class="btn-delete">Smazat</button>
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