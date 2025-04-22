<?php
require 'admin_check.php';
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['order_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['order_status'];

    $valid_statuses = ['čeká na potvrzení', 'zpracováno', 'zaplaceno', 'odesláno', 'dokončeno', 'zrušeno'];

    if (in_array($status, $valid_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
    }
}

header("Location: admin_orders.php");
exit;