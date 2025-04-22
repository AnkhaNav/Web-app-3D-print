<?php
require 'admin_check.php';
require 'db_connection.php';

$result = $conn->query("SELECT user_id, user_name, email, is_admin, registration_date FROM users ORDER BY registration_date DESC");
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Správa uživatelů</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th, .user-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .user-table th {
            background-color: #f4f4f4;
        }

        .admin-badge {
            background: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 0.85em;
        }

        .actions form {
            display: inline-block;
        }

        .actions button {
            padding: 5px 10px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>Správa uživatelů</h2>
    <a href="admin_dashboard.php" class="back-link">← Zpět na přehled administrace</a>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Uživatelské jméno</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Registrován</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <?php if ($row['is_admin']): ?>
                        <span class="admin-badge">ANO</span>
                    <?php else: ?>
                        NE
                    <?php endif; ?>
                </td>
                <td><?= date("j. n. Y H:i", strtotime($row['registration_date'])) ?></td>
                <td class="actions">
                    <?php if (!$row['is_admin']): ?>
                        <form action="promote_user.php" method="POST">
                            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                            <button type="submit">Povýšit na admina</button>
                        </form>
                    <?php endif; ?>
                    <?php if ($row['is_admin'] && $row['user_id'] !== $_SESSION['user_id']): ?>
                        <form action="demote_user.php" method="POST">
                            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                            <button type="submit" style="background-color: #ff9800; color: white;">Degradovat</button>
                        </form>
                    <?php endif; ?>
                    <form action="delete_user.php" method="POST" onsubmit="return confirm('Opravdu smazat uživatele?');">
                        <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                        <button type="submit" style="background-color: #d9534f; color: white;">Smazat</button>
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
