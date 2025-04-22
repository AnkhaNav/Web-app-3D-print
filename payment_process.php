<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id'];
    $user_id = $_SESSION['user_id'] ?? null;

    $stmt = $conn->prepare("UPDATE orders SET order_status = 'zaplaceno' WHERE order_id = ? AND order_status IN ('čeká na potvrzení', 'zpracováno')");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    if ($user_id) {
        $_SESSION['payment_success'] = "Objednávka byla úspěšně zaplacena.";
        header("Location: user_orders.php");
    } else {
        header("Location: guest_confirmation.php?id=$order_id");
    }
    exit;
}