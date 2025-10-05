<?php
if (!file_exists(__DIR__ . '/config.php')) {
    die("Missing config.php — copy config.sample.php to config.php and edit DB credentials.");
}
$config = include __DIR__ . '/config.php';

$conn = new mysqli($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
