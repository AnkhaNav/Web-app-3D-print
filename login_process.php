<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Vyplňte prosím přihlašovací údaje.";
        header("Location: login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['is_admin'] = $user['is_admin'];

            if ($user['is_admin']) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $_SESSION['login_error'] = "Neplatné údaje.";
        }
    } else {
        $_SESSION['login_error'] = "Neplatné údaje.";
    }

    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
