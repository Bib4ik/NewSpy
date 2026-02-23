<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../database.php';
require_once __DIR__ . '/../../config.php';

$data = json_decode(file_get_contents('php://input'), true);

$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Email и пароль обязательны']);
    exit;
}

// Проверяем нет ли уже такого пользователя
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'Пользователь уже существует']);
    exit;
}

// Сохраняем пользователя
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
$stmt->execute([$email, $hash]);

echo json_encode(['message' => 'Регистрация успешна']);
