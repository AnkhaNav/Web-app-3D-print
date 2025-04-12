<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO reviews (user_id, content, rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isi', $user_id, $content, $rating);
    $stmt->execute();

    header("Location: user_reviews.php");
    exit;
}
?>