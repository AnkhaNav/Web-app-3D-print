<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Neplatný požadavek.']);
    exit;
}

$material = $_POST['material'] ?? '';
$allowed = ['PLA', 'PETG', 'ASA/ABS'];

if (!in_array($material, $allowed)) {
    echo json_encode(['error' => 'Neplatný materiál.']);
    exit;
}

if (!isset($_FILES['model']) || $_FILES['model']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Chyba při nahrávání souboru.']);
    exit;
}

$filename = $_FILES['model']['name'];
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

if (!in_array($extension, ['stl'])) {
    echo json_encode(['error' => 'Nepodporovaný formát souboru.']);
    exit;
}

$modelData = file_get_contents($_FILES['model']['tmp_name']);

$pythonPath = 'python';
$scriptPath = __DIR__ . DIRECTORY_SEPARATOR . 'analyze_model.py';

$escapedMaterial = escapeshellarg($material);
$escapedExtension = escapeshellarg($extension);
$command = "\"$pythonPath\" \"$scriptPath\" $escapedMaterial $escapedExtension";

$descriptorspec = [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
];

$process = proc_open($command, $descriptorspec, $pipes);

if (is_resource($process)) {
    fwrite($pipes[0], $modelData);
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $error = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    $return_value = proc_close($process);

    if ($return_value !== 0) {
        echo json_encode(['error' => "Chyba Python skriptu: $error"]);
        exit;
    }

    echo $output;
} else {
    echo json_encode(['error' => 'Nelze spustit skript.']);
}