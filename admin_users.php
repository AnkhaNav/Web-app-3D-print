<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header("Location: /login.php");
    exit;
}

require 'db_connection.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa uživatelů</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Správa uživatelů</h1>
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
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['is_admin'] ? 'Admin' : 'Uživatel'; ?></td>
                    <td>
                        <form method="POST" action="admin_users_action.php">
                            <input type="hidden" name="user_id" value="<?= $row['id']; ?>">
                            <?php if ($row['is_active']) { ?>
                                <button type="submit" name="deactivate">Deaktivovat</button>
                            <?php } else { ?>
                                <button type="submit" name="activate">Aktivovat</button>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>