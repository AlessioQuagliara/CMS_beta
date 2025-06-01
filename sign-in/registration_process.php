<?php

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['role']) || !in_array($data['role'], ['admin', 'user'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Basic email validation
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

// Basic password strength validation
if (strlen($data['password']) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'Password must be at least 6 characters']);
    exit;
}

// Hash the password
$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
$data['created_at'] = date('c');

$db = new SQLite3('../db/database.db');
$table = $data['role'] === 'admin' ? 'admins' : 'users';

// Check if username or email already exists
$checkStmt = $db->prepare("SELECT COUNT(*) as count FROM $table WHERE username = :username OR email = :email");
$checkStmt->bindValue(':username', $data['username'], SQLITE3_TEXT);
$checkStmt->bindValue(':email', $data['email'], SQLITE3_TEXT);
$result = $checkStmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    http_response_code(409);
    echo json_encode(['error' => 'User already exists']);
    exit;
}

if ($data['role'] === 'admin') {
    $stmt = $db->prepare("INSERT INTO admins (username, email, first_name, last_name, password, created_at) VALUES (:username, :email, :first_name, :last_name, :password, :created_at)");
    $stmt->bindValue(':first_name', $data['first_name'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':last_name', $data['last_name'] ?? '', SQLITE3_TEXT);
} else {
    $stmt = $db->prepare("INSERT INTO users (username, email, first_name, last_name, password, billing_name, billing_address, billing_city, billing_postal_code, billing_country, billing_vat, created_at)
        VALUES (:username, :email, :first_name, :last_name, :password, :billing_name, :billing_address, :billing_city, :billing_postal_code, :billing_country, :billing_vat, :created_at)");
    $stmt->bindValue(':first_name', $data['first_name'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':last_name', $data['last_name'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_name', $data['billing_name'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_address', $data['billing_address'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_city', $data['billing_city'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_postal_code', $data['billing_postal_code'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_country', $data['billing_country'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':billing_vat', $data['billing_vat'] ?? '', SQLITE3_TEXT);
}

$stmt->bindValue(':username', $data['username'], SQLITE3_TEXT);
$stmt->bindValue(':email', $data['email'], SQLITE3_TEXT);
$stmt->bindValue(':password', $data['password'], SQLITE3_TEXT);
$stmt->bindValue(':created_at', $data['created_at'], SQLITE3_TEXT);

$stmt->execute();

echo json_encode(['success' => true]);