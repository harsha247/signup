<?php
header('Content-Type: application/json');

// Replace with your DB credentials
$host = 'localhost';
$db   = 'signupdb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Read the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Basic server-side validation
if (
  empty($data['name']) ||
  empty($data['email']) ||
  empty($data['mobile']) ||
  empty($data['address']) ||
  empty($data['password'])
) {
  echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
  exit;
}

// Create PDO connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  // Prepare insert
  $stmt = $pdo->prepare("INSERT INTO users (name, email, mobile, address, password) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([
    $data['name'],
    $data['email'],
    $data['mobile'],
    $data['address'],
    $data['password']
  ]);

  echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
} catch (Exception $e) {
  echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
}
