<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$profile_picture = $user['profile_picture'];

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Můj účet</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>    
    <?php include 'header.php'; ?>
    <main>
        <div class="form-section">
            <section>
                <h2>Vítejte, <?= htmlspecialchars($user['user_name']); ?>!</h2>
                <p>Email: <?= htmlspecialchars($user['email']); ?></p>
            </section>

            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profilový obrázek" width="150" height="150">
            </div>

            <div class="links-container">
                <h2>Moje objednávky</h2>
                <a href="user_orders.php">Spravovat objednávky</a>
            
                <h2>Moje recenze</h2>
                
           
                <h2>Úprava profilu</h2>
                <a href="edit_profile.php">Upravit profil</a>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>