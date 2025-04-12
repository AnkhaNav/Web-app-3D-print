<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $order_id = $_POST['order_id'];
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        header("Location: admin_orders.php");
        exit;
    }

    if (isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $order_id);
        $stmt->execute();
        header("Location: admin_orders.php");
        exit;
    }
}
?>