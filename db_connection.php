<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "database";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>