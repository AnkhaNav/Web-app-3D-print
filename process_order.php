<?php
require 'db_connection.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$material = trim($_POST['material'] ?? '');
$comments = trim($_POST['comments'] ?? '');

$modelFile  = $_FILES['model'] ?? null;

$uploadDir  = 'uploads/models/';

$uniqueName = uniqid() . '_' . basename($modelFile['name']);
$targetPath = $uploadDir . $uniqueName;

$errors = [];

if (empty($name)) {
    $errors[] = "Zadejte své jméno a příjmení.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Zadejte platný email.";
}
if (empty($phone)) {
    $errors[] = "Zadejte telefon.";
}
if (empty($material)) {
    $errors[] = "Vyberte materiál.";
}
if (!$modelFile || $modelFile['error'] !== UPLOAD_ERR_OK) {
    $errors[] = "Chyba při nahrávání souboru STL.";
}

if (!empty($errors)) {
    echo "<h3>Došlo k chybě:</h3>";
    foreach ($errors as $err) {
        echo "<p style='color:red;'>- $err</p>";
    }
    echo "<p><a href='form.php'>Zpět na formulář</a></p>";
    exit;
}

if (!move_uploaded_file($modelFile['tmp_name'], $targetPath)) {
    echo "<p style='color:red;'>Nepodařilo se uložit soubor.</p>";
    echo "<p><a href='form.php'>Zpět na formulář</a></p>";
    exit;
}

$sql = "INSERT INTO orders (name, email, phone, material, dimensions, model_path, comments) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<p style='color:red;'>Chyba při přípravě dotazu: " . $conn->error . "</p>";
    exit;
}

$stmt->bind_param("sssssss", $name, $email, $phone, $material, $dimensions, $uniqueName, $comments);
if ($stmt->execute()) {
    echo "<h3>Objednávka byla úspěšně odeslána!</h3>";
    echo "<p>Brzy se vám ozveme na email: <strong>" . htmlspecialchars($email) . "</strong></p>";
    echo "<p><a href='index.php'>Zpět na úvodní stránku</a></p>";
} else {
    echo "<p style='color:red;'>Chyba při ukládání objednávky: " . $stmt->error . "</p>";
    echo "<p><a href='form.php'>Zpět na formulář</a></p>";
}

$stmt->close();
$conn->close();
?>