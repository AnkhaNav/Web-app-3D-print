<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit;
}

$name      = trim($_POST['name']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone']);
$material  = trim($_POST['material']);
$color     = trim($_POST['color']);
$comments  = trim($_POST['comments']);

if ($_FILES['model']['error'] !== UPLOAD_ERR_OK) {
    die("Chyba při nahrávání modelu.");
}

$uploadDir = 'uploads/models/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext = strtolower(pathinfo($_FILES['model']['name'], PATHINFO_EXTENSION));
$uniqueName = 'model_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
$filePath = $uploadDir . $uniqueName;

move_uploaded_file($_FILES['model']['tmp_name'], $filePath);

$pythonPath  = 'python';
$scriptPath  = 'analyze_model.py';
$fileType    = $ext;

$escapedMaterial  = escapeshellarg($material);
$escapedFileType  = escapeshellarg($fileType);

$command = "\"$pythonPath\" \"$scriptPath\" $escapedMaterial $escapedFileType < \"$filePath\"";

exec($command, $output, $returnCode);

if ($returnCode !== 0) {
    echo "<pre>Chyba při spuštění skriptu ($returnCode):\n" . htmlspecialchars(implode("\n", $output)) . "</pre>";
    exit;
}

$parsed = json_decode(implode('', $output), true);
if (!$parsed || isset($parsed['error'])) {
    echo "<pre>Chyba při zpracování modelu:\n" . htmlspecialchars(json_encode($parsed, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "</pre>";
    exit;
}

$width   = (float)$parsed['width_mm'];
$height  = (float)$parsed['height_mm'];
$depth   = (float)$parsed['depth_mm'];
$weight  = (float)$parsed['weight'];
$price   = (float)$parsed['price_estimate'];
$volume  = $parsed['volume_cm3'] ?? 0;

$details = "Materiál: $material\nObjem: $volume cm³\nPoznámky: $comments";

$user_id = $_SESSION['user_id'] ?? null;

$stmt = $conn->prepare("INSERT INTO orders (user_id, email, order_status, price, details) VALUES (?, ?, 'čeká na potvrzení', ?, ?)");
$stmt->bind_param("isds", $user_id, $email, $price, $details);
$stmt->execute();
$order_id = $stmt->insert_id;

$stmt = $conn->prepare("INSERT INTO models (order_id, name, file_path, width, height, depth, weight, material, color) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issdddsss", $order_id, $uniqueName, $filePath, $width, $height, $depth, $weight, $material, $color);
$stmt->execute();

if ($user_id) {
    $_SESSION['order_success'] = "Objednávka byla úspěšně odeslána a zpracována.";
    header("Location: user_orders.php");
    exit;
} else {
    header("Location: guest_payment.php?id=$order_id");
    exit;
}
