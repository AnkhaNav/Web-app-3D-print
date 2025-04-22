<?php
require 'admin_check.php';
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['model_id'])) {
    $model_id = (int)$_POST['model_id'];

    $stmt_path = $conn->prepare("SELECT file_path FROM models WHERE model_id = ?");
    $stmt_path->bind_param("i", $model_id);
    $stmt_path->execute();
    $result = $stmt_path->get_result();
    if ($row = $result->fetch_assoc()) {
        $file_path = $row['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $stmt = $conn->prepare("DELETE FROM models WHERE model_id = ?");
    $stmt->bind_param("i", $model_id);
    $stmt->execute();
}

header("Location: admin_models.php");
exit;