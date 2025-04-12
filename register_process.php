<?php
require 'db_connection.php';
session_start();

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirm-password']);

if ($password !== $confirmPassword) {
    echo 'Hesla se neshodují.';
    echo "<br><a href='register.php'>Registrovat se</a>";
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $query = $conn->prepare('SELECT * FROM USERS WHERE email = ? OR user_name = ?');
    $query->bind_param('ss', $email, $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo 'Uživatel s tímto emailem nebo uživatelským jménem již existuje.';
        echo "<br><a href='register.php'>Registrovat se</a>";
    }

    $insert_query = $conn->prepare('INSERT INTO USERS (user_name, email, user_password) VALUES (?, ?, ?)');
    $insert_query->bind_param('sss', $username, $email, $hashed_password);

    if ($insert_query->execute()) {
        echo 'Registrace proběhla úspěšně! Nyní se můžete přihlásit.';
        echo "<br><a href='login.php'>Přihlásit se</a>";
        
    } else {
        echo 'Došlo k chybě při registraci. Zkuste to znovu.';
        echo "<br><a href='register.php'>Registrovat se</a>";
    }

} catch (PDOException $e) {
    error_log('Chyba při registraci: ' . $e->getMessage());
    echo 'Došlo k chybě při registraci. Zkuste to znovu.';
    echo "<br><a href='register.php'>Registrovat se</a>";
}
?>