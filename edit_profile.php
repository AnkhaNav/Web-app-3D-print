<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old_password = trim($_POST['old_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');

    $updatePassword = false;

    if (!empty($old_password) && !empty($new_password)) {
        $stmt_pwd = $conn->prepare("SELECT user_password FROM users WHERE user_id = ?");
        $stmt_pwd->bind_param('i', $user_id);
        $stmt_pwd->execute();
        $result_pwd = $stmt_pwd->get_result();
        $user_pwd = $result_pwd->fetch_assoc();

        if (password_verify($old_password, $user_pwd['user_password'])) {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt_update_pwd = $conn->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
            $stmt_update_pwd->bind_param("si", $new_hashed, $user_id);
            $stmt_update_pwd->execute();
            $updatePassword = true;
        } else {
            $_SESSION['profile_error'] = "Stávající heslo je nesprávné.";
            header("Location: edit_profile.php");
            exit;
        }
    }


    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['profile_picture']['size'] <= 2 * 1024 * 1024 &&
            in_array(mime_content_type($_FILES['profile_picture']['tmp_name']), ['image/jpeg', 'image/png', 'image/gif'])) {
    
            $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $newFileName = 'user_' . $user_id . '_' . time() . '.' . $extension;
            $image_path = 'uploads/profile/' . $newFileName;
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $image_path);
        } else {
            $image_path = null;
        }
    }

    $sql = "UPDATE users SET user_name = ?, email = ?, phone_number = ?, address = ?, profile_picture = COALESCE(?, profile_picture) WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $name, $email, $phone, $address, $image_path, $user_id);
    $stmt->execute();

    $_SESSION['profile_updated'] = "Profil byl úspěšně upraven.";
    if ($updatePassword) {
        $_SESSION['profile_updated'] .= " Heslo bylo změněno.";
    }
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
    <link rel="stylesheet" href="css/styles.css">
    <style>
      .profile-edit {
        max-width: 600px;
        margin: 0 auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      }

      .profile-picture-preview {
        text-align: center;
        margin: 15px 0;
      }

      .profile-picture-preview img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #ccc;
      }

      h3 {
        margin-top: 30px;
      }

      form button[type="submit"] {
        margin-top: 20px;
      }

      form + form {
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
  <?php include 'header.php'; ?>
    <main>
      <?php if (!empty($_SESSION['profile_error'])): ?>
        <p class="error"><?= $_SESSION['profile_error']; unset($_SESSION['profile_error']); ?></p>
      <?php endif; ?>
      <div class="profile-edit">
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Jméno:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['user_name']); ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
          </div>
          <h3>Změna hesla</h3>
          <div class="form-group">
            <label for="old_password">Stávající heslo:</label>
            <input type="password" name="old_password" id="old_password" placeholder="Zadejte stávající heslo">
          </div>
          <div class="form-group">
            <label for="new_password">Nové heslo:</label>
            <input type="password" name="new_password" id="new_password" placeholder="Zadejte nové heslo">
          </div>
          <div class="form-group">
            <label for="phone">Telefon:</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone_number']) ?>">
          </div>
          <div class="form-group">
            <label for="address">Adresa:</label>
            <textarea name="address" id="address"><?= htmlspecialchars($user['address']) ?></textarea>
          </div>
          <div class="form-group">
            <label for="profile_picture">Profilový obrázek:</label>
            <div class="profile-picture-preview">
              <img id="profileImage" src="<?= htmlspecialchars($profile_picture); ?>" alt="Profilový obrázek">
            </div>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(event)">
          </div>
          <button type="submit">Uložit změny</button>
        </form>
        <form method="POST" action="delete_account.php" onsubmit="return confirm('Opravdu chcete svůj účet odstranit? Tuto akci nelze vrátit.')">
          <button type="submit" name="delete_account" class="btn" style="background-color: #d9534f;">Odstranit účet</button>
        </form>
        <?php
        $back_link = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] ? 'admin_dashboard.php' : 'account.php';
        ?>
        <a href="<?= $back_link ?>" class="back-link">← Zpět na účet</a>
      </div>
    </main>
  <?php include 'footer.php'; ?>
  <script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
      const preview = document.getElementById('profileImage');
      preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
  </script>
  </body>
</html>
