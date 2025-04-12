<?php
require 'db_connection.php';
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

try {
    $stmt = $conn->prepare("SELECT * FROM USERS WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['user_password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['user_name'];
        echo'Přihlášení proběhlo úspěšně.';
        echo "<br><a href='account.php'>Do účtu</a>";
    } else {
        echo 'Nesprávné uživatelské jméno nebo heslo.';
        echo "<br><a href='login.php'>Přihlásit se</a>";
    }

} catch (PDOException $e) {
    echo 'Došlo k chybě při přihlašování. Zkuste to znovu.';
    echo "<br><a href='login.php'>Přihlásit se</a>";
}
?>