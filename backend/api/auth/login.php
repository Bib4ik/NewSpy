<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../database.php';
require_once __DIR__ . '/../../config.php';

use Firebase\JWT\JWT;

$data = json_decode(file_get_contents('php://input'), true);

$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Email и пароль обязательны']);
    exit;
}

// Ищем пользователя в БД
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Проверяем пароль
if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Неверный email или пароль']);
    exit;
}

// Создаём JWT токен
$payload = [
    'userId' => $user['id'],
    'email'  => $user['email'],
    'exp'    => time() + JWT_EXPIRES
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode(['token' => $token]);
