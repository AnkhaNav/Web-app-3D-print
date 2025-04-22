<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['reset_user_id'] = $user['user_id'];
        $_SESSION['reset_time'] = time();

        header("Location: reset_password.php");
        exit;
    } else {
        $_SESSION['reset_error'] = "Tento e-mail nebyl nalezen.";
        header("Location: forgot_password.php");
        exit;
    }
} else {
    header("Location: forgot_password.php");
    exit;
}