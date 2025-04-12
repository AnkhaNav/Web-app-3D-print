<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $image_path = 'uploads/profile/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $image_path);
    } else {
        $image_path = null;
    }

    $sql = "UPDATE users SET user_name = ?, email = ?, phone_number = ?, address = ?, profile_picture = COALESCE(?, profile_picture) WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $name, $email, $phone, $address, $image_path, $user_id);
    $stmt->execute();

    header("Location: account.php");
    exit;
}

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
    <title>Upravit profil</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
    <div class="form-section">
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="name">Jméno:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['user_name']); ?>" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <label for="phone">Telefon:</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone_number']) ?>">
            <label for="address">Adresa:</label>
            <textarea name="address" id="address"><?= htmlspecialchars($user['address']) ?></textarea>
            <label for="profile_picture">Profilový obrázek:</label>
            <img id="profileImage" src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profilový obrázek" width="150" height="150"><br>

            <div class="form-group">
                <input type="file" name="profile_picture" id="profile_picture" onchange="previewImage(event)">
            </div>

            <div id="image_preview" class="form-group" style="display: none;">
                <h3>Ukázka obrázku:</h3>
                <img id="preview" src="" alt="Profilový obrázek" style="max-width: 200px;">
            </div>

            <button type="submit">Uložit změny</button>
        </form>
        <form method="POST" action="delete_account.php" onsubmit="return confirm('Opravdu chcete svůj účet odstranit? Tuto akci nelze vrátit.')">
            <button type="submit" name="delete_account">Odstranit účet</button>
        </form>
        <a href="account.php">Zpět na účet</a>
    </main>
    </div>
    <?php include 'footer.php'; ?>
    <script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var existingImg = document.getElementById('profileImage');
            existingImg.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>
</body>
</html>