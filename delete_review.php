<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$review_id = (int)($_POST['review_id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM REVIEWS WHERE review_id = ? AND user_id = ?");
$stmt->bind_param("ii", $review_id, $user_id);

if ($stmt->execute()) {
    header("Location: user_reviews.php");
    exit;
} else {
    echo "Chyba při mazání recenze.";
}
?>