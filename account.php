<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'db_connection.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT user_name, profile_picture FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Můj účet</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .account-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            text-align: center;
        }

        .account-box img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 2px solid #ccc;
        }

        .account-box h2 {
            margin-bottom: 10px;
        }

        .account-links {
            margin-top: 20px;
        }

        .account-links a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            border-radius: 6px;
            background-color: #f4f4f4;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .account-links a:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <div class="account-box">
        <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profilový obrázek">
        <h2><?= htmlspecialchars($user['user_name']) ?></h2>
        <div class="account-links">
            <a href="user_orders.php">Moje objednávky</a>
            <a href="user_reviews.php">Moje recenze</a>
            <a href="edit_profile.php">Upravit profil</a>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
