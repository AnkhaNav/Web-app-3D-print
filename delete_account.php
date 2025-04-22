<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['delete_account'])) {
    $delete_orders = $conn->prepare("DELETE FROM orders WHERE user_id = ?");
    $delete_orders->bind_param("i", $user_id);
    $delete_orders->execute();

    $delete_reviews = $conn->prepare("DELETE FROM reviews WHERE user_id = ?");
    $delete_reviews->bind_param("i", $user_id);
    $delete_reviews->execute();

    $delete_user = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $delete_user->bind_param("i", $user_id);
    $delete_user->execute();

    session_destroy();
    header("Location: goodbye.php");
    exit;
}
?>
