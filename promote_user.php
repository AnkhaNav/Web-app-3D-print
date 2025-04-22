<?php
require 'admin_check.php';
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    $stmt = $conn->prepare("UPDATE users SET is_admin = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

header("Location: admin_users.php");
exit;