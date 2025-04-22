<?php
require 'admin_check.php';
require 'db_connection.php';

$review_id = (int)($_POST['review_id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM REVIEWS WHERE review_id = ?");
$stmt->bind_param("i", $review_id);

if ($stmt->execute()) {
    header("Location: admin_reviews.php");
    exit;
} else {
    echo "Chyba při mazání recenze.";
}
?>