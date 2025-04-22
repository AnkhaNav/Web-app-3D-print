<?php
require 'admin_check.php';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin rozhraní</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .admin-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            max-width: 1200px;
            margin: 40px auto;
        }

        .admin-dashboard, .admin-account {
            flex: 1 1 400px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .admin-dashboard h2,
        .admin-account h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .admin-links a,
        .admin-account nav a {
            display: block;
            margin: 10px 0;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.2s;
            text-align: center;
        }

        .admin-links a:hover,
        .admin-account nav a:hover {
            background-color: #0056b3;
        }

        .admin-account {
            text-align: center;
        }

        .admin-account img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
            margin-bottom: 10px;
        }

        .admin-account h3 {
            margin: 10px 0;
            font-size: 1.2rem;
        }

        .admin-account nav {
            margin-top: 15px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <div class="admin-wrapper">
        <div class="admin-account">
            <img src="<?= htmlspecialchars($_SESSION['profile_picture'] ?? 'uploads/profile/default_profile.jpg') ?>" alt="Profilový obrázek">
            <h3><?= htmlspecialchars($_SESSION['username']) ?></h3>
            <nav>
                <a href="user_orders.php">Moje objednávky</a>
                <a href="user_reviews.php">Moje recenze</a>
                <a href="edit_profile.php">Upravit profil</a>
            </nav>
        </div>
        <div class="admin-dashboard">
            <h2>Administrátorské rozhraní</h2>
            <div class="admin-links">
                <a href="admin_users.php">Správa uživatelů</a>
                <a href="admin_orders.php">Správa objednávek</a>
                <a href="admin_models.php">Správa modelů</a>
                <a href="admin_reviews.php">Správa recenzí</a>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
